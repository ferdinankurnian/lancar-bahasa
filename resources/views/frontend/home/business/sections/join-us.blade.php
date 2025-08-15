<section class="cta__area-three">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <div class="cta__bg-three" data-background="{{ asset('frontend/img/bg/h7_cta_bg.jpg') }}">
                    <div class="cta__img-two">
                        <img src="{{ asset($bannerSection?->global_content?->student_image) }}" alt="img">
                    </div>
                    <div class="cta__content-three">
                        <div class="content__left">
                            <h2 class="title">{{ __('Finding Your Right Courses') }}</h2>
                            <p>{{ __('Unlock your potential by joining our vibrant learning community') }}</p>
                        </div>
                        <a href="{{ route('register') }}" class="btn arrow-btn">{{ __('Get Started') }} <img src="{{ asset('frontend/img/icons/right_arrow.svg') }}" alt="" class="injectable"></a>
                    </div>
                    <div class="cta__shape-two">
                        <img src="{{ asset('frontend/img/others/h7_cta_shape.svg') }}" alt="shape">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>