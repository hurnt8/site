<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class SiteAssetsController extends Controller
{
    /**
     * Icone PWA carree derivee du logo televerse par l administrateur.
     *
     * Les manifests pointaient vers /images/icon-*.png, des fichiers statiques : le logo
     * configure en admin n apparaissait donc jamais sur l ecran d accueil. On genere ici
     * l icone a la volee, sur un aplat bleu de marque, avec une marge de securite pour
     * l affichage "maskable" (Android rogne les bords en cercle).
     *
     * Le rendu est mis en cache sur disque ; la cle integre la date du fichier source,
     * donc un nouveau televersement invalide automatiquement l ancienne icone.
     */
    public function siteIcon(int $size)
    {
        // 16 et 32 sont les tailles de favicon usuelles : on descend jusque-la,
        // sinon un favicon 16px serait genere en 48 puis reduit par le navigateur.
        $size    = max(16, min(1024, $size));
        $contact = site_identity();
        $disk    = Storage::disk('public');

        // On retient la premiere variante dont le FICHIER existe reellement : un chemin
        // peut rester en base alors que l image a disparu du disque.
        $rel = null;
        foreach (array_filter([$contact?->logo_light_path, $contact?->logo_dark_path]) as $candidate) {
            if ($disk->exists($candidate)) {
                $rel = $candidate;
                break;
            }
        }

        if (! $rel) {
            // Aucun logo configure : on sert l icone statique historique.
            $fallback = public_path('images/icon-' . ($size > 192 ? 512 : 192) . '.png');
            abort_unless(is_file($fallback), 404);

            return response()->file($fallback, ['Cache-Control' => 'public, max-age=3600']);
        }

        $cacheFile = storage_path(
            'app/site-icons/' . md5($rel . '|' . $disk->lastModified($rel)) . "-{$size}.png"
        );

        if (! is_file($cacheFile)) {
            @mkdir(dirname($cacheFile), 0775, true);

            $src = @imagecreatefromstring($disk->get($rel));
            abort_unless($src !== false, 404);

            // Beaucoup de logos sont livres avec une large marge vide. Sans la retirer,
            // le contenu utile n occupe qu une fraction du cadre et devient illisible en
            // 16 ou 32 px. On detecte la couleur de fond aux quatre coins et on rogne les
            // bords uniformes avant de redimensionner.
            [$sx, $sy, $sw, $sh] = $this->trimUniformBorder($src);

            // En favicon (16-48 px), un logotype large est illisible : le texte se
            // reduit a une bouillie de pixels. On garde alors le seul symbole, place
            // par convention a gauche du texte, via un recadrage carre sur ce bord.
            if ($size <= 48 && $sh > 0 && ($sw / $sh) > 1.5) {
                $sw = $sh;
            }

            $canvas = imagecreatetruecolor($size, $size);
            imagefill($canvas, 0, 0, imagecolorallocate($canvas, 0x2A, 0x19, 0x67));

            // Un logo deja carre est presque toujours une icone concue comme telle :
            // on remplit le cadre. Un logotype large est encastre a 80% pour survivre
            // au rognage circulaire d Android (maskable).
            $isSquare = $sh > 0 && abs(($sw / $sh) - 1) < 0.1;
            $box      = (int) round($size * ($isSquare ? 1.0 : 0.80));
            $ratio = min($box / $sw, $box / $sh);
            $dw    = (int) round($sw * $ratio);
            $dh    = (int) round($sh * $ratio);

            imagecopyresampled(
                $canvas, $src,
                (int) (($size - $dw) / 2), (int) (($size - $dh) / 2),
                $sx, $sy, $dw, $dh, $sw, $sh
            );

            imagepng($canvas, $cacheFile, 9);
            imagedestroy($canvas);
            imagedestroy($src);
        }

        return response()->file($cacheFile, [
            'Content-Type'  => 'image/png',
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }

    /**
     * Detecte et retire la marge uniforme autour d un logo.
     *
     * Retourne [x, y, largeur, hauteur] de la zone utile. Si les quatre coins ne
     * s accordent pas sur une couleur de fond, ou si le rognage donnerait une zone
     * degeneree, l image entiere est renvoyee telle quelle.
     */
    private function trimUniformBorder($img): array
    {
        $w = imagesx($img);
        $h = imagesy($img);

        $corners = [
            imagecolorat($img, 0, 0),
            imagecolorat($img, $w - 1, 0),
            imagecolorat($img, 0, $h - 1),
            imagecolorat($img, $w - 1, $h - 1),
        ];

        $rgb = static fn (int $c): array => [($c >> 16) & 0xFF, ($c >> 8) & 0xFF, $c & 0xFF];
        $diff = static function (array $a, array $b): int {
            return abs($a[0] - $b[0]) + abs($a[1] - $b[1]) + abs($a[2] - $b[2]);
        };

        $bg = $rgb($corners[0]);
        foreach ($corners as $c) {
            // Coins discordants : pas de marge uniforme identifiable.
            if ($diff($rgb($c), $bg) > 24) {
                return [0, 0, $w, $h];
            }
        }

        $tol  = 40;   // tolerance au bruit de compression
        $step = max(1, (int) floor(min($w, $h) / 400)); // echantillonnage sur grandes images

        $rowIsBg = function (int $y) use ($img, $w, $bg, $rgb, $diff, $tol, $step): bool {
            for ($x = 0; $x < $w; $x += $step) {
                if ($diff($rgb(imagecolorat($img, $x, $y)), $bg) > $tol) {
                    return false;
                }
            }
            return true;
        };
        $colIsBg = function (int $x) use ($img, $h, $bg, $rgb, $diff, $tol, $step): bool {
            for ($y = 0; $y < $h; $y += $step) {
                if ($diff($rgb(imagecolorat($img, $x, $y)), $bg) > $tol) {
                    return false;
                }
            }
            return true;
        };

        $top = 0;        while ($top < $h - 1 && $rowIsBg($top))        { $top++; }
        $bottom = $h - 1; while ($bottom > $top && $rowIsBg($bottom))   { $bottom--; }
        $left = 0;       while ($left < $w - 1 && $colIsBg($left))      { $left++; }
        $right = $w - 1; while ($right > $left && $colIsBg($right))     { $right--; }

        $nw = $right - $left + 1;
        $nh = $bottom - $top + 1;

        // Rognage aberrant (image unie, ou contenu minuscule) : on garde l original.
        if ($nw < $w * 0.05 || $nh < $h * 0.05) {
            return [0, 0, $w, $h];
        }

        // Petite respiration autour du contenu.
        $pad   = (int) round(min($nw, $nh) * 0.06);
        $left  = max(0, $left - $pad);
        $top   = max(0, $top - $pad);
        $nw    = min($w - $left, $nw + 2 * $pad);
        $nh    = min($h - $top,  $nh + 2 * $pad);

        return [$left, $top, $nw, $nh];
    }

    public function adminManifest()
    {
        $data = [
            'name'             => config('app.company_name', site_name()) . ' — Administration',
            'short_name'       => site_name() . ' Admin',
            'description'      => 'Gérez les informations du site ' . site_name() . '.',
            'start_url'        => '/admin',
            'scope'            => '/',
            'display'          => 'standalone',
            'orientation'      => 'any',
            'background_color' => '#2A1967',
            'theme_color'      => '#268226',
            'lang'             => app()->getLocale(),
            'categories'       => ['finance', 'business'],
            'icons'            => [
                ['src' => '/site-icon-180.png', 'sizes' => '180x180', 'type' => 'image/png', 'purpose' => 'any'],
                ['src' => '/site-icon-192.png',         'sizes' => '192x192', 'type' => 'image/png', 'purpose' => 'any'],
                ['src' => '/site-icon-192.png',         'sizes' => '192x192', 'type' => 'image/png', 'purpose' => 'maskable'],
                ['src' => '/site-icon-512.png',         'sizes' => '512x512', 'type' => 'image/png', 'purpose' => 'any'],
                ['src' => '/site-icon-512.png',         'sizes' => '512x512', 'type' => 'image/png', 'purpose' => 'maskable'],
            ],
        ];

        return response()->json($data, 200, [
            'Content-Type'  => 'application/manifest+json',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }
}
