<div class="brand-area-three section-pb-120">
    <div class="container">
        <div class="swiper-container brand-swiper-active">
            <div class="swiper-wrapper">
                @foreach ($brands as $brand)
                    <div class="swiper-slide">
                        <div class="brand__item-two">
                            <a href="{{ $brand?->url }}"><img src="{{ asset($brand?->image) }}" alt="{{ $brand?->name }}"></a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
