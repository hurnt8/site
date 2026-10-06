@extends('layouts.app')
@section('title', __('menu.about'))

@section('content')
@php $locale = app()->getLocale(); @endphp

{{-- Page hero --}}
<div class="page-hero">
    <div class="container-sm">
        <div class="page-hero__content">
            <h1 class="page-hero__title">@lang('menu.about')</h1>
            <ul class="page-hero__breadcrumb">
                <li><a href="{{ route('home', ['locale' => $locale]) }}">@lang('menu.home')</a></li>
                <li class="sep"><i class="fas fa-chevron-right"></i></li>
                <li>@lang('menu.about')</li>
            </ul>
        </div>
    </div>
</div>

{{-- Intro --}}
<section class="py-24 bg-white">
    <div class="container-sm">
        <div class="row g-4 gutter-y-40 align-items-center">
            <div class="col-lg-6 wow fadeInLeft" data-wow-duration="900ms">
                <div class="rule-label">{{ __('about.hero_tagline') }}</div>
                <h2 class="section-title mb-4">{{ __('about.hero_title') }}</h2>
                <p style="color:var(--gray-500);font-size:1rem;line-height:1.85;margin:0;">
                    {{ __('about.hero_text') }}
                </p>
            </div>
            <div class="col-lg-6 wow fadeInRight" data-wow-duration="900ms" data-wow-delay="150ms">
                <div class="about-image-wrap">
                    <img src="{{ asset('assets/images/refonte/bureaux-reunion.jpg') }}"
                         alt="{{ site_name() }}" class="about-image-main">
                    <div class="about-badge">
                        <span class="about-badge__number">8</span>
                        <span class="about-badge__label">{{ __('home.about.exptitle') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Mission / histoire --}}
<section class="py-24" style="background:var(--cream);">
    <div class="container-sm">
        <div class="row g-4 gutter-y-40 align-items-center">
            <div class="col-lg-6 order-lg-2 wow fadeInRight" data-wow-duration="900ms">
                <div class="rule-label">{{ __('about.mission_tagline') }}</div>
                <h2 class="section-title mb-4">{{ __('about.mission_title') }}</h2>
                <p style="color:var(--gray-500);font-size:.9375rem;line-height:1.85;margin-bottom:1.25rem;">
                    {{ __('about.mission_p1') }}
                </p>
                <p style="color:var(--gray-500);font-size:.9375rem;line-height:1.85;margin:0;">
                    {{ __('about.mission_p2') }}
                </p>
            </div>
            <div class="col-lg-6 order-lg-1 wow fadeInLeft" data-wow-duration="900ms" data-wow-delay="150ms">
                <img src="{{ asset('assets/images/refonte/bureaux-couloir.jpg') }}"
                     alt="{{ site_name() }}"
                     style="width:100%;border-radius:var(--radius-xl);height:420px;object-fit:cover;box-shadow:var(--shadow-hover);">
            </div>
        </div>
    </div>
</section>

{{-- Stats --}}
<section style="background:var(--navy);">
    <div class="container-sm">
        <div class="text-center pt-16" style="padding-top:4rem;">
            <div class="section-label justify-content-center" style="color:var(--accent);">{{ __('about.stats_tagline') }}</div>
            <h2 class="section-title section-title--white mb-0">{{ __('about.stats_title') }}</h2>
        </div>
        <div class="row">
            @php
            $stats = [
                ['stop'=>'8500','suffix'=>'+','prefix'=>'', 'label'=> __('home.customer_satisfaction_rate')],
                ['stop'=>'5',    'suffix'=>'M','prefix'=>'€','label'=> __('home.total_loan_amount_granted')],
                ['stop'=>'48',  'suffix'=>'h','prefix'=>'', 'label'=> __('home.average_approval_time')],
                ['stop'=>'8',    'suffix'=>'+','prefix'=>'', 'label'=> __('home.years_experience')],
            ];
            @endphp
            @foreach ($stats as $i => $stat)
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-duration="800ms" data-wow-delay="{{ $i*80 }}ms">
                <div class="stat-item {{ $i < 3 ? 'stat-item--sep' : '' }}">
                    <div class="stat-item__number">
                        @if($stat['prefix'])<span style="font-size:.6em;margin-right:2px;">{{ $stat['prefix'] }}</span>@endif
                        <span class="count-text" data-stop="{{ $stat['stop'] }}" data-speed="1500">{{ $stat['stop'] }}</span>
                        @if($stat['suffix'])<span style="font-size:.6em;margin-left:2px;">{{ $stat['suffix'] }}</span>@endif
                    </div>
                    <div class="stat-item__label">{{ $stat['label'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Nos valeurs --}}
<section class="py-24 bg-white">
    <div class="container-sm">
        <div class="text-center mb-14">
            <div class="section-label justify-content-center">{{ __('about.values_tagline') }}</div>
            <h2 class="section-title">{{ __('about.values_title') }}</h2>
        </div>
        <div class="row g-4 gutter-y-30">
            @php
            $values = [
                ['icon' => 'fas fa-balance-scale', 'title' => __('about.value1_title'), 'desc' => __('about.value1_desc')],
                ['icon' => 'fas fa-bolt',            'title' => __('about.value2_title'), 'desc' => __('about.value2_desc')],
                ['icon' => 'fas fa-user-tie',        'title' => __('about.value3_title'), 'desc' => __('about.value3_desc')],
                ['icon' => 'fas fa-shield-alt',      'title' => __('about.value4_title'), 'desc' => __('about.value4_desc')],
            ];
            @endphp
            @foreach ($values as $i => $v)
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-duration="800ms" data-wow-delay="{{ $i * 80 }}ms">
                <div class="card-glass p-8" style="padding:2rem;height:100%;">
                    <div style="width:52px;height:52px;background:var(--accent-pale);border-radius:var(--radius-sm);display:flex;align-items:center;justify-content:center;color:var(--accent-dark);font-size:1.25rem;margin-bottom:1.25rem;">
                        <i class="{{ $v['icon'] }}"></i>
                    </div>
                    <h3 style="font-family:'Fraunces',serif;font-size:1.0625rem;font-weight:700;color:var(--navy);margin-bottom:.625rem;">
                        {{ $v['title'] }}
                    </h3>
                    <p style="font-size:.85rem;color:var(--gray-500);line-height:1.7;margin:0;">
                        {{ $v['desc'] }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Comment nous travaillons --}}
<section class="py-24" style="background:var(--cream);">
    <div class="container-sm">
        <div class="row g-4 gutter-y-40 align-items-center">
            <div class="col-lg-5 wow fadeInLeft" data-wow-duration="900ms">
                <div class="rule-label">{{ __('about.approach_tagline') }}</div>
                <h2 class="section-title mb-4">{{ __('about.approach_title') }}</h2>
                <img src="{{ asset('assets/images/refonte/about-handshake.jpg') }}"
                     alt="{{ site_name() }}"
                     style="width:100%;border-radius:var(--radius-xl);height:280px;object-fit:cover;box-shadow:var(--shadow-hover);">
            </div>
            <div class="col-lg-7 wow fadeInRight" data-wow-duration="900ms" data-wow-delay="150ms">
                <div class="steps-list">
                    @foreach ([1,2,3] as $s)
                    <div class="step-row">
                        <div class="step-row__num">0{{ $s }}</div>
                        <div class="step-row__title">{{ __('about.approach' . $s . '_title') }}</div>
                        <p class="step-row__desc">{{ __('about.approach' . $s . '_desc') }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="cta-banner">
    <div class="container-sm">
        <div class="row align-items-center gutter-y-30">
            <div class="col-lg-8 wow fadeInLeft" data-wow-duration="900ms">
                <div class="section-label" style="color:var(--accent);">{{ __('about.cta_tagline') }}</div>
                <h2 class="section-title section-title--white mb-2">{{ __('about.cta_title') }}</h2>
                <p class="section-sub section-sub--white">{{ __('about.cta_text') }}</p>
            </div>
            <div class="col-lg-4 text-lg-end wow fadeInRight" data-wow-duration="900ms" data-wow-delay="100ms">
                <a href="{{ route('loan', ['locale' => $locale]) }}" class="btn-primary btn-primary--lg">
                    <i class="fas fa-file-signature"></i> @lang('menu.loan')
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
