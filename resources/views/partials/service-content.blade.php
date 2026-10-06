@php $locale = app()->getLocale(); $currentRoute = Route::currentRouteName(); @endphp

{{-- Page hero --}}
<div class="page-hero">
    <div class="container-sm">
        <div class="page-hero__content">
            <h1 class="page-hero__title">@lang('menu.' . $menuKey)</h1>
            <ul class="page-hero__breadcrumb">
                <li><a href="{{ route('home', ['locale' => $locale]) }}">@lang('menu.home')</a></li>
                <li class="sep"><i class="fas fa-chevron-right"></i></li>
                <li><a href="{{ route('services', ['locale' => $locale]) }}">@lang('menu.services')</a></li>
                <li class="sep"><i class="fas fa-chevron-right"></i></li>
                <li>@lang('menu.' . $menuKey)</li>
            </ul>
        </div>
    </div>
</div>

<section class="py-24 bg-white">
    <div class="container-sm">
        <div class="row g-4 gutter-y-50 align-items-start">

            {{-- Sidebar (2e sur mobile, 1re sur desktop) --}}
            <div class="col-lg-4 order-2 order-lg-1 wow fadeInLeft" data-wow-duration="900ms">
                <div style="position:sticky;top:110px;">
                    @include('partials.service_sidebar')
                </div>
            </div>

            {{-- Main content (1er sur mobile, 2e sur desktop) --}}
            <div class="col-lg-8 order-1 order-lg-2 wow fadeInRight" data-wow-duration="900ms" data-wow-delay="100ms">

                <div class="service-detail__thumbnail mb-6" style="position:relative;">
                    <img src="{{ asset('assets/images/services/' . $image) }}"
                         alt="@lang('menu.' . $menuKey)">
                </div>

                {{-- Trois engagements clés — repris tels quels de la page d'accueil,
                     même registre que "Agréé & réglementé / Réponse 48h / Multi-devises". --}}
                <div class="service-value-props mb-6">
                    @foreach ([1 => 'fa-shield-alt', 2 => 'fa-bolt', 3 => 'fa-globe'] as $n => $icon)
                    <div class="service-value-props__item">
                        <div class="service-value-props__icon"><i class="fas {{ $icon }}"></i></div>
                        <div>
                            <div class="service-value-props__title">{{ __('home.about.engage' . $n . '_title') }}</div>
                            <p class="service-value-props__desc">{{ __('home.about.engage' . $n . '_desc') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                <h2 class="service-detail__title">@lang('loan.' . $loanKey . '.section_title')</h2>
                <p class="service-detail__text">{{ __('loan.' . $loanKey . '.description') }}</p>

                <div class="service-detail__advantages mb-6">
                    <h4 class="service-detail__advantages__title">{{ __('loan.service_benefits_title') }}</h4>
                    <div class="advantage-grid">
                        @foreach ([1,2,3,4] as $n)
                        <div class="advantage-grid__item">
                            <i class="fas fa-check-circle advantage-grid__icon"></i>
                            <span>{{ __('loan.' . $loanKey . '.details.advantage' . $n) }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Comment ça marche — process en 4 etapes, contenu deja traduit
                     et partage avec la page d'accueil (identique quel que soit le pret). --}}
                <div class="service-process mb-6">
                    <h4 class="service-detail__advantages__title">{{ __('home.works.sectitle') }}</h4>
                    <div class="service-process__list">
                        @foreach ([1,2,3,4] as $s)
                        <div class="service-process__item">
                            <span class="service-process__num">0{{ $s }}</span>
                            <div>
                                <div class="service-process__title">{{ __('home.works.step' . $s . '.title') }}</div>
                                <p class="service-process__desc">{{ __('home.works.step' . $s . '.desc') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <h3 class="service-detail__title" style="font-size:1.25rem;">
                    {{ __('loan.' . $loanKey . '.details.faq_title') }}
                </h3>

                <div x-data="{ open: 1 }">
                    @foreach ([1,2,3] as $n)
                    <div class="accordion-item mb-1" style="border-radius:var(--radius);overflow:hidden;box-shadow:var(--shadow-card);">
                        <button type="button"
                                class="faq-btn"
                                :class="open === {{ $n }} ? 'is-open' : ''"
                                @click="open = (open === {{ $n }}) ? null : {{ $n }}">
                            <span>{{ __('loan.' . $loanKey . '.details.faqs.question' . $n) }}</span>
                            <span class="faq-btn__icon">
                                <i class="fas fa-chevron-down"></i>
                            </span>
                        </button>
                        <div class="faq-body"
                             x-show="open === {{ $n }}"
                             x-transition:enter="transition ease-out duration-250"
                             x-transition:enter-start="opacity-0 -translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 -translate-y-2"
                             style="{{ $n !== 1 ? 'display:none' : '' }}">
                            {{ __('loan.' . $loanKey . '.details.faqs.answer' . $n) }}
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="service-detail__cta">
                    <a href="{{ route('loan', ['locale' => $locale]) }}" class="btn-primary btn-primary--lg">
                        <i class="fas fa-file-signature"></i> @lang('menu.loan')
                    </a>
                    <a href="{{ route('contact', ['locale' => $locale]) }}" class="btn-outline btn-outline--lg">
                        <i class="fas fa-envelope"></i> @lang('menu.contact')
                    </a>
                </div>

            </div>

        </div>
    </div>
</section>

{{-- Calculator strip --}}
<section class="calc-section py-16">
    <div class="container-sm">
        <div class="row g-4 gutter-y-50 align-items-center">
            <div class="col-lg-6 wow fadeInLeft" data-wow-duration="900ms">
                <div class="section-label" style="color:var(--accent);">Simulation</div>
                <h2 class="section-title section-title--white mb-4">@lang('home.simulate.sectitle')</h2>
                <p class="section-sub section-sub--white">{{ __('loan.' . $loanKey . '.description') }}</p>
            </div>
            <div class="col-lg-6 wow fadeInRight" data-wow-duration="900ms" data-wow-delay="150ms">
                @include('partials.simulate')
            </div>
        </div>
    </div>
</section>

{{-- Produits associés — cross-sell vers les 5 autres types de prêt --}}
<section class="py-24" style="background:var(--cream);">
    <div class="container-sm">
        <div class="text-center mb-4" style="max-width:640px;margin-left:auto;margin-right:auto;">
            <div class="rule-label rule-label--center">{{ __('menu.services') }}</div>
            <h2 class="section-title">{{ __('loan.service_related_title') }}</h2>
            <p style="color:var(--gray-500);font-size:.95rem;">{{ __('loan.service_related_sub') }}</p>
        </div>

        @php
        $allServices = [
            ['route' => 'services.personal', 'key' => 'personal_loan', 'label' => 'menu.personal',  'icon' => 'fas fa-user-tie'],
            ['route' => 'services.home',     'key' => 'home_loan',     'label' => 'menu.home_loan', 'icon' => 'fas fa-key'],
            ['route' => 'services.auto',     'key' => 'auto_loan',     'label' => 'menu.auto',      'icon' => 'fas fa-car'],
            ['route' => 'services.business', 'key' => 'business_loan', 'label' => 'menu.business',  'icon' => 'fas fa-briefcase'],
            ['route' => 'services.study',    'key' => 'study_loan',    'label' => 'menu.study',     'icon' => 'fas fa-graduation-cap'],
            ['route' => 'services.bike',     'key' => 'bike_loan',     'label' => 'menu.bike',      'icon' => 'fas fa-motorcycle'],
        ];
        $relatedServices = array_values(array_filter($allServices, fn($s) => $s['route'] !== ($currentRoute ?? '')));
        @endphp
        <div class="offer-grid">
            @foreach ($relatedServices as $i => $svc)
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
