<section class="banner-area banner-bg-five tg-motion-effects" data-background="{{ asset($hero?->global_content?->hero_background) }}">
    <div class="banner-bg-five-shape" data-background="{{ asset('frontend/img/banner/h5_hero_bg_shape.svg') }}"></div>
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-xl-5 col-lg-5">
                <div class="banner__content-five">
                    <span class="sub-title" data-aos="fade-right" data-aos-delay="200">{{ $hero?->content?->short_title }}</span>
                    <h2 class="title" data-aos="fade-right" data-aos-delay="400">{!! clean(processText($hero?->content?->title)) !!}</h2>
                    <p data-aos="fade-right" data-aos-delay="600">{!! clean(processText($hero?->content?->sub_title)) !!}</p>
                    <div class="banner__btn" data-aos="fade-right" data-aos-delay="800">
                        @if ($hero?->content?->action_button_text != null)
                        <a href="{{ $hero?->global_content?->action_button_url }}" class="btn arrow-btn">{{ $hero?->content?->action_button_text }} <img src="{{ asset('frontend/img/icons/right_arrow.svg') }}" alt="img" class="injectable"></a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-xl-7 col-lg-7 col-md-9 col-sm-10">
                <div class="banner__images-five">
                    <img src="{{ asset($hero?->global_content?->banner_image) }}" alt="{{ $hero?->content?->short_title }}">
                    <div class="shape-wrap">
                        <div class="shape-one" data-aos="fade-up-right" data-aos-delay="800">
                            <img src="{{ asset('frontend/img/banner/h5_hero_shape04.svg') }}" alt="shape" class="tg-motion-effects1">
                        </div>
                        <div class="shape-two" data-aos="fade-down-left" data-aos-delay="800">
                            <img src="{{ asset('frontend/img/banner/h5_hero_shape05.svg') }}" alt="shape" class="tg-motion-effects3">
                        </div>
                        <div class="shape-three" data-aos="fade-up-left" data-aos-delay="800">
                            <img src="{{ asset('frontend/img/banner/h5_hero_shape06.svg') }}" alt="shape">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="banner__shape-wrap-two">
        <img src="{{ asset('frontend/img/banner/h5_hero_shape01.svg') }}" alt="shape" data-aos="fade-right" data-aos-delay="1000">
        <img src="{{ asset('frontend/img/banner/h5_hero_shape02.svg') }}" alt="shape" class="tg-motion-effects7">
        <img src="{{ asset('frontend/img/banner/h5_hero_shape03.svg') }}" alt="shape" class="tg-motion-effects3">
    </div>
</section>
