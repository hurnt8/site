@extends('layouts.app')
@section('title', __('menu.home'))

@section('content')
@php
    $locale = app()->getLocale();
    $siteContact = \App\Models\SiteContact::current();
@endphp

{{-- ============================================================
     HÉROS SCINDÉ
     Le carrousel posait le texte par-dessus une photo chargée :
     le titre tombait sur les visages et le contraste variait d'une
     diapositive à l'autre. Le texte a désormais son propre fond clair.
============================================================ --}}
<section class="hero-split">
  <div class="container-sm">
    <div class="hero-split__grid">

            <div class="hero-split__text wow fadeInUp" data-wow-duration="800ms">
                <div class="hero-eyebrow">@lang('home.slide_1.title')</div>

                <h1 class="hero-split__title">
                    @lang('home.slide_1.text1')
                    <em>@lang('home.slide_1.text2')</em>
                </h1>

                <p class="hero-split__lede">@lang('home.hero_subtitle')</p>

                <div class="hero-split__actions">
                    <a href="{{ route('loan', ['locale' => $locale]) }}" class="btn-primary btn-primary--lg">
                        <i class="fas fa-file-signature"></i>
                        @lang('menu.loan')
                    </a>
                    <a href="#simulate" class="btn-outline btn-outline--lg">
                        <i class="fas fa-calculator"></i>
                        @lang('menu.simulate')
                    </a>
                </div>

                <div class="hero-facts">
                    @foreach ([
                        ['4.9/5',  __('home.customer_satisfaction_rate')],
                        ['48h',    __('home.average_approval_time')],
                        ['8 500+', __('home.member')],
                        ['8',      __('home.about.exptitle')],
                    ] as $fait)
                    <div class="hero-fact">
                        <span class="hero-fact__num">{{ $fait[0] }}</span>
                        <span class="hero-fact__label">{{ $fait[1] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="hero-split__media wow fadeIn" data-wow-duration="1100ms">
                <img src="{{ asset('assets/images/aurenza/hero-siege.jpg') }}" alt="@lang('menu.loan')">
                <div class="hero-split__stamp">
                    <b>5 000 000 €</b>
                    <span>{{ __('home.total_loan_amount_granted') }}</span>
                </div>
            </div>

    </div>
  </div>
</section>

@include('partials.service-strip')

{{-- ============================================================
     SELON VOTRE SITUATION — segmentation par profil
============================================================ --}}
@push('styles')
<style>
.needs-grid {
    display:grid; grid-template-columns:1fr; gap:1.1rem; margin-top:2.5rem;
}
@media (min-width:640px)  { .needs-grid { grid-template-columns:repeat(2,1fr); } }
@media (min-width:1024px) { .needs-grid { grid-template-columns:repeat(3,1fr); } }

.needs-card {
    display:flex; flex-direction:column;
    background:#fff; border:1px solid var(--gray-200); border-radius:16px;
    padding:1.75rem 1.5rem; text-decoration:none;
    transition:transform .22s ease, box-shadow .22s ease, border-color .22s ease;
}
.needs-card:hover {
    transform:translateY(-4px);
    box-shadow:0 18px 40px rgba(14,59,46,.1);
    border-color:transparent;
}
.needs-card__icon {
    width:50px; height:50px; border-radius:13px;
    background:rgba(154,119,54,.08); color:var(--accent);
    display:flex; align-items:center; justify-content:center;
    font-size:1.2rem; margin-bottom:1.1rem;
    transition:background .22s ease, color .22s ease;
}
.needs-card:hover .needs-card__icon { background:var(--accent); color:#fff; }
.needs-card__title {
    font-family:'Fraunces',serif; font-weight:700; color:var(--navy);
    font-size:1.05rem; margin:0 0 .5rem; line-height:1.3;
}
.needs-card__text { font-size:.85rem; color:var(--gray-500); line-height:1.65; margin:0 0 1.1rem; flex:1; }
.needs-card__cta {
    font-size:.78rem; font-weight:800; color:var(--accent);
    text-transform:uppercase; letter-spacing:.05em;
    display:inline-flex; align-items:center; gap:.4rem;
}
.needs-card:hover .needs-card__cta { gap:.65rem; }
</style>
@endpush

<section class="py-24" style="background:var(--cream);">
    <div class="container-sm">
        <div class="text-center mb-4" style="max-width:640px;margin-left:auto;margin-right:auto;">
            <div class="rule-label rule-label--center">{{ __('home.needs.sectagline') }}</div>
            <h2 class="section-title">{{ __('home.needs.sectitle') }}</h2>
            <p style="color:var(--gray-500);font-size:.95rem;">{{ __('home.needs.sectitle_sub') }}</p>
        </div>

        @php
        $needsProfiles = [
            ['key' => 'starter',      'route' => 'services.personal', 'icon' => 'fas fa-seedling'],
            ['key' => 'student',      'route' => 'services.study',    'icon' => 'fas fa-graduation-cap'],
            ['key' => 'buyer',        'route' => 'services.home',     'icon' => 'fas fa-key'],
            ['key' => 'entrepreneur', 'route' => 'services.business', 'icon' => 'fas fa-briefcase'],
            ['key' => 'driver',       'route' => 'services.auto',     'icon' => 'fas fa-car'],
            ['key' => 'rider',        'route' => 'services.bike',     'icon' => 'fas fa-motorcycle'],
        ];
        @endphp
        <div class="needs-grid">
            @foreach ($needsProfiles as $i => $p)
            <a href="{{ route($p['route'], ['locale' => $locale]) }}" class="needs-card wow fadeInUp"
               data-wow-duration="700ms" data-wow-delay="{{ $i * 60 }}ms">
                <div class="needs-card__icon"><i class="{{ $p['icon'] }}"></i></div>
                <h3 class="needs-card__title">{{ __('home.needs.profiles.' . $p['key'] . '.title') }}</h3>
                <p class="needs-card__text">{{ __('home.needs.profiles.' . $p['key'] . '.text') }}</p>
                <span class="needs-card__cta">{{ __('home.needs.profiles.' . $p['key'] . '.cta') }} <i class="fas fa-arrow-right"></i></span>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================================================
     ABOUT
============================================================ --}}
@push('styles')
<style>
/* ── About section ── */

.about-loan-grid {
    display:grid; grid-template-columns:1fr 1fr; gap:.4rem .75rem; margin-bottom:1.25rem;
}
.about-loan-item {
    display:flex; align-items:center; gap:.55rem;
    font-size:.82rem; font-weight:600; color:var(--navy); padding:.4rem 0;
    border-bottom:1px solid #f3f4f6;
}
.about-loan-item i { color:var(--accent); width:16px; text-align:center; font-size:.8rem; }

.about-partner-bar {
    display:flex; align-items:center; gap:.55rem;
    padding:.75rem 1rem; background:#f7f8fa; border-radius:10px;
    border:1px solid #eaecf0; margin-bottom:1.5rem;
    flex-wrap:wrap;
}
.about-partner-bar__lbl { font-size:.6rem; font-weight:800; text-transform:uppercase; letter-spacing:.12em; color:#9ca3af; white-space:nowrap; flex-shrink:0; }
.about-partner-bar:hover .about-partner-bar__name {
    font-size:.78rem; font-weight:700; color:var(--navy);
    background:#fff; border:1px solid #e5e7eb; border-radius:999px;
    padding:.3rem .8rem; white-space:nowrap; flex-shrink:0;
    transition:border-color .25s ease, box-shadow .25s ease;
}
.about-partner-bar__name:hover { border-color:var(--accent); box-shadow:0 2px 10px rgba(154, 119, 54,.18); }
@media (prefers-reduced-motion: reduce) {
    }
</style>
@endpush

<section class="py-24 bg-white" id="about">
    <div class="container-sm">
        <div class="row gutter-y-60 align-items-center">

            {{-- ── Image ── --}}
            <div class="col-lg-6 wow fadeInLeft" data-wow-duration="1000ms">
                {{-- Deux photos decalees, sans pastille chiffree : le modele ne
                     pose plus de badge sur l'image. --}}
                <div class="about-stack">
                    <img src="{{ asset('assets/images/refonte/bureaux-couloir.jpg') }}"
                         alt="{{ __('about.mission_title') }}" class="about-stack__tall" loading="lazy">
                    <img src="{{ asset('assets/images/refonte/bureaux-reunion.jpg') }}"
                         alt="" class="about-stack__wide" loading="lazy">
                </div>
            </div>

            {{-- ── Contenu ── --}}
            <div class="col-lg-6 wow fadeInRight" data-wow-duration="1000ms" data-wow-delay="150ms">

                <div class="rule-label">{{ __('about.mission_tagline') }}</div>
                <h2 class="section-title">{{ __('about.mission_title') }}</h2>

                <p style="color:var(--gray-500);font-size:.9375rem;line-height:1.8;margin-bottom:1.5rem;">
                    {{ __('about.mission_p1') }}
                </p>

                {{-- Valeurs clés (alignées sur la page À propos) --}}
                <div class="about-point">
                    <div class="about-point__icon"><i class="fas fa-balance-scale"></i></div>
                    <div>
                        <div class="about-point__title">{{ __('about.value1_title') }}</div>
                        <p class="about-point__desc">{{ __('about.value1_desc') }}</p>
                    </div>
                </div>
                <div class="about-point">
                    <div class="about-point__icon"><i class="fas fa-bolt"></i></div>
                    <div>
                        <div class="about-point__title">{{ __('about.value2_title') }}</div>
                        <p class="about-point__desc">{{ __('about.value2_desc') }}</p>
                    </div>
                </div>
                <div class="about-point">
                    <div class="about-point__icon"><i class="fas fa-user-tie"></i></div>
                    <div>
                        <div class="about-point__title">{{ __('about.value3_title') }}</div>
                        <p class="about-point__desc">{{ __('about.value3_desc') }}</p>
                    </div>
                </div>

                {{-- Types de prêts --}}
                <div style="font-size:.65rem;font-weight:800;text-transform:uppercase;letter-spacing:.1em;color:var(--navy);margin-bottom:.6rem;">
                    <i class="fas fa-tags" style="color:var(--accent);margin-right:.35rem;"></i>@lang('home.discover_our_loan_services')
                </div>
                <div class="about-loan-grid">
                    <div class="about-loan-item"><i class="fas fa-user-tie"></i> @lang('home.personal_loan')</div>
                    <div class="about-loan-item"><i class="fas fa-home"></i> @lang('home.mortgage_loan')</div>
                    <div class="about-loan-item"><i class="fas fa-car"></i> @lang('home.auto_loan')</div>
                    <div class="about-loan-item"><i class="fas fa-graduation-cap"></i> @lang('home.student_loan')</div>
                    <div class="about-loan-item"><i class="fas fa-briefcase"></i> @lang('home.business_loan')</div>
                    <div class="about-loan-item"><i class="fas fa-credit-card"></i> @lang('home.microcredit')</div>
                </div>

                {{-- Partenaires bancaires --}}
                <div class="about-partner-bar">
                    <span class="about-partner-bar__lbl">@lang('home.partners_label') :</span>
                    {{-- Le modele n en montre que cinq : la liste complete
                         est reprise plus bas, dans la bande dediee. --}}
                    @foreach (array_slice(__('home.partners_list'), 0, 5) as $bankName)
                    <span class="about-partner-bar__name">{{ $bankName }}</span>
                    @endforeach
                </div>

                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('loan', ['locale' => $locale]) }}" class="btn-primary btn-primary--lg">
                        <i class="fas fa-file-signature"></i> @lang('menu.loan')
                    </a>
                    <a href="{{ route('about', ['locale' => $locale]) }}" class="btn-outline">
                        @lang('menu.about') <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

            </div>

        </div>
    </div>
</section>

{{-- ============================================================
     SERVICES GRID
============================================================ --}}
<section class="py-24" style="background:var(--cream);" id="services">
    <div class="container-sm">
        <div class="row align-items-end mb-12">
            <div class="col-lg-8">
                <div class="rule-label">{{ __('home.services.sectagline') }}</div>
                <h2 class="section-title mb-0">{{ __('home.services.sectitle') }}</h2>
            </div>
            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                <a href="{{ route('services', ['locale' => $locale]) }}" class="btn-outline">
                    @lang('menu.services') <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        {{-- Grille de cellules separees par des filets : le modele a abandonne
             les cartes a image au profit d'un registre editorial. --}}
        <div class="offer-grid">
            @php
            $services = [
                ['route' => 'services.personal', 'key' => 'personal_loan', 'label' => 'menu.personal',  'icon' => 'fas fa-user-tie'],
                ['route' => 'services.study',    'key' => 'study_loan',    'label' => 'menu.study',     'icon' => 'fas fa-graduation-cap'],
                ['route' => 'services.home',     'key' => 'home_loan',     'label' => 'menu.home_loan', 'icon' => 'fas fa-home'],
                ['route' => 'services.business', 'key' => 'business_loan', 'label' => 'menu.business',  'icon' => 'fas fa-briefcase'],
                ['route' => 'services.auto',     'key' => 'auto_loan',     'label' => 'menu.auto',      'icon' => 'fas fa-car'],
                ['route' => 'services.bike',     'key' => 'bike_loan',     'label' => 'menu.bike',      'icon' => 'fas fa-bicycle'],
            ];
            @endphp
            @foreach ($services as $i => $svc)
            <a href="{{ route($svc['route'], ['locale' => $locale]) }}" class="offer-cell wow fadeInUp"
               data-wow-duration="700ms" data-wow-delay="{{ $i * 60 }}ms">
                <i class="{{ $svc['icon'] }} offer-cell__icon"></i>
                <h3 class="offer-cell__title">@lang($svc['label'])</h3>
                <p class="offer-cell__desc">{{ Str::limit(__('loan.' . $svc['key'] . '.description'), 110) }}</p>
                <span class="offer-cell__more">@lang('menu.read_more') <i class="fas fa-arrow-right"></i></span>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================================================
     HOW IT WORKS
============================================================ --}}
<section class="py-24 bg-white">
    <div class="container-sm">
        <div class="row mb-10">
            <div class="col-lg-7">
                <div class="rule-label">{{ __('home.works.sectagline') }}</div>
                <h2 class="section-title mb-0">{{ __('home.works.sectitle') }}</h2>
            </div>
        </div>
        {{-- Rangees numerotees separees par des filets : le modele a remplace
             les quatre cartes en verre par une liste editoriale. --}}
        <div class="steps-list">
            @foreach ([1,2,3,4] as $s)
            <div class="step-row wow fadeInUp" data-wow-duration="700ms" data-wow-delay="{{ ($s-1)*60 }}ms">
                <span class="step-row__num">0{{ $s }}</span>
                <h3 class="step-row__title">{{ __('home.works.step' . $s . '.title') }}</h3>
                <p class="step-row__desc">{{ __('home.works.step' . $s . '.desc') }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================================================
     LOAN CALCULATOR
============================================================ --}}
<section class="calc-section py-24" id="simulate">
    <div class="container-sm">
        <div class="row gutter-y-50 align-items-center">
            <div class="col-lg-5 wow fadeInLeft" data-wow-duration="900ms">
                <div class="rule-label" style="color:var(--accent);">{{ __('home.works.sectagline') }}</div>
                <h2 class="section-title section-title--white">{{ __('home.loan_reasons.sectitle') }}</h2>
                <p class="section-sub section-sub--white mb-8">{{ __('about.mission_p1') }}</p>

                @foreach ([1,2,3] as $r)
                <div class="d-flex align-items-start gap-3 mb-4">
                    <div style="width:36px;height:36px;background:rgba(154, 119, 54,.15);border-radius:50%;display:flex;align-items:center;justify-content:center;color:var(--accent);flex-shrink:0;">
                        <i class="fas fa-check"></i>
                    </div>
                    <div>
                        <h4 style="font-family:'Fraunces',serif;font-size:1rem;font-weight:700;color:#fff;margin:0 0 .25rem;">
                            {{ __('home.loan_reasons.reasons.title' . $r) }}
                        </h4>
                        <p style="font-size:.875rem;color:rgba(255,255,255,.55);margin:0;line-height:1.65;">
                            {{ __('home.loan_reasons.reasons.desc' . $r) }}
                        </p>
                    </div>
                </div>
                @endforeach

                <div class="mt-6">
                    <a href="{{ route('loan', ['locale' => $locale]) }}" class="btn-primary btn-primary--lg">
                        <i class="fas fa-file-signature"></i> @lang('menu.loan')
                    </a>
                </div>
            </div>

            <div class="col-lg-6 offset-lg-1 wow fadeInRight" data-wow-duration="900ms" data-wow-delay="150ms">
                @include('partials.simulate')
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     STATS
============================================================ --}}
{{-- Bandeau de chiffres pleine largeur, cellules separees par des filets.
     Les compteurs animes disparaissent : le modele affiche les valeurs
     directement, sans dependre de jquery-appear. --}}
<section class="figure-band">
    <div class="container-sm">
        @php
        $chiffres = [
            ['8 500+',   __('home.customer_satisfaction_rate')],
            ['€500k',    __('home.total_loan_amount_granted')],
            ['48h',      __('home.average_approval_time')],
            ['8+',       __('home.years_experience')],
        ];
        @endphp
        <div class="figure-band__grid">
            @foreach ($chiffres as $i => $c)
            <div class="figure-cell wow fadeInUp" data-wow-duration="700ms" data-wow-delay="{{ $i*70 }}ms">
                <span class="figure-cell__num">{{ $c[0] }}</span>
                <span class="figure-cell__label">{{ $c[1] }}</span>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================================================
     BANQUES PARTENAIRES — après les stats (signal de confiance)
============================================================ --}}
{{-- Bande statique : le modele ne fait plus defiler les partenaires. --}}
<section class="py-10 bg-white" style="border-top:1px solid var(--gray-200);border-bottom:1px solid var(--gray-200);">
    <div class="container-sm">
        <p class="text-center" style="font-size:.66rem;font-weight:800;text-transform:uppercase;letter-spacing:.16em;color:var(--gray-400);margin-bottom:1.5rem;">
            @lang('home.partners_label')
        </p>
        <div class="partners-strip">
            {{-- La liste compte une quarantaine d etablissements. Affichee en
                 entier sans defilement elle occupait six lignes : le modele
                 presente une bande discrete, on s y tient. --}}
            @foreach (array_slice(__('home.partners_list'), 0, 10) as $bankName)
            <div class="partner-logo partner-logo--text">{{ $bankName }}</div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================================================
     TESTIMONIALS — Swiper carousel
============================================================ --}}
<section class="py-24" style="background:var(--gray-50);" id="testimonials">
    <div class="container-sm">
        <div class="mb-10">
            <div class="rule-label">{{ __('home.testimonials_title') }}</div>
            <h2 class="section-title mb-0">{{ __('home.testimonials_title') }}</h2>
        </div>
        {{-- Grille figee : le modele a supprime le carrousel Swiper et le badge
             Google au profit de citations lisibles d'un seul coup d'oeil. --}}
        <div class="quote-grid">
            @foreach (range(1, 6) as $i)
            @php $t = __('home.testimonial_' . $i); @endphp
            <div class="quote-cell wow fadeInUp" data-wow-duration="700ms" data-wow-delay="{{ ($i-1)*60 }}ms">
                <span class="quote-cell__mark">&ldquo;</span>
                <p class="quote-cell__text">{{ $t['quote'] }}</p>
                <p class="quote-cell__who">{{ $t['name'] }}</p>
                <p class="quote-cell__when">{{ trans_choice('home.testimonials_months_ago', $t['months_ago'], ['count' => $t['months_ago']]) }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================================================
     CTA BANNER
============================================================ --}}
<section class="cta-banner">
    <div class="container-sm">
        <div class="row align-items-center gutter-y-30">
            <div class="col-lg-7 wow fadeInLeft" data-wow-duration="900ms">
                <div class="rule-label" style="color:var(--accent);">@lang('home.final_cta.tagline')</div>
                <h2 class="section-title section-title--white mb-0">@lang('home.final_cta.title')</h2>
            </div>
            <div class="col-lg-5 text-lg-end wow fadeInRight" data-wow-duration="900ms" data-wow-delay="150ms">
                <div class="d-flex flex-wrap justify-content-lg-end gap-3">
                    <a href="{{ route('loan',    ['locale' => $locale]) }}" class="btn-primary btn-primary--lg">
                        <i class="fas fa-file-signature"></i> @lang('menu.loan')
                    </a>
                    <a href="{{ route('contact', ['locale' => $locale]) }}" class="btn-outline-white">
                        <i class="fas fa-envelope"></i> @lang('menu.contact')
                    </a>
                </div>
            </div>
        </div>

        <hr style="border-color:rgba(255,255,255,.08);margin:3rem 0;">

        <div class="d-flex flex-wrap justify-content-lg-end gap-4">
            @if($siteContact->address_1)
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-map-marker-alt" style="color:var(--accent);font-size:.9rem;"></i>
                <span style="color:rgba(255,255,255,.6);font-size:.875rem;">{{ $siteContact->address_1 }}</span>
            </div>
            @endif
            @if($siteContact->phone_1)
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-phone-alt" style="color:var(--accent);font-size:.9rem;"></i>
                <a href="tel:{{ preg_replace('/[^\d+]/', '', $siteContact->phone_1) }}" style="color:rgba(255,255,255,.6);font-size:.875rem;">{{ $siteContact->phone_1 }}</a>
            </div>
            @endif
            @if($siteContact->email)
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-envelope" style="color:var(--accent);font-size:.9rem;"></i>
                <a href="mailto:{{ $siteContact->email }}" style="color:rgba(255,255,255,.6);font-size:.875rem;">{{ $siteContact->email }}</a>
            </div>
            @endif
        </div>
    </div>
</section>

@endsection
