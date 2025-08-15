<section class="banner-area banner-bg tg-motion-effects" data-background="{{ asset($hero?->global_content?->hero_background) }}">
    <div class="container">
        <div class="row justify-content-between align-items-start">
            <div class="col-xl-5 col-lg-6">
                <div class="banner__content">
                    <h3 style="font-weight: 600;" class="title tg-svg" data-aos="fade-right" data-aos-delay="400">
                        {!! clean(processText($hero?->content?->title)) !!}
                    </h3>
                    <p data-aos="fade-right" data-aos-delay="600">{!! clean(processText($hero?->content?->sub_title)) !!}</p>
                    <div class="banner__btn-two aos-init aos-animate mt-4" data-aos="fade-right" data-aos-delay="600">
                        @if ($hero?->content?->action_button_text != null)
                        <a href="{{ $hero?->global_content?->action_button_url }}" class="btn arrow-btn">{{ $hero->content?->action_button_text }} <img src="{{ asset('frontend/img/icons/right_arrow.svg') }}" alt="img" class="injectable"></a>
                        @endif
                        @if ($hero?->content?->video_button_text != null)
                        <a href="{{ $hero?->global_content?->video_button_url }}" class="play-btn popup-video"><i class="fas fa-play"></i> {!! clean(processText($hero?->content?->video_button_text)) !!}</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="banner__images">
                    <img src="{{ asset($hero?->global_content?->banner_image) }}" alt="img" class="main-img">
                    <div class="shape big-shape" data-aos="fade-up-right" data-aos-delay="600">
                        <img src="{{  asset($hero?->global_content?->banner_background) }}" alt="shape" class="tg-motion-effects1">
                    </div>
                    <img src="{{ asset('frontend/img/banner/bg_dots.svg') }}" alt="shape"
                        class="shape bg-dots rotateme">
                    <img src="{{ asset('frontend/img/banner/banner_shape02.png') }}" alt="shape"
                        class="shape small-shape tg-motion-effects3">

                    <div class="about__enrolled students aos-init aos-animate" data-aos="fade-right"
                        data-aos-delay="200">
                        <p class="title"><span>{{ $hero?->content?->total_student }}</span>
                            {{ __('Enrolled Students') }}</p>
                        <img src="{{ asset($hero?->global_content?->enroll_students_image) }}" alt="img">
                    </div>
                    <div class="banner__student instructor aos-init aos-animate" data-aos="fade-left"
                        data-aos-delay="200">
                        <div class="icon">
                            <img src="{{ asset('frontend/img/banner/h2_banner_icon.svg') }}" alt="img"
                                class="injectable">
                        </div>
                        <div class="content">
                            <span>{{ __('Total Instructors') }}</span>
                            <h4 class="title">{{ $hero?->content?->total_instructor }}</h4>
                        </div>
                    </div>
                    <div class="banner__author">
                        <img src="{{ asset('frontend/img/banner/banner_shape02.svg') }}" alt="shape"
                            class="arrow-shape tg-motion-effects3">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <img src="{{ asset('frontend/img/banner/banner_shape01.svg') }}" alt="shape" class="line-shape"
        data-aos="fade-right" data-aos-delay="1600">
</section>
