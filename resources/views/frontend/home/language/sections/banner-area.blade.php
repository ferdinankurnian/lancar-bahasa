<section class="banner-area banner-bg-six tg-motion-effects" data-background="{{ asset($hero?->global_content?->hero_background) }}">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-7 col-md-9 col-sm-10 order-0 order-lg-2">
                <div class="banner__images-six">
                    <div class="main-img tg-svg">
                        <img src="{{ asset($hero?->global_content?->banner_image) }}" alt="img">
                        <span class="svg-icon" id="banner-svg" data-svg-icon="{{ asset('frontend/img/banner/h6_banner_img_shape03.svg') }}"></span>
                    </div>
                    <div class="about__enrolled about__enrolled-two" data-aos="fade-right" data-aos-delay="1000">
                        <img src="{{ asset($hero?->global_content?->enroll_students_image) }}" alt="img">
                        <p class="title">{{ $hero?->content?->total_student }} {{ __('Enrolled Students') }}</p>
                    </div>
                    <div class="banner__review" data-aos="fade-left" data-aos-delay="1000">
                        <div class="icon">
                            <img src="{{ asset('frontend/img/icons/star.svg') }}" alt="" class="injectable">
                        </div>
                        <h6 class="title">{{ $hero?->content?->average_reviews }}/5 <span> {{__('Real Reviews')}}</span></h6>
                    </div>
                    <div class="banner__courses" data-aos="fade-up" data-aos-delay="1000">
                        <div class="icon">
                            <i class="flaticon-book"></i>
                        </div>
                        <h6 class="title">{{ $hero?->content?->total_courses }} <span>{{__('Courses')}}</span></h6>
                    </div>
                    <div class="shape-wrap">
                        <img src="{{ asset('frontend/img/banner/h6_banner_img_shape01.svg') }}" alt="shape">
                        <img src="{{ asset('frontend/img/banner/h6_banner_img_shape02.svg') }}" alt="shape" class="alltuchtopdown">
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="banner__content-six">
                    <h2 class="title" data-aos="fade-up" data-aos-delay="200">{!! clean(processText($hero?->content?->title)) !!}</h2>

                    <div class="sub-title wsus_content-box" data-aos="fade-up" data-aos-delay="400">
                        {!! clean(processText($hero?->content?->sub_title)) !!}
                    </div>
                    <div class="banner__btn-wrap-three" data-aos="fade-up" data-aos-delay="800">
                        @if ($hero?->content?->action_button_text != null)
                        <a href="{{ $hero?->global_content?->action_button_url }}" class="btn arrow-btn btn-four">{{ $hero->content?->action_button_text }} <img src="{{ asset('frontend/img/icons/right_arrow.svg') }}" alt="img" class="injectable"></a>
                        @endif
                        @if ($hero?->content?->video_button_text != null)
                        <a href="{{ $hero?->global_content?->video_button_url }}" class="play-btn popup-video"><i class="fas fa-play"></i> {!! clean(processText($hero?->content?->video_button_text)) !!}</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
