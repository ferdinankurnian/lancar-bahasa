<section class="cta__area-four">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <div class="cta__inner-wrap">
                    <div class="cta__img-three tg-svg">
                        <img src="{{ asset($bannerSection?->global_content?->student_image) }}" alt="img">
                        <span class="svg-icon" id="cta-svg"
                            data-svg-icon="{{ asset('frontend/img/others/rh8_cta_img_shape.svg') }}"></span>
                    </div>
                    <div class="cta__content-three cta__content-four">
                        <div class="content__left">
                            <h2 class="title">{{ __('Finding Your Right Courses') }}</h2>
                            <p>{{ __('Unlock your potential by joining our vibrant learning community') }}</p>
                        </div>
                        <a href="{{ route('register') }}" class="btn arrow-btn">{{ __('Get Started') }} <img
                                src="{{ asset('frontend/img/icons/right_arrow.svg') }}" alt="" class="injectable"></a>
                    </div>
                    <img src="{{ asset('frontend/img/others/h8_cta_shape.svg') }}" alt="shape" class="shape">
                </div>
            </div>
        </div>
    </div>
</section>