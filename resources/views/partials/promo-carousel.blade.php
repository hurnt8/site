{{-- ============================================================
     BANDEAU D'OFFRES — carrousel promotionnel (partagé)
     Attend une variable $locale dans le scope appelant.
============================================================ --}}
@push('styles')
<style>
.promo-carousel {
    position:relative; overflow:hidden;
    background:var(--navy);
}
.promo-carousel__track { display:flex; transition:transform .55s cubic-bezier(.65,0,.35,1); }
.promo-slide {
    flex:0 0 100%; width:100%;
    min-height:440px;
    display:flex; align-items:center;
    background-size:cover; background-position:center;
    position:relative;
}
.promo-slide::before {
    content:''; position:absolute; inset:0;
    background:linear-gradient(90deg, rgba(14,59,46,.96) 0%, rgba(14,59,46,.88) 38%, rgba(14,59,46,.4) 68%, rgba(14,59,46,.15) 100%);
}
@media (max-width:768px) {
    .promo-slide { min-height:520px; }
    .promo-slide::before { background:linear-gradient(180deg, rgba(14,59,46,.75) 0%, rgba(14,59,46,.94) 55%, var(--navy) 100%); }
}
.promo-slide__inner {
    position:relative; z-index:1;
    max-width:520px; padding:3rem 1.75rem;
}
@media (min-width:768px)  { .promo-slide__inner { padding:3rem 2rem 3rem 4rem; } }
@media (min-width:1200px) { .promo-slide__inner { padding:3rem 2rem 3rem 6rem; } }
.promo-slide__tag {
    display:inline-flex; align-items:center; gap:.4rem;
    background:rgba(255,255,255,.16); border:1px solid rgba(255,255,255,.32);
    color:#fff; font-size:.68rem; font-weight:800; text-transform:uppercase;
    letter-spacing:.1em; padding:.3rem .9rem; border-radius:999px; margin-bottom:1.1rem;
}
.promo-slide__title {
    font-family:'Fraunces',serif; color:#fff; font-weight:700;
    font-size:clamp(1.5rem,3vw,2.35rem); line-height:1.22; margin:0 0 .75rem;
    text-shadow:0 2px 16px rgba(0,0,0,.25);
}
.promo-slide__text { color:rgba(255,255,255,.75); font-size:.95rem; line-height:1.65; margin:0 0 1.75rem; max-width:420px; }

.promo-carousel__credit {
    position:absolute; bottom:.6rem; right:.9rem; z-index:1;
    font-size:.62rem; color:rgba(255,255,255,.4); text-decoration:none;
}
.promo-carousel__credit:hover { color:rgba(255,255,255,.7); }

.promo-carousel__dots {
    position:absolute; bottom:1rem; left:0; right:0;
    display:flex; align-items:center; justify-content:center; gap:.45rem;
    z-index:1;
}
.promo-carousel__dot {
    width:8px; height:8px; border-radius:999px; background:rgba(255,255,255,.35);
    border:none; padding:0; cursor:pointer; transition:all .2s;
}
.promo-carousel__dot.active { background:var(--accent); width:22px; }

.promo-carousel__arrow {
    position:absolute; top:50%; transform:translateY(-50%);
    width:40px; height:40px; border-radius:50%;
    background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.25);
    color:#fff; display:flex; align-items:center; justify-content:center;
    cursor:pointer; transition:background .2s; z-index:2; font-size:.8rem;
    backdrop-filter:blur(4px);
}
.promo-carousel__arrow:hover { background:rgba(255,255,255,.22); }
.promo-carousel__arrow--prev { left:1rem; }
.promo-carousel__arrow--next { right:1rem; }
@media (max-width: 640px) { .promo-carousel__arrow { display:none; } }
</style>
@endpush

@php
$promoSlides = [
    [
        'tag' => __('home.promo.slide1.tag'), 'title' => __('home.promo.slide1.title'),
        'text' => __('home.promo.slide1.text'), 'cta' => __('home.promo.slide1.cta'),
        'href' => route('loan', ['locale' => $locale]),
        'image' => asset('assets/images/promo/promo-personal.jpg'),
    ],
    [
        'tag' => __('home.promo.slide2.tag'), 'title' => __('home.promo.slide2.title'),
        'text' => __('home.promo.slide2.text'), 'cta' => __('home.promo.slide2.cta'),
        'href' => route('services.home', ['locale' => $locale]),
        'image' => asset('assets/images/promo/promo-home.jpg'),
        'credit' => ['label' => 'Photo : Shixart1985 (CC BY 2.0)', 'url' => 'https://commons.wikimedia.org/wiki/User:Shixart1985'],
    ],
    [
        'tag' => __('home.promo.slide3.tag'), 'title' => __('home.promo.slide3.title'),
        'text' => __('home.promo.slide3.text'), 'cta' => __('home.promo.slide3.cta'),
        'href' => route('home', ['locale' => $locale]) . '#simulate',
        'image' => asset('assets/images/promo/promo-simulate.jpg'),
    ],
];
@endphp
<section class="promo-carousel" x-data="promoCarousel({{ count($promoSlides) }})" @mouseenter="pause()" @mouseleave="resume()">
    <button type="button" class="promo-carousel__arrow promo-carousel__arrow--prev" @click="prev()" aria-label="Précédent">
        <i class="fas fa-chevron-left"></i>
    </button>
    <button type="button" class="promo-carousel__arrow promo-carousel__arrow--next" @click="next()" aria-label="Suivant">
        <i class="fas fa-chevron-right"></i>
    </button>

    <div class="promo-carousel__track" :style="`transform:translateX(-${active * 100}%)`">
        @foreach ($promoSlides as $slide)
        <div class="promo-slide" style="background-image:url('{{ $slide['image'] }}')">
            <div class="promo-slide__inner">
                <span class="promo-slide__tag">{{ $slide['tag'] }}</span>
                <h2 class="promo-slide__title">{{ $slide['title'] }}</h2>
                <p class="promo-slide__text">{{ $slide['text'] }}</p>
                <a href="{{ $slide['href'] }}" class="btn-primary btn-primary--lg">
                    {{ $slide['cta'] }} <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            @if (!empty($slide['credit']))
            <a href="{{ $slide['credit']['url'] }}" target="_blank" rel="noopener" class="promo-carousel__credit">{{ $slide['credit']['label'] }}</a>
            @endif
        </div>
        @endforeach
    </div>

    <div class="promo-carousel__dots">
        <template x-for="i in total" :key="i">
            <button type="button" class="promo-carousel__dot" :class="{ active: active === i - 1 }" @click="goTo(i - 1)"
                    :aria-label="'Diapositive ' + i"></button>
        </template>
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    if (Alpine._promoCarouselRegistered) return;
    Alpine._promoCarouselRegistered = true;
    Alpine.data('promoCarousel', (total) => ({
        total: total,
        active: 0,
        timer: null,
        init() { this.start(); },
        start() { this.timer = setInterval(() => this.next(), 6000); },
        pause() { clearInterval(this.timer); },
        resume() { this.start(); },
        next() { this.active = (this.active + 1) % this.total; },
        prev() { this.active = (this.active - 1 + this.total) % this.total; },
        goTo(i) { this.active = i; },
    }));
});
</script>
@endpush
