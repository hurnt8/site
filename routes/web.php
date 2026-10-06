<?php

use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\Auth\StaffForgotPasswordController;
use App\Http\Controllers\Auth\StaffLoginController;
use App\Http\Controllers\Auth\StaffResetPasswordController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Dashboard\AdminDashboardController;
use App\Http\Controllers\Dashboard\SuperAdminDashboardController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\SiteAssetsController;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

$supportedLocales = Schema::hasTable('languages')
    ? Language::enabledCodes()
    : ['fr', 'en'];

Route::get('/', function (Request $request) use ($supportedLocales) {
    $locale = 'en';

    $header = $request->header('Accept-Language', '');
    if ($header) {
        $languages = [];
        foreach (explode(',', $header) as $part) {
            [$tag, $q] = array_pad(explode(';q=', trim($part)), 2, '1');
            $languages[strtolower(trim($tag))] = (float) $q;
        }
        arsort($languages);

        foreach (array_keys($languages) as $tag) {
            $short = substr($tag, 0, 2);
            if (in_array($short, $supportedLocales)) {
                $locale = $short;
                break;
            }
        }
    }

    return redirect("/{$locale}");
});

Route::group([
    'prefix' => '{locale}',
    'middleware' => 'setLocale',
    'where' => ['locale' => implode('|', $supportedLocales)]
], function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('home');


    Route::get('/simulate', function () {
        // return view('simulate');
        // return view('/#simulate');
        return Redirect::to('/#simulate');

    })->name('simulate');

    Route::get('/about', function () {
        return view('about');
    })->name('about');

    Route::get('/contact', function () {
        return view('contact');
    })->name('contact');

    Route::get('/apply-loan', function () {
        return view('apply-loan');
    })->name('loan');

    Route::get('/loan/complete', [LoanController::class, 'showDocuments'])->name('loan.complete');

    Route::get('/terms', function () {
        return view('terms');
    })->name('terms');

    Route::get('/privacy', function () {
        return view('privacy');
    })->name('privacy');

    Route::get('/faq', function () {
        return view('faq');
    })->name('faq');

    Route::get('/services', function () {
        return view('services');
    })->name('services');

    Route::get('/services/auto-loan', function () {
        return view('service-d-auto-loan');
    })->name('services.auto');

    Route::get('/services/personal-loan', function () {
        return view('service-d-personal-loan');
    })->name('services.personal');

    Route::get('/services/home-loan', function () {
        return view('service-d-home-loan');
    })->name('services.home');

    Route::get('/services/study-loan', function () {
        return view('service-d-study-loan');
    })->name('services.study');

    Route::get('/services/business-loan', function () {
        return view('service-d-business-loan');
    })->name('services.business');

    Route::get('/services/bike-loan', function () {
        return view('service-d-bike-loan');
    })->name('services.bike');

});
Route::post('/loan/simulate', [LoanController::class, 'simulate'])->name('loan.simulate');
Route::post('/contact/send', [ContactController::class, 'sendMail'])->name('contact.send');
Route::post('/subscribe/send', [ContactController::class, 'subscribeMail'])->name('subscribe.send');
Route::post('/loan/request', [LoanController::class, 'sendMail'])->name('loan.request');
Route::post('/loan/documents', [LoanController::class, 'sendDocuments'])->name('loan.documents');

// ── Locale switcher (for auth pages without {locale} prefix) ────────────────
Route::get('/lang/{lang}', function (Request $request, $lang) {
    if (in_array($lang, Language::enabledCodes())) {
        session(['locale' => $lang]);
    }
    $back = $request->headers->get('referer', url('/'));
    return redirect($back);
})->name('lang.switch');

// ── Authentification (personnel uniquement) ─────────────────────────────────

// Route "login" requise par le framework : renvoie vers la connexion du personnel
Route::get('/login', fn () => redirect()->route('staff.login'))->name('login');

// OTP verification
Route::get('/otp-verify',  [OtpController::class, 'show'])->name('otp.show');
Route::post('/otp-verify', [OtpController::class, 'verify'])->name('otp.verify')->middleware('throttle:5,1');
Route::post('/otp-resend', [OtpController::class, 'resend'])->name('otp.resend')->middleware('throttle:3,1');

// Account unblock (via email link)
Route::get('/account/unblock/{token}', [OtpController::class, 'unblock'])->name('account.unblock');

// Staff login (admin / super-admin)
Route::get('/staff/login',  [StaffLoginController::class, 'showLoginForm'])->name('staff.login')->middleware('guest');
Route::post('/staff/login', [StaffLoginController::class, 'login'])->name('staff.login.submit')->middleware(['guest', 'throttle:5,1']);
Route::post('/staff/logout',[StaffLoginController::class, 'logout'])->name('staff.logout');

// Forgot / reset password (staff / admin)
Route::get('/staff/forgot-password',         [StaffForgotPasswordController::class, 'show'])->name('staff.password.request')->middleware('guest');
Route::post('/staff/forgot-password',        [StaffForgotPasswordController::class, 'send'])->name('staff.password.email')->middleware(['guest', 'throttle:5,1']);
Route::get('/staff/reset-password/{token}',  [StaffResetPasswordController::class, 'show'])->name('staff.password.reset')->middleware('guest');
Route::post('/staff/reset-password',         [StaffResetPasswordController::class, 'reset'])->name('staff.password.update')->middleware(['guest', 'throttle:5,1']);

// /favicon.ico et icones générées depuis le logo téléversé en admin
Route::get('/favicon.ico', fn () => app(SiteAssetsController::class)->siteIcon(32))->name('favicon');
Route::get('/site-icon-{size}.png', [SiteAssetsController::class, 'siteIcon'])
    ->whereNumber('size')->name('site.icon');
Route::get('/admin-manifest.json', [SiteAssetsController::class, 'adminManifest'])->name('pwa.admin-manifest');

Route::get('/storage/{path}', function (string $path) {
    $file = storage_path('app/public/' . $path);
    abort_unless(file_exists($file) && is_file($file), 404);
    $mime = mime_content_type($file) ?: 'application/octet-stream';
    return response()->file($file, ['Content-Type' => $mime]);
})->where('path', '.+')->name('storage.serve');

// ── Admin : gestion des informations du site ────────────────────────────────
Route::middleware(['auth', 'role:admin|super-admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Profil
    Route::get('/profile',           [\App\Http\Controllers\Admin\AdminProfileController::class, 'index'])->name('profile');
    Route::post('/profile',          [\App\Http\Controllers\Admin\AdminProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [\App\Http\Controllers\Admin\AdminProfileController::class, 'updatePassword'])->name('profile.password');

    // Coordonnées du site (footer)
    Route::middleware('role_or_permission:super-admin|manage-site-contacts')->group(function () {
        Route::get('/site-contacts',  [\App\Http\Controllers\Admin\SiteContactController::class, 'edit'])->name('site-contacts.edit');
        Route::post('/site-contacts', [\App\Http\Controllers\Admin\SiteContactController::class, 'update'])->name('site-contacts.update');
    });

    // Réseaux sociaux (footer + page contact)
    Route::middleware('role_or_permission:super-admin|manage-social-links')->group(function () {
        Route::get('/social-links',                  [\App\Http\Controllers\Admin\SocialLinkController::class, 'index'])->name('social-links.index');
        Route::get('/social-links/create',           [\App\Http\Controllers\Admin\SocialLinkController::class, 'create'])->name('social-links.create');
        Route::post('/social-links',                 [\App\Http\Controllers\Admin\SocialLinkController::class, 'store'])->name('social-links.store');
        Route::get('/social-links/{socialLink}/edit',[\App\Http\Controllers\Admin\SocialLinkController::class, 'edit'])->name('social-links.edit');
        Route::put('/social-links/{socialLink}',     [\App\Http\Controllers\Admin\SocialLinkController::class, 'update'])->name('social-links.update');
        Route::delete('/social-links/{socialLink}',  [\App\Http\Controllers\Admin\SocialLinkController::class, 'destroy'])->name('social-links.destroy');
    });

    // Langues visibles dans le sélecteur du site
    Route::middleware('role_or_permission:super-admin|manage-languages')->group(function () {
        Route::get('/languages',  [LanguageController::class, 'index'])->name('languages.index');
        Route::put('/languages',  [LanguageController::class, 'update'])->name('languages.update');
    });

    // Devises disponibles dans le projet
    Route::middleware('role_or_permission:super-admin|manage-currencies')->group(function () {
        Route::get('/currencies',               [CurrencyController::class, 'index'])->name('currencies.index');
        Route::put('/currencies',                [CurrencyController::class, 'update'])->name('currencies.update');
        Route::post('/currencies',               [CurrencyController::class, 'store'])->name('currencies.store');
        Route::delete('/currencies/{currency}',  [CurrencyController::class, 'destroy'])->name('currencies.destroy');
    });

    // Paramètres de prêt (taux d'intérêt annuel)
    Route::middleware('role_or_permission:super-admin|manage-loan-settings')->group(function () {
        Route::get('/loan-settings',  [\App\Http\Controllers\Admin\LoanSettingController::class, 'edit'])->name('loan-settings.edit');
        Route::post('/loan-settings', [\App\Http\Controllers\Admin\LoanSettingController::class, 'update'])->name('loan-settings.update');
    });
});

// ── Super Admin ─────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:super-admin'])->prefix('super-admin')->name('super-admin.')->group(function () {
    Route::get('/', [SuperAdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/roles', [SuperAdminDashboardController::class, 'roles'])->name('roles');
    Route::post('/users/{user}/role', [SuperAdminDashboardController::class, 'assignRole'])->name('users.role');
    Route::post('/users/{user}/permissions', [SuperAdminDashboardController::class, 'updatePermissions'])->name('users.permissions');

    // Profil
    Route::get('/profile',           [\App\Http\Controllers\Admin\AdminProfileController::class, 'index'])->name('profile');
    Route::post('/profile',          [\App\Http\Controllers\Admin\AdminProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [\App\Http\Controllers\Admin\AdminProfileController::class, 'updatePassword'])->name('profile.password');
});
