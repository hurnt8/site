@extends('layouts.app')
@section('title', __('menu.loan'))

@php
    $loanSetting = \App\Models\LoanSetting::current();
    $siteContact = \App\Models\SiteContact::current();
    $currenciesForForm = \App\Models\Currency::enabledList();
@endphp

@push('styles')
<style>
/* ── Blocs du formulaire ── */
.loan-block {
    border:1px solid var(--gray-200); border-radius:var(--radius-xl,.375rem);
    background:#fff; padding:1.4rem 1.4rem 1.5rem; margin-bottom:1.25rem;
}
.loan-block__head { display:flex; align-items:center; gap:.8rem; margin-bottom:1.15rem; }
.loan-block__num {
    width:30px; height:30px; flex-shrink:0; display:flex; align-items:center; justify-content:center;
    background:var(--forest,#0E3B2E); color:var(--brass-light,#DCBE87); border-radius:var(--radius,.25rem);
    font-family:var(--font-display,'Fraunces',Georgia,serif); font-weight:700; font-size:.95rem;
}
.loan-block__title { font-family:var(--font-display,'Fraunces',Georgia,serif); font-weight:700; color:var(--forest,#0E3B2E); font-size:1.05rem; margin:0; line-height:1.2; }
.loan-block__hint  { font-size:.76rem; color:var(--gray-500); margin:.1rem 0 0; }

.loan-block input, .loan-block select, .loan-block textarea, .loan-block button { font-family:var(--font-body,'Outfit',sans-serif); }
.loan-grid { align-items:end; display:grid; grid-template-columns:repeat(3,1fr); gap:1rem; }
@media (max-width:767px) { .loan-grid { grid-template-columns:1fr; } }
.loan-field label {
    display:block; font-size:.7rem; font-weight:700; letter-spacing:.06em; text-transform:uppercase;
    color:var(--forest,#0E3B2E); margin-bottom:.4rem;
}
.loan-field .form-control { width:100%; height:50px; }
.loan-input { position:relative; }
.loan-input input { padding-right:3.4rem; font-weight:600; }
.loan-input__unit {
    position:absolute; right:.9rem; top:50%; transform:translateY(-50%);
    font-size:.82rem; font-weight:700; color:var(--brass-dark,#9A7736); pointer-events:none;
}
.loan-rate { margin-left:auto; display:inline-flex; align-items:center; gap:.4rem; background:var(--brass-pale,#F5EDDD); color:var(--brass-dark,#9A7736); padding:.35rem .85rem; border-radius:999px; font-weight:800; font-size:.78rem; white-space:nowrap; }
.loan-field label { min-height:2.4em; display:flex; align-items:flex-end; }
.loan-error { font-size:.74rem; color:#b91c1c; margin:.45rem 0 0; }

/* ── Détails de la demande (toujours visibles) ── */
.quote-result {
    margin-top:1.4rem; background:var(--forest,#0E3B2E); border-radius:var(--radius-xl,.375rem);
    border-top:4px solid var(--brass,#C6A15B); color:#fff; overflow:hidden;
    box-shadow:0 8px 24px rgba(14,59,46,.18);
}
.quote-result__head {
    display:flex; align-items:center; gap:.6rem; padding:.9rem 1.4rem;
    background:rgba(255,255,255,.06); border-bottom:1px solid rgba(255,255,255,.12);
    font-family:var(--font-display,'Fraunces',Georgia,serif); font-weight:700; font-size:1rem; color:#fff;
}
.quote-result__head i { color:var(--brass-light,#DCBE87); }
.quote-result__main {
    padding:1.3rem 1.4rem 1.1rem; text-align:center; border-bottom:1px solid rgba(255,255,255,.12);
}
.quote-result__main .quote-result__label { font-size:.74rem; }
.quote-result__main .quote-result__value { font-size:2.2rem; color:var(--brass-light,#DCBE87); line-height:1.15; }
.quote-result__grid { display:grid; grid-template-columns:repeat(6,1fr); }
.quote-result__cell { grid-column:span 2; }
.quote-result__cell:nth-child(n+4) { grid-column:span 3; border-top:1px solid rgba(255,255,255,.12); }
.quote-result__cell:nth-child(4) { border-left:0 !important; }
.quote-result__cell { padding:1rem 1.1rem; text-align:center; }
.quote-result__cell + .quote-result__cell { border-left:1px solid rgba(255,255,255,.12); }
@media (max-width:575px) {
    .quote-result__grid { grid-template-columns:1fr 1fr; }
    .quote-result__cell, .quote-result__cell:nth-child(n+4) { grid-column:auto; }
    .quote-result__cell:nth-child(3), .quote-result__cell:nth-child(5) { border-left:0 !important; }
    .quote-result__cell:nth-child(n+3) { border-top:1px solid rgba(255,255,255,.12); }
    .quote-result__main .quote-result__value { font-size:1.8rem; }
}
.quote-result__label { font-size:.68rem; text-transform:uppercase; letter-spacing:.1em; color:rgba(255,255,255,.8); display:block; margin-bottom:.3rem; font-weight:600; }
.quote-result__value { font-family:var(--font-display,'Fraunces',Georgia,serif); font-size:1.15rem; font-weight:700; color:#fff; }
.quote-result__foot { padding:.7rem 1.4rem; background:rgba(0,0,0,.14); font-size:.72rem; color:rgba(255,255,255,.75); margin:0; }

.form-section { margin-bottom:1.25rem; }

/* ── Sidebar raisons ── */
.reason-item { display:flex; gap:.75rem; padding:.8rem 0; }
.reason-item + .reason-item { border-top:1px solid #f0f0f0; }
.reason-icon { width:38px; height:38px; border-radius:9px; background:rgba(198,161,91,.1); color:var(--accent,#9A7736); display:flex; align-items:center; justify-content:center; font-size:.9rem; flex-shrink:0; }
.reason-title { font-size:.84rem; font-weight:700; color:var(--navy,#0E3B2E); margin-bottom:.15rem; }
.reason-desc  { font-size:.75rem; color:#6F695D; line-height:1.45; margin:0; }

.country-auto-note {
    font-size: .74rem;
    color: #1a8047;
    margin-top: .35rem;
    display: flex;
    align-items: center;
    gap: .3rem;
}
[x-cloak] { display:none !important; }
</style>
@endpush

@push('scripts')
<script>
// Codes pays ISO 3166-1 (territoires habités uniquement — Antarctique et îles
// inhabitées exclues, sans intérêt pour un pays de résidence).
const CREDIXA_COUNTRY_CODES = [
    'AD','AE','AF','AG','AI','AL','AM','AO','AR','AS','AT','AU','AW','AX','AZ',
    'BA','BB','BD','BE','BF','BG','BH','BI','BJ','BL','BM','BN','BO','BQ','BR','BS','BT','BW','BY','BZ',
    'CA','CC','CD','CF','CG','CH','CI','CK','CL','CM','CN','CO','CR','CU','CV','CW','CX','CY','CZ',
    'DE','DJ','DK','DM','DO','DZ',
    'EC','EE','EG','EH','ER','ES','ET',
    'FI','FJ','FK','FM','FO','FR',
    'GA','GB','GD','GE','GF','GG','GH','GI','GL','GM','GN','GP','GQ','GR','GT','GU','GW','GY',
    'HK','HN','HR','HT','HU',
    'ID','IE','IL','IM','IN','IO','IQ','IR','IS','IT',
    'JE','JM','JO','JP',
    'KE','KG','KH','KI','KM','KN','KP','KR','KW','KY','KZ',
    'LA','LB','LC','LI','LK','LR','LS','LT','LU','LV','LY',
    'MA','MC','MD','ME','MF','MG','MH','MK','ML','MM','MN','MO','MP','MQ','MR','MS','MT','MU','MV','MW','MX','MY','MZ',
    'NA','NC','NE','NF','NG','NI','NL','NO','NP','NR','NU','NZ',
    'OM',
    'PA','PE','PF','PG','PH','PK','PL','PM','PN','PR','PS','PT','PW','PY',
    'QA',
    'RE','RO','RS','RU','RW',
    'SA','SB','SC','SD','SE','SG','SH','SI','SK','SL','SM','SN','SO','SR','SS','ST','SV','SX','SY','SZ',
    'TC','TD','TG','TH','TJ','TK','TL','TM','TN','TO','TR','TT','TV','TW','TZ',
    'UA','UG','US','UY','UZ',
    'VA','VC','VE','VG','VI','VN','VU',
    'WF','WS',
    'YE','YT',
    'ZA','ZM','ZW',
];

document.addEventListener('alpine:init', () => {
    Alpine.data('loanForm', () => ({
        submitting:  false,
        selCurrency: '{{ \App\Models\Currency::default() }}',
        selAmount:   null,
        customAmt:   '',
        selDuration: null,
        customDur:   '',
        rate: {{ (float) $loanSetting->annual_rate }},
        minAmount: {{ (float) $loanSetting->min_amount }},
        maxAmount: {{ (float) $loanSetting->max_amount }},

        monthsLabel: "{{ __('message.months') }}",
        monthAbbr:   "{{ __('message.month_abbr') }}",
        locale:      "{{ str_replace('_','-',app()->getLocale()) }}",

        country: '{{ old('country', '') }}',
        countries: [],
        countryDetected: false,

        init() {
            this.buildCountries();
            this.detectCountry();
        },

        buildCountries() {
            let displayNames = null;
            try { displayNames = new Intl.DisplayNames([this.locale, 'fr', 'en'], { type: 'region' }); }
            catch (e) { displayNames = null; }

            this.countries = CREDIXA_COUNTRY_CODES
                .map(code => {
                    let name = code;
                    if (displayNames) {
                        try { name = displayNames.of(code) || code; } catch (e) { /* garde le code */ }
                    }
                    return { code, name };
                })
                .sort((a, b) => a.name.localeCompare(b.name, this.locale));
        },

        async detectCountry() {
            if (this.country) return; // déjà rempli (retour arrière / old())

            // 1) Détection par IP (service gratuit, sans clé) — repli silencieux si indisponible.
            try {
                const controller = new AbortController();
                const timer = setTimeout(() => controller.abort(), 3000);
                const res = await fetch('https://get.geojs.io/v1/ip/country.json', { signal: controller.signal });
                clearTimeout(timer);
                if (res.ok) {
                    const json = await res.json();
                    const found = this.countries.find(c => c.code === (json.country || '').toUpperCase());
                    if (found && !this.country) {
                        this.country = found.name;
                        this.countryDetected = true;
                        return;
                    }
                }
            } catch (e) { /* pas de réseau / service bloqué : on tente le repli navigateur */ }

            // 2) Repli : langue du navigateur (ex. "pt-PT" → "PT").
            if (!this.country) {
                const nav = navigator.language || (navigator.languages && navigator.languages[0]) || '';
                const region = nav.split('-')[1];
                if (region) {
                    const found = this.countries.find(c => c.code === region.toUpperCase());
                    if (found) { this.country = found.name; this.countryDetected = true; }
                }
            }
        },

        currencies: (() => {
            // Drapeau derive du code ISO 4217 : ses 2 premieres lettres correspondent
            // presque toujours au code pays ISO 3166-1 (USD->US, BRL->BR, EUR->EU...).
            // Ainsi toute devise ajoutee depuis l'admin obtient automatiquement son
            // drapeau, sans table a maintenir manuellement.
            const flagFromCode = (code) => code.slice(0, 2).toUpperCase()
                .replace(/./g, ch => String.fromCodePoint(127397 + ch.charCodeAt(0)));
            return @json($currenciesForForm->map(fn ($c) => ['code' => $c->code, 'symbol' => $c->symbol, 'name' => $c->name])->values())
                .map(c => ({ ...c, flag: flagFromCode(c.code) }));
        })(),

        amountsByCurrency: {
            EUR:[1000,3000,5000,10000,20000,50000,75000,95000],
            GBP:[1000,2500,5000,10000,20000,40000,65000,80000],
            CHF:[1000,3000,5000,10000,20000,50000,75000,95000],
            NOK:[10000,30000,50000,100000,200000,500000,750000,950000],
            SEK:[10000,30000,50000,100000,200000,500000,750000,950000],
            DKK:[7000,20000,35000,75000,150000,375000,550000,700000],
            PLN:[5000,10000,20000,50000,100000,200000,350000,500000],
            CZK:[25000,75000,125000,250000,500000,1000000,1500000,2000000],
            HUF:[500000,1000000,2000000,4000000,8000000,20000000,30000000,40000000],
            RON:[5000,15000,25000,50000,100000,250000,375000,475000],
        },

        get amounts()  { return this.amountsByCurrency[this.selCurrency] || this.amountsByCurrency['EUR']; },
        get currency() { return this.currencies.find(c => c.code === this.selCurrency) || this.currencies[0]; },

        get amount() {
            const c = parseFloat(this.customAmt);
            if (!isNaN(c) && c > 0) {
                return (c >= this.minAmount && c <= this.maxAmount) ? c : null;
            }
            return this.selAmount;
        },
        get amountOutOfRange() {
            const c = parseFloat(this.customAmt);
            return !isNaN(c) && c > 0 && (c < this.minAmount || c > this.maxAmount);
        },
        get duration() {
            const c = parseInt(this.customDur);
            return (!isNaN(c) && c > 0) ? c : this.selDuration;
        },
        get monthly() {
            const p = parseFloat(this.amount), n = parseInt(this.duration);
            const r = this.rate / 100 / 12;
            if (!p || !n || p <= 0 || n <= 0 || isNaN(p) || isNaN(n)) return null;
            return (p * r * Math.pow(1+r,n)) / (Math.pow(1+r,n) - 1);
        },
        get total()     { return this.monthly ? this.monthly * parseInt(this.duration) : null; },
        get interests() { return (this.total && this.amount) ? this.total - parseFloat(this.amount) : null; },
        get canProceed(){ return this.monthly !== null; },

        fmt(v, dec=2) {
            if (v === null || v === undefined || isNaN(v)) return '—';
            try {
                return new Intl.NumberFormat(this.locale, {
                    style:'currency', currency:this.selCurrency,
                    minimumFractionDigits:dec, maximumFractionDigits:dec,
                }).format(v);
            } catch(e) { return v.toFixed(dec) + ' ' + this.selCurrency; }
        },
        fmtAmt(v) {
            if (!v) return '—';
            try {
                return new Intl.NumberFormat(this.locale, {
                    style:'currency', currency:this.selCurrency,
                    minimumFractionDigits:0, maximumFractionDigits:0,
                }).format(v);
            } catch(e) { return v + ' ' + this.selCurrency; }
        },

        setCurrency(code) {
            if (this.selCurrency === code) return;
            this.selCurrency = code;
            this.selAmount = null; this.customAmt = '';
        },
        pickAmount(v)   { this.selAmount = v; this.customAmt = ''; },
        pickDuration(v) { this.selDuration = v; this.customDur = ''; },
    }));
});
</script>
@endpush

@section('content')
@php $locale = app()->getLocale(); @endphp

<div class="page-hero">
    <div class="container-sm">
        <div class="page-hero__content">
            <h1 class="page-hero__title">@lang('menu.loan')</h1>
            <ul class="page-hero__breadcrumb">
                <li><a href="{{ route('home', ['locale' => $locale]) }}">@lang('menu.home')</a></li>
                <li class="sep"><i class="fas fa-chevron-right"></i></li>
                <li>@lang('menu.loan')</li>
            </ul>
        </div>
    </div>
</div>

<section class="py-24 bg-white">
    <div class="container-sm">
        <div class="row g-4 align-items-start">

            {{-- ══════════ FORMULAIRE PRINCIPAL ══════════ --}}
            <div class="col-lg-8" x-data="loanForm">
                <div class="form-card wow fadeInLeft" data-wow-duration="700ms"
                     style="background:transparent;border:0;box-shadow:none;padding:0;">

                    @if (session('success'))
                    {{-- ══ PANNEAU DE CONFIRMATION ══ --}}
                    <div style="text-align:center;padding:1.5rem .5rem 2rem;">
                        <div style="width:70px;height:70px;border-radius:50%;background:linear-gradient(135deg,#d1fae5,#a7f3d0);margin:0 auto 1.2rem;display:flex;align-items:center;justify-content:center;box-shadow:0 6px 20px rgba(5,150,105,.2);">
                            <i class="fas fa-check" style="font-size:1.8rem;color:#059669;"></i>
                        </div>
                        <h3 style="color:var(--navy,#0E3B2E);font-size:1.2rem;font-weight:800;margin-bottom:.6rem;">
                            {{ session('success') }}
                        </h3>
                        <div class="d-flex flex-wrap justify-content-center gap-3">
                            <a href="{{ route('home', ['locale' => $locale]) }}" class="btn-outline">
                                <i class="fas fa-home"></i> @lang('menu.home')
                            </a>
                            <a href="{{ route('loan', ['locale' => $locale]) }}" class="btn-primary">
                                <i class="fas fa-plus"></i> @lang('menu.loan')
                            </a>
                        </div>
                    </div>
                    @else

                    @if ($errors->any())
                        <div class="alert alert-danger mb-4">
                            @foreach ($errors->all() as $e)<div>{{ $e }}</div>@endforeach
                        </div>
                    @endif

                    {{-- ══ ① Votre financement ══ --}}
                    <div class="loan-block">
                        <div class="loan-block__head">
                            <span class="loan-block__num">1</span>
                            <div>
                                <h4 class="loan-block__title">@lang('loan.quote_step_title')</h4>
                            </div>
                            <div class="loan-rate"><i class="fas fa-lock"></i> @lang('loan.label_rate') : {{ number_format((float) $loanSetting->annual_rate, 2) }} %</div>
                        </div>

                        <div class="loan-grid">
                            <div class="loan-field">
                                <label for="loan-currency">@lang('loan.label_currency')</label>
                                <select id="loan-currency" class="form-control" x-model="selCurrency">
                                    <template x-for="c in currencies" :key="c.code">
                                        <option :value="c.code" x-text="c.flag + '  ' + c.name + ' (' + c.code + ' ' + c.symbol + ')'"></option>
                                    </template>
                                </select>
                            </div>
                            <div class="loan-field">
                                <label for="loan-amount">@lang('loan.label_amount')</label>
                                <div class="loan-input">
                                    <input id="loan-amount" type="number" class="form-control" x-model="customAmt"
                                           :min="minAmount" :max="maxAmount" step="100"
                                           placeholder="5 000">
                                    <span class="loan-input__unit" x-text="currency.symbol"></span>
                                </div>
                            </div>
                            <div class="loan-field">
                                <label for="loan-duration">@lang('loan.label_darly')</label>
                                <div class="loan-input">
                                    <input id="loan-duration" type="number" class="form-control" x-model="customDur"
                                           min="1" max="360" placeholder="Ex : 72">
                                    <span class="loan-input__unit" x-text="monthsLabel"></span>
                                </div>
                            </div>
                        </div>
                        <p class="loan-error" x-show="amountOutOfRange" x-cloak>
                            <i class="fas fa-exclamation-circle" style="margin-right:.25rem;"></i>
                            {{ __('loan.amount_range_hint', ['min' => number_format((float) $loanSetting->min_amount, 0, ',', ' '), 'max' => number_format((float) $loanSetting->max_amount, 0, ',', ' ')]) }}
                        </p>

                        {{-- Détails de la demande : toujours visibles, se remplissent en direct --}}
                        <div class="quote-result">
                            <div class="quote-result__head">
                                <i class="fas fa-file-invoice-dollar"></i> @lang('loan.quote_summary_title')
                            </div>

                            <div class="quote-result__main">
                                <span class="quote-result__label">@lang('loan.quote_monthly')</span>
                                <span class="quote-result__value" x-text="fmt(monthly)">—</span>
                            </div>

                            <div class="quote-result__grid">
                                <div class="quote-result__cell">
                                    <span class="quote-result__label">@lang('loan.label_amount')</span>
                                    <span class="quote-result__value" x-text="amount ? fmtAmt(amount) : '—'">—</span>
                                </div>
                                <div class="quote-result__cell">
                                    <span class="quote-result__label">@lang('loan.label_darly')</span>
                                    <span class="quote-result__value" x-text="duration ? duration + ' ' + monthsLabel : '—'">—</span>
                                </div>
                                <div class="quote-result__cell">
                                    <span class="quote-result__label">@lang('loan.label_rate')</span>
                                    <span class="quote-result__value">{{ number_format((float) $loanSetting->annual_rate, 2) }} %</span>
                                </div>
                                <div class="quote-result__cell">
                                    <span class="quote-result__label">@lang('loan.quote_total')</span>
                                    <span class="quote-result__value" x-text="fmt(total)">—</span>
                                </div>
                                <div class="quote-result__cell">
                                    <span class="quote-result__label">@lang('loan.quote_interest')</span>
                                    <span class="quote-result__value" x-text="fmt(interests)">—</span>
                                </div>
                            </div>

                            <p class="quote-result__foot">
                                <i class="fas fa-info-circle" style="margin-right:.3rem;"></i>{{ __('loan.quote_hint', ['rate' => number_format((float) $loanSetting->annual_rate, 2)]) }}
                            </p>
                        </div>
                    </div>

                    {{-- ══ ② Vos coordonnées ══ --}}
                    <div class="loan-block">
                        <div class="loan-block__head">
                            <span class="loan-block__num">2</span>
                            <div>
                                <h4 class="loan-block__title">@lang('loan.form_title')</h4>
                                <p class="loan-block__hint">@lang('loan.form_hint')</p>
                            </div>
                        </div>

<form method="POST" action="{{ route('loan.request') }}" @submit="submitting = true">
                        @csrf
                        <input type="hidden" name="locale"   value="{{ app()->getLocale() }}">
                        <input type="hidden" name="amount"   :value="amount">
                        <input type="hidden" name="darly"    :value="duration">
                        <input type="hidden" name="currency" :value="selCurrency">

                        <div class="row g-3">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>@lang('loan.label_name') <span style="color:var(--accent,#9A7736);">*</span></label>
                                    <input type="text" name="name" class="form-control"
                                           value="{{ old('name') }}"
                                           placeholder="@lang('loan.placeholder_name')" required>
                                    @error('name')<span class="form-error">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('loan.label_email') <span style="color:var(--accent,#9A7736);">*</span></label>
                                    <input type="email" name="email" class="form-control"
                                           value="{{ old('email') }}"
                                           placeholder="@lang('loan.placeholder_email')" required>
                                    @error('email')<span class="form-error">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('loan.label_phone') <span style="color:var(--accent,#9A7736);">*</span></label>
                                    <input type="text" name="phone" class="form-control"
                                           value="{{ old('phone') }}"
                                           placeholder="@lang('loan.placeholder_phone')" required>
                                    @error('phone')<span class="form-error">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('loan.label_country') <span style="color:var(--accent,#9A7736);">*</span></label>
                                    <select name="country" x-model="country"
                                            class="form-control" required>
                                        <option value="">— @lang('loan.placeholder_country') —</option>
                                        <template x-for="c in countries" :key="c.code">
                                            <option :value="c.name" x-text="c.name"></option>
                                        </template>
                                    </select>
                                    @error('country')<span class="form-error">{{ $message }}</span>@enderror
                                    <p class="country-auto-note" x-show="countryDetected" x-cloak x-transition>
                                        <i class="fas fa-location-crosshairs"></i>
                                        @lang('loan.country_auto_hint')
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('contact.subject') <span style="color:var(--accent,#9A7736);">*</span></label>
                                    <select name="subject" class="form-control" required>
                                        <option value="">— @lang('contact.subject') —</option>
                                        <option value="Prêt personnel"  {{ old('subject')=='Prêt personnel'  ?'selected':'' }}>@lang('menu.personal')</option>
                                        <option value="Prêt immobilier" {{ old('subject')=='Prêt immobilier' ?'selected':'' }}>@lang('menu.home_loan')</option>
                                        <option value="Prêt commercial" {{ old('subject')=='Prêt commercial' ?'selected':'' }}>@lang('menu.business')</option>
                                        <option value="Prêt étudiant"   {{ old('subject')=='Prêt étudiant'   ?'selected':'' }}>@lang('menu.study')</option>
                                        <option value="Prêt auto"       {{ old('subject')=='Prêt auto'       ?'selected':'' }}>@lang('menu.auto')</option>
                                        <option value="Prêt vélo"       {{ old('subject')=='Prêt vélo'       ?'selected':'' }}>@lang('menu.bike')</option>
                                    </select>
                                    @error('subject')<span class="form-error">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>@lang('loan.label_objet')
                                        <span style="font-size:.72rem;color:#A39C8C;font-weight:400;">({{ __('message.optional') }})</span>
                                    </label>
                                    <textarea name="objet" class="form-control" rows="3"
                                              placeholder="@lang('loan.placeholder_objet')">{{ old('objet') }}</textarea>
                                </div>
                            </div>
                            <div class="col-12 mt-1">
                                <button type="submit" class="btn-primary btn-primary--lg w-100 justify-content-center" :disabled="submitting">
                                    <i class="fas fa-spinner fa-spin" x-show="submitting" x-cloak></i>
                                    <i class="fas fa-paper-plane" x-show="!submitting"></i>
                                    <span x-text="submitting ? '{{ __('loan.button_sending') }}' : '{{ __('loan.button') }}'"></span>
                                </button>
                                <p style="font-size:.71rem;color:#A39C8C;text-align:center;margin-top:.55rem;">
                                    <i class="fas fa-lock" style="margin-right:.3rem;"></i>
                                    @lang('loan.form_security')
                                </p>
                            </div>
                        </div>
                    </form>
                    </div>

                    @endif {{-- /session('success') --}}

                </div>
            </div>{{-- /col-lg-8 --}}

            {{-- ══════════ SIDEBAR ══════════ --}}
            <div class="col-lg-4 wow fadeInRight" data-wow-duration="900ms" data-wow-delay="150ms">
                <div style="position:sticky;top:110px;" class="service-sidebar">

                    <div class="contact-widget">
                        <div class="contact-widget__icon"><i class="fas fa-phone-alt"></i></div>
                        <h4>@lang('contact.phone_title')</h4>
                        <p>@lang('loan.sidebar_hours')</p>
                        @if($siteContact->phone_1)
                        <a href="tel:{{ preg_replace('/[^\d+]/', '', $siteContact->phone_1) }}" class="contact-widget__phone">{{ $siteContact->phone_1 }}</a>
                        @endif
                        <a href="{{ route('contact', ['locale' => $locale]) }}"
                           class="btn-outline-white w-100 justify-content-center mt-2">
                            <i class="fas fa-envelope"></i> @lang('menu.contact')
                        </a>
                    </div>

                    <div class="service-sidebar__widget mt-3">
                        <h3 class="service-sidebar__title">@lang('home.loan_reasons.sectitle')</h3>
                        @php
                            $reasonIcons = [
                                1 => 'fa-car',
                                2 => 'fa-layer-group',
                                3 => 'fa-home',
                                4 => 'fa-graduation-cap',
                                5 => 'fa-plane',
                                6 => 'fa-heart',
                                7 => 'fa-stethoscope',
                                8 => 'fa-briefcase',
                            ];
                        @endphp
                        @foreach ($reasonIcons as $r => $icon)
                        <div class="reason-item">
                            <div class="reason-icon"><i class="fas {{ $icon }}"></i></div>
                            <div>
                                <div class="reason-title">@lang('home.loan_reasons.reasons.title' . $r)</div>
                                <p class="reason-desc">@lang('home.loan_reasons.reasons.desc' . $r)</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

{{-- Bande partenaires (signal de confiance) --}}
@push('styles')
<style>
.partners-marquee {
    overflow:hidden; position:relative;
    -webkit-mask-image:linear-gradient(to right, transparent, #000 6%, #000 94%, transparent);
    mask-image:linear-gradient(to right, transparent, #000 6%, #000 94%, transparent);
}
.partners-track {
    display:flex; align-items:center; width:max-content; gap:1.1rem;
    animation:partners-scroll 70s linear infinite;
}
.partners-marquee:hover .partners-track { animation-play-state:paused; }
@keyframes partners-scroll {
    from { transform:translateX(0); }
    to   { transform:translateX(-50%); }
}
.partner-logo {
    display:flex; align-items:center; justify-content:center;
    padding:.8rem 1.5rem; min-width:120px; height:66px;
    background:#fff; border:1.5px solid #E4E0D6; border-radius:12px;
    filter:grayscale(1); opacity:.6;
    transition:filter .3s ease, opacity .3s ease, border-color .3s ease, box-shadow .3s ease;
    cursor:default; flex-shrink:0;
}
.partner-logo:hover {
    filter:grayscale(0); opacity:1;
    border-color:var(--accent,#9A7736); box-shadow:0 4px 22px rgba(198,161,91,.2);
}
.partner-logo--text {
    font-size:.85rem; font-weight:700; color:var(--navy,#0E3B2E);
    text-align:center; line-height:1.3; white-space:nowrap;
}
@media (max-width:576px) {
    .partner-logo { min-width:100px; padding:.65rem 1rem; height:56px; }
    .partners-track { gap:.65rem; animation-duration:45s; }
}
@media (prefers-reduced-motion: reduce) {
    .partners-track { animation:none; flex-wrap:wrap; width:100%; justify-content:center; }
}
</style>
@endpush
<section class="py-10" style="background:#F9F8F5;border-top:1px solid #E4E0D6;border-bottom:1px solid #E4E0D6;">
    <div class="container-sm">
        <p class="text-center" style="font-size:.68rem;font-weight:800;text-transform:uppercase;letter-spacing:.12em;color:#A39C8C;margin-bottom:1.4rem;">
            @lang('home.partners_label')
        </p>
        <div class="partners-marquee">
            <div class="partners-track">
                @foreach (__('home.partners_list') as $bankName)
                <div class="partner-logo partner-logo--text">{{ $bankName }}</div>
                @endforeach
                @foreach (__('home.partners_list') as $bankName)
                <div class="partner-logo partner-logo--text" aria-hidden="true">{{ $bankName }}</div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection
