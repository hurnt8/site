@php $locale = app()->getLocale(); @endphp
<div class="service-nav-strip" id="services-strip">
    <div class="service-nav-strip__inner">
        @foreach ([
            ['services.personal', 'fa-user-tie',       'menu.personal'],
            ['services.home',     'fa-home',           'menu.home_loan'],
            ['services.auto',     'fa-car',            'menu.auto'],
            ['services.business', 'fa-briefcase',      'menu.business'],
            ['services.study',    'fa-graduation-cap', 'menu.study'],
            ['services.bike',     'fa-bicycle',        'menu.bike'],
        ] as [$route, $icon, $label])
        <a href="{{ route($route, ['locale' => $locale]) }}" class="service-nav-strip__item">
            <div class="service-nav-strip__icon"><i class="fas {{ $icon }}"></i></div>
            <span class="service-nav-strip__label">@lang($label)</span>
        </a>
        @endforeach
    </div>
</div>
