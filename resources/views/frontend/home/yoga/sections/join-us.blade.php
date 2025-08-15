<section class="video__area">
    <div class="video__bg" data-background="{{ asset($bannerSection?->global_content?->bg_image) }}"></div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-7 col-lg-6 order-0 order-lg-2">
                @if ($bannerSection?->global_content?->video_url)
                    <div class="video__play-btn">
                        <a href="{{ $bannerSection?->global_content?->video_url }}" class="popup-video"><i
                                class="fas fa-play"></i></a>
                    </div>
                @endif
            </div>
            <div class="col-xl-5 col-lg-6">
                <div class="video__content">
                    <h2 class="title">{{ __('Finding Your Right Courses') }}</h2>
                            <p>{{ __('Unlock your potential by joining our vibrant learning community') }}</p>
                    <a href="{{ route('register') }}" class="btn btn-three arrow-btn">{{ __('Join class Now') }} <img
                            src="{{ asset('frontend/img/icons/right_arrow.svg') }}" alt="" class="injectable"></a>
                </div>
            </div>
        </div>
    </div>
</section>
