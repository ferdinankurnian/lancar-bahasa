<section class="banner-area banner-bg-four tg-motion-effects"
    data-background="{{ asset($hero?->global_content?->hero_background) }}">
    <div class="container">
        <div class="row justify-content-center align-items-start">
            <div class="col-xl-5 col-lg-6">
                <div class="banner__content-four">
                    <h6 class="sub-title" data-aos="fade-down" data-aos-delay="600">{{__('Hi, Im')}}</h6>
                    <h2 class="title" data-aos="fade-down" data-aos-delay="400">{!! clean(processText($hero?->content?->title)) !!}</h2>
                    <span class="sub-title-two" data-aos="fade-down"
                        data-aos-delay="200">{{ $hero?->content?->short_title }}</span>
                    <p data-aos="fade-up" data-aos-delay="400">{!! clean(processText($hero?->content?->sub_title)) !!}</p>
                    <div class="banner__btn-wrap-two" data-aos="fade-up" data-aos-delay="600">
                        @if ($hero?->content?->action_button_text != null)
                            <a href="{{ $hero?->global_content?->action_button_url }}"
                                class="btn arrow-btn">{{ $hero->content?->action_button_text }} <img
                                    src="{{ asset('frontend/img/icons/right_arrow.svg') }}" alt="img"
                                    class="injectable"></a>
                        @endif
                        @if ($hero?->global_content?->booking_number)
                            <div class="banner__contact">
                                <div class="icon">
                                    <img src="{{ asset('frontend/img/icons/phone.svg') }}" alt=""
                                        class="injectable">
                                </div>
                                <div class="content">
                                    <span>{{ __('Booking Open') }}</span>
                                    <a href="tel:0123456789">{{ $hero?->global_content?->booking_number }}</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-xl-7 col-lg-6 col-md-9 col-sm-10">
                <div class="banner__images-four">
                    <img src="{{ asset($hero?->global_content?->banner_image) }}" alt="img" class="main-img">
                    <div class="shape big-shape" data-aos="fade-up" data-aos-delay="900">
                        <img src="{{ asset($hero?->global_content?->banner_background_two) }}" alt="shape">
                    </div>
                    <div class="shape big-shape-two" data-aos="zoom-in" data-aos-delay="700">
                        <img src="{{ asset($hero?->global_content?->banner_background) }}" alt="shape"
                            class="tg-motion-effects5">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="banner__shape-wrap">
        <img src="{{ asset('frontend/img/others/h4_hero_shape01.svg') }}" alt="shape" data-aos="fade-down-right"
            data-aos-delay="1000">
        <img src="{{ asset('frontend/img/others/h4_hero_shape02.svg') }}" alt="shape" data-aos="fade-up-left"
            data-aos-delay="1000">
        <img src="{{ asset('frontend/img/others/h4_hero_shape03.svg') }}" alt="shape" class="tg-motion-effects5">
    </div>
</section>
