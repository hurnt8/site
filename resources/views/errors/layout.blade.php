@php
    // Page d'erreur autonome : aucune dépendance à la base, à la session ni aux assets compilés,
    // pour rester affichable même quand c'est justement la base qui est en panne.
    $code = (int) ($code ?? 500);

    try { $supported = \App\Models\Language::enabledCodes() ?: ['fr', 'en']; }
    catch (\Throwable $e) { $supported = ['fr', 'en']; }

    $locale = request()->segment(1);
    if (! in_array($locale, $supported, true)) {
        try { $locale = request()->hasSession() ? session('locale') : null; } catch (\Throwable $e) { $locale = null; }
    }
    if (! in_array($locale, $supported, true)) {
        $locale = substr((string) request()->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);
    }
    if (! in_array($locale, $supported, true)) { $locale = 'fr'; }

    // [titre, message] par code puis par langue ; repli sur l'anglais
    $T = [
        'fr' => [
            'home' => "Retour à l'accueil", 'back' => 'Page précédente', 'reload' => 'Recharger la page', 'retry' => 'Réessayer',
            400 => ['Requête invalide', "Votre demande n'a pas pu être comprise. Vérifiez les informations saisies et réessayez."],
            401 => ['Authentification requise', 'Vous devez vous connecter pour accéder à cette page.'],
            403 => ['Accès refusé', "Vous n'avez pas l'autorisation d'accéder à cette page."],
            404 => ['Page introuvable', "La page que vous cherchez n'existe pas ou a été déplacée."],
            405 => ['Action non autorisée', "Cette action n'est pas autorisée sur cette page."],
            419 => ['Session expirée', "Votre session a expiré par sécurité. Rechargez la page puis renvoyez le formulaire."],
            423 => ['Accès verrouillé', "Cette ressource est temporairement verrouillée. Réessayez dans quelques instants."],
            429 => ['Trop de requêtes', 'Vous avez effectué trop de tentatives. Patientez une minute avant de réessayer.'],
            500 => ['Erreur du serveur', "Un incident est survenu de notre côté. Notre équipe a été prévenue, réessayez dans quelques instants."],
            503 => ['Maintenance en cours', 'Le site est momentanément indisponible. Nous revenons très vite.'],
        ],
        'en' => [
            'home' => 'Back to home', 'back' => 'Previous page', 'reload' => 'Reload the page', 'retry' => 'Try again',
            400 => ['Bad request', 'Your request could not be understood. Please check the information entered and try again.'],
            401 => ['Authentication required', 'You need to sign in to access this page.'],
            403 => ['Access denied', 'You are not allowed to access this page.'],
            404 => ['Page not found', 'The page you are looking for does not exist or has been moved.'],
            405 => ['Action not allowed', 'This action is not allowed on this page.'],
            419 => ['Session expired', 'Your session has expired for security reasons. Reload the page and submit the form again.'],
            423 => ['Access locked', 'This resource is temporarily locked. Please try again in a few moments.'],
            429 => ['Too many requests', 'You have made too many attempts. Please wait a minute before trying again.'],
            500 => ['Server error', 'Something went wrong on our side. Our team has been notified, please try again shortly.'],
            503 => ['Maintenance in progress', 'The site is temporarily unavailable. We will be back very soon.'],
        ],
        'de' => [
            'home' => 'Zur Startseite', 'back' => 'Vorherige Seite', 'reload' => 'Seite neu laden', 'retry' => 'Erneut versuchen',
            400 => ['Ungültige Anfrage', 'Ihre Anfrage konnte nicht verarbeitet werden. Bitte prüfen Sie Ihre Eingaben.'],
            401 => ['Anmeldung erforderlich', 'Bitte melden Sie sich an, um diese Seite aufzurufen.'],
            403 => ['Zugriff verweigert', 'Sie haben keine Berechtigung für diese Seite.'],
            404 => ['Seite nicht gefunden', 'Die gesuchte Seite existiert nicht oder wurde verschoben.'],
            405 => ['Aktion nicht erlaubt', 'Diese Aktion ist auf dieser Seite nicht erlaubt.'],
            419 => ['Sitzung abgelaufen', 'Ihre Sitzung ist aus Sicherheitsgründen abgelaufen. Laden Sie die Seite neu und senden Sie das Formular erneut.'],
            423 => ['Zugriff gesperrt', 'Diese Ressource ist vorübergehend gesperrt. Bitte versuchen Sie es gleich noch einmal.'],
            429 => ['Zu viele Anfragen', 'Sie haben zu viele Versuche unternommen. Bitte warten Sie eine Minute.'],
            500 => ['Serverfehler', 'Bei uns ist ein Fehler aufgetreten. Unser Team wurde informiert, bitte versuchen Sie es gleich erneut.'],
            503 => ['Wartungsarbeiten', 'Die Website ist vorübergehend nicht erreichbar. Wir sind gleich zurück.'],
        ],
        'es' => [
            'home' => 'Volver al inicio', 'back' => 'Página anterior', 'reload' => 'Recargar la página', 'retry' => 'Reintentar',
            400 => ['Solicitud no válida', 'No se pudo entender su solicitud. Compruebe los datos e inténtelo de nuevo.'],
            401 => ['Autenticación requerida', 'Debe iniciar sesión para acceder a esta página.'],
            403 => ['Acceso denegado', 'No tiene permiso para acceder a esta página.'],
            404 => ['Página no encontrada', 'La página que busca no existe o se ha movido.'],
            405 => ['Acción no permitida', 'Esta acción no está permitida en esta página.'],
            419 => ['Sesión caducada', 'Su sesión ha caducado por seguridad. Recargue la página y envíe de nuevo el formulario.'],
            423 => ['Acceso bloqueado', 'Este recurso está bloqueado temporalmente. Inténtelo de nuevo en unos instantes.'],
            429 => ['Demasiadas solicitudes', 'Ha realizado demasiados intentos. Espere un minuto antes de volver a intentarlo.'],
            500 => ['Error del servidor', 'Se ha producido un incidente por nuestra parte. Nuestro equipo ha sido avisado, inténtelo en unos instantes.'],
            503 => ['Mantenimiento en curso', 'El sitio no está disponible temporalmente. Volvemos enseguida.'],
        ],
        'it' => [
            'home' => 'Torna alla home', 'back' => 'Pagina precedente', 'reload' => 'Ricarica la pagina', 'retry' => 'Riprova',
            400 => ['Richiesta non valida', 'Non è stato possibile comprendere la richiesta. Controlla i dati inseriti e riprova.'],
            401 => ['Autenticazione richiesta', 'Devi accedere per visualizzare questa pagina.'],
            403 => ['Accesso negato', 'Non hai il permesso di accedere a questa pagina.'],
            404 => ['Pagina non trovata', 'La pagina che cerchi non esiste o è stata spostata.'],
            405 => ['Azione non consentita', 'Questa azione non è consentita in questa pagina.'],
            419 => ['Sessione scaduta', 'La sessione è scaduta per motivi di sicurezza. Ricarica la pagina e invia di nuovo il modulo.'],
            423 => ['Accesso bloccato', 'Questa risorsa è temporaneamente bloccata. Riprova tra qualche istante.'],
            429 => ['Troppe richieste', 'Hai effettuato troppi tentativi. Attendi un minuto prima di riprovare.'],
            500 => ['Errore del server', 'Si è verificato un problema da parte nostra. Il nostro team è stato avvisato, riprova tra poco.'],
            503 => ['Manutenzione in corso', 'Il sito è temporaneamente non disponibile. Torneremo presto.'],
        ],
        'pt' => [
            'home' => 'Voltar ao início', 'back' => 'Página anterior', 'reload' => 'Recarregar a página', 'retry' => 'Tentar novamente',
            400 => ['Pedido inválido', 'Não foi possível compreender o seu pedido. Verifique os dados e tente novamente.'],
            401 => ['Autenticação necessária', 'Tem de iniciar sessão para aceder a esta página.'],
            403 => ['Acesso negado', 'Não tem permissão para aceder a esta página.'],
            404 => ['Página não encontrada', 'A página que procura não existe ou foi movida.'],
            405 => ['Ação não permitida', 'Esta ação não é permitida nesta página.'],
            419 => ['Sessão expirada', 'A sua sessão expirou por segurança. Recarregue a página e envie novamente o formulário.'],
            423 => ['Acesso bloqueado', 'Este recurso está temporariamente bloqueado. Tente novamente dentro de instantes.'],
            429 => ['Demasiados pedidos', 'Fez demasiadas tentativas. Aguarde um minuto antes de tentar novamente.'],
            500 => ['Erro do servidor', 'Ocorreu um incidente do nosso lado. A nossa equipa foi avisada, tente novamente dentro de instantes.'],
            503 => ['Manutenção em curso', 'O site está temporariamente indisponível. Voltamos em breve.'],
        ],
        'nl' => [
            'home' => 'Terug naar home', 'back' => 'Vorige pagina', 'reload' => 'Pagina herladen', 'retry' => 'Opnieuw proberen',
            400 => ['Ongeldig verzoek', 'Uw verzoek kon niet worden verwerkt. Controleer de ingevoerde gegevens en probeer het opnieuw.'],
            401 => ['Authenticatie vereist', 'U moet inloggen om deze pagina te bekijken.'],
            403 => ['Toegang geweigerd', 'U heeft geen toestemming voor deze pagina.'],
            404 => ['Pagina niet gevonden', 'De pagina die u zoekt bestaat niet of is verplaatst.'],
            405 => ['Actie niet toegestaan', 'Deze actie is op deze pagina niet toegestaan.'],
            419 => ['Sessie verlopen', 'Uw sessie is om veiligheidsredenen verlopen. Herlaad de pagina en verstuur het formulier opnieuw.'],
            423 => ['Toegang vergrendeld', 'Deze bron is tijdelijk vergrendeld. Probeer het zo meteen opnieuw.'],
            429 => ['Te veel verzoeken', 'U heeft te veel pogingen gedaan. Wacht een minuut voordat u het opnieuw probeert.'],
            500 => ['Serverfout', 'Er is aan onze kant iets misgegaan. Ons team is op de hoogte, probeer het zo meteen opnieuw.'],
            503 => ['Onderhoud bezig', 'De site is tijdelijk niet beschikbaar. We zijn zo terug.'],
        ],
    ];
    $L = $T[$locale] ?? $T['en'];
    [$title, $message] = $L[$code] ?? $L[500];

    try { $siteName = site_name(); } catch (\Throwable $e) { $siteName = 'Aurenza Capital'; }
    // Logo officiel téléversé en admin (clair sur fond blanc), sinon logo par défaut de la marque
    $logoUrl = '/assets/images/logo-aurenza-dark.svg';
    $iconUrl = '/assets/images/favicon-aurenza.svg';
    try {
        $contact = site_identity();
        $logoPath = $contact?->logo_light_path ?: $contact?->logo_dark_path;
        if ($logoPath && \Illuminate\Support\Facades\Storage::disk('public')->exists($logoPath)) {
            $logoUrl = \Illuminate\Support\Facades\Storage::url($logoPath);
            $iconUrl = '/site-icon-32.png';
        }
    } catch (\Throwable $e) {
        // base ou disque indisponible : on garde le logo par défaut
    }
    $homeUrl    = url('/' . $locale);
    $showReload = in_array($code, [419, 423, 429, 500, 503], true);
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex">
<title>{{ $code }} — {{ $title }} | {{ $siteName }}</title>
<link rel="icon" href="{{ $iconUrl }}">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600;9..144,700&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
:root{--forest:#0E3B2E;--forest-deep:#082A20;--brass:#C6A15B;--ivory:#FBF9F4;--gray:#6F695D}
*{box-sizing:border-box;margin:0;padding:0}
body{min-height:100vh;display:flex;flex-direction:column;font-family:'Outfit',system-ui,sans-serif;background:var(--ivory);color:#1A1A17;-webkit-font-smoothing:antialiased}
.bar{background:#fff;border-bottom:1px solid #E4E0D6;padding:.9rem 1.5rem}
.bar img{height:44px;display:block}
main{flex:1;display:flex;align-items:center;justify-content:center;padding:3rem 1.25rem}
.card{max-width:640px;width:100%;text-align:center}
.code{font-family:'Fraunces',Georgia,serif;font-weight:700;font-size:clamp(5rem,18vw,9rem);line-height:1;color:var(--forest);letter-spacing:-.03em}
.code span{color:var(--brass)}
.rule{width:56px;height:3px;background:var(--brass);margin:1.25rem auto 1.5rem}
h1{font-family:'Fraunces',Georgia,serif;font-weight:700;font-size:clamp(1.5rem,4vw,2.1rem);color:var(--forest);margin-bottom:.75rem}
p{font-size:1.02rem;line-height:1.7;color:var(--gray);max-width:30rem;margin:0 auto 2rem}
.actions{display:flex;flex-wrap:wrap;gap:.75rem;justify-content:center}
.btn{display:inline-flex;align-items:center;gap:.5rem;padding:.8rem 1.6rem;border-radius:3px;font-weight:600;font-size:.92rem;text-decoration:none;border:1.5px solid var(--forest);cursor:pointer;font-family:inherit}
.btn-primary{background:var(--forest);color:#fff}
.btn-primary:hover{background:var(--forest-deep)}
.btn-outline{background:transparent;color:var(--forest)}
.btn-outline:hover{background:var(--forest);color:#fff}
footer{padding:1.25rem;text-align:center;font-size:.78rem;color:#8A8474;border-top:1px solid #E4E0D6}
</style>
</head>
<body>
<div class="bar"><a href="{{ $homeUrl }}"><img src="{{ $logoUrl }}" alt="{{ $siteName }}"></a></div>
<main>
  <div class="card">
    <div class="code">{!! preg_replace('/^(\d)(\d)(\d)$/', '$1<span>$2</span>$3', (string) $code) !!}</div>
    <div class="rule"></div>
    <h1>{{ $title }}</h1>
    <p>{{ $message }}</p>
    <div class="actions">
      <a class="btn btn-primary" href="{{ $homeUrl }}">{{ $L['home'] }}</a>
      @if($showReload)
        <button type="button" class="btn btn-outline" onclick="location.reload()">{{ $code === 419 ? $L['reload'] : $L['retry'] }}</button>
      @else
        <button type="button" class="btn btn-outline" onclick="history.length > 1 ? history.back() : (location.href = '{{ $homeUrl }}')">{{ $L['back'] }}</button>
      @endif
    </div>
  </div>
</main>
<footer>&copy; {{ date('Y') }} {{ $siteName }}</footer>
</body>
</html>
