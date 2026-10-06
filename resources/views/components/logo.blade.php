@props([
    'variant' => 'full',   // 'full' (icone+mot-symbole) | 'icon' (monogramme seul)
    'theme'   => 'light',  // 'dark' = fond navy (badge or, texte creme) | 'light' = fond clair (badge navy, texte navy)
    'size'    => 'md',     // 'sm' | 'md' | 'lg'
    'href'    => null,     // optionnel : enrobe dans <a href="...">
    'light'   => null,     // override admin : SiteContact::current()->logo_light_path (URL resolue)
    'dark'    => null,     // override admin : SiteContact::current()->logo_dark_path (URL resolue)
    'name'    => null,     // nom du site : si omis, recupere SiteContact::current()->name
    'alt'     => null,
])

@php
    $siteName = $name ?: site_name();
    $alt      = $alt ?: $siteName;

    $words = preg_split('/\s+/', trim($siteName)) ?: [];
    if (count($words) >= 2) {
        $initials = mb_strtoupper(mb_substr($words[0], 0, 1) . mb_substr($words[1], 0, 1));
        $firstWord = $words[0];
        $restWords = implode(' ', array_slice($words, 1));
    } else {
        $initials = mb_strtoupper(mb_substr($siteName, 0, 2));
        $firstWord = $siteName;
        $restWords = null;
    }

    // Resolution automatique du logo televerse par l admin.
    // Avant, seuls le header et le footer publics passaient :light/:dark ; les 13 autres
    // appels (sidebar admin, espace client, ecrans de connexion, emails) retombaient donc
    // toujours sur le monogramme. Le composant va desormais le chercher lui-meme.
    $contact   = site_identity();
    $lightSrc  = $light ?: ($contact?->logo_light_path ? Storage::url($contact->logo_light_path) : null);
    $darkSrc   = $dark  ?: ($contact?->logo_dark_path  ? Storage::url($contact->logo_dark_path)  : null);

    // Si une seule variante est configuree, elle sert pour les deux themes.
    $overrideSrc = ($theme === 'dark' ? $darkSrc : $lightSrc) ?: ($darkSrc ?: $lightSrc);

    // variant="icon" attend une pastille carree : un logotype large y casserait la mise
    // en page, on garde donc le monogramme pour cette variante.
    if ($variant === 'icon') { $overrideSrc = null; }
    $box   = ['sm' => 36, 'md' => 48, 'lg' => 56][$size] ?? 48;
    $isDark = $theme === 'dark';
    // Palette derivee du logo Aurenza Capital : pastille bleu nuit, monogramme or ; inversee sur fond sombre.
    $badgeBg   = $isDark ? '#C6A15B' : '#0E3B2E';
    $badgeFg   = $isDark ? '#0E3B2E' : '#C6A15B';
    $wordColor = $isDark ? '#FFFFFF' : '#0E3B2E';
    $restColor = $isDark ? '#DCBE87' : '#9A7736';
    $gap   = round($box * 0.28);
    $wsize = round($box * 0.42);
    $tag   = $href ? 'a' : 'span';
@endphp

@if($overrideSrc)
    <{{ $tag }} @if($href) href="{{ $href }}" @endif
        {{ $attributes->merge(['class' => 'sg-logo sg-logo--img']) }}
        style="display:inline-flex;align-items:center;text-decoration:none">
        <img src="{{ $overrideSrc }}" alt="{{ $alt }}" style="height:{{ $box }}px;width:auto;display:block;object-fit:contain">
    </{{ $tag }}>
@else
    <{{ $tag }} @if($href) href="{{ $href }}" @endif
        {{ $attributes->merge(['class' => 'sg-logo']) }}
        style="display:inline-flex;align-items:center;text-decoration:none">
        @if($variant === 'icon')
            <img src="{{ asset('assets/images/favicon-aurenza.svg') }}" alt="{{ $alt }}" style="height:{{ $box }}px;width:{{ $box }}px;display:block">
        @else
            <img src="{{ asset('assets/images/logo-aurenza-' . ($isDark ? 'light' : 'dark') . '.svg') }}" alt="{{ $alt }}" style="height:{{ $box }}px;width:auto;display:block">
        @endif
    </{{ $tag }}>
@endif
