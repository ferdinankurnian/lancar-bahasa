<section class="cta__area home_3_cta">
    <div class="cta__bg" data-background="{{ asset($bannerSection?->global_content?->bg_image) }}"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="cta__content">
                    <h2 class="title">{{ __('Together We Go Far') }}</h2>
                    <p>{{ __('Through research and discovery, we are changing the world.') }}</p>
                    <a href="{{ route('register') }}" class="btn arrow-btn">{{ __('Join With Us') }} <img
                            src="{{ asset('frontend/img/icons/right_arrow.svg') }}" alt=""
                            class="injectable"></a>
                </div>
            </div>
        </div>
    </div>
</section>
