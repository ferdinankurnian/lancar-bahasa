<section class="banner-area banner-bg-three tg-motion-effects"
    data-background="{{ asset($hero?->global_content?->hero_background) }}">
    <div class="container">
        <div class="row justify-content-between align-items-start">
            <div class="col-xl-5 col-lg-6">
                <div class="banner__content-three">
                    <span class="sub-title" data-aos="fade-right"
                        data-aos-delay="200">{{$hero?->content?->short_title}}</span>
                    <h2 class="title" data-aos="fade-right" data-aos-delay="400">{!! clean(processText($hero?->content?->title)) !!}</h2>
                    <p data-aos="fade-right" data-aos-delay="600">{!! clean(processText($hero?->content?->sub_title)) !!}</p>
                    @if ($hero?->content?->action_button_text != null)
                        <div class="banner__btn-wrap" data-aos="fade-right" data-aos-delay="800">
                            <a href="{{ $hero?->global_content?->action_button_url }}"
                                class="btn arrow-btn">{{ $hero?->content?->action_button_text }} <img
                                    src="{{ asset('frontend/img/icons/right_arrow.svg') }}" alt="img"
                                    class="injectable"></a>
                    @endif
                </div>
                <div class="shape">
                    <img src="{{ asset('frontend/img/banner/h3_hero_shape01.svg') }}" alt="shape"
                        data-aos="fade-right" data-aos-delay="1000">
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="banner__images-three">
                <img src="{{ asset($hero?->global_content?->banner_image) }}" alt="img" class="main-img">
                <div class="shape big-shape" data-aos="fade-up" data-aos-delay="800">
                    <img src="{{ asset($hero?->global_content?->banner_background) }}" alt="shape" class="tg-motion-effects1">
                </div>
                <div class="shape__wrap">
                    <img src="{{ asset('frontend/img/banner/h3_hero_shape02.svg') }}" alt="shape"
                        data-aos="fade-down-right" data-aos-delay="400">
                    <img src="{{ asset('frontend/img/banner/h3_hero_shape03.svg') }}" alt="shape"
                        data-aos="fade-down-left" data-aos-delay="400">
                </div>
                <div class="about__enrolled" data-aos="fade-right" data-aos-delay="900">
                    <p class="title"><span>{{ $hero?->content?->total_student }}</span>
                        {{ __('Enrolled Students') }}</p>
                    <img src="{{ asset($hero?->global_content?->enroll_students_image) }}" alt="img">
                </div>
            </div>
        </div>
    </div>
</section>
