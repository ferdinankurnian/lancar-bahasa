<section class="about-area-five section-pb-140">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="about__images-five">
                    <div class="about__mask-img-one">
                        <img src="{{ asset($aboutSection?->global_content?->image) }}"
                            alt="{{ $aboutSection?->content?->short_title }}">
                    </div>
                    <div class="about__mask-img-two" data-aos="fade-right" data-aos-delay="200">
                        <img src="{{ asset($aboutSection?->global_content?->image_two) }}"
                            alt="{{ $aboutSection?->content?->short_title }}">
                    </div>
                    <div class="shape">
                        <img src="{{ asset('frontend/img/others/h5_about_img_shape01.svg') }}" alt="shape"
                            data-aos="fade-down-left" data-aos-delay="400">
                        <img src="{{ asset('frontend/img/others/h5_about_img_shape02.svg') }}" alt="shape"
                            data-aos="fade-up-right" data-aos-delay="400">
                        <img src="{{ asset('frontend/img/others/h5_about_img_shape03.svg') }}" alt="shape"
                            class="rotateme">
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about__content-five wsus_content-box">
                    <div class="section__title mb-15">
                        <span class="sub-title">{{ $aboutSection?->content?->short_title }}</span>
                        <h2 class="title bold">{!! clean(processText($aboutSection?->content?->title)) !!}</h2>
                    </div>
                    {!! clean(processText($aboutSection?->content?->description)) !!}
                    <div class="about__content-bottom">
                        @if ($aboutSection?->content?->button_text)
                            <a href="{{ $aboutSection?->global_content?->button_url ?? route('about-us') }}"
                                class="btn arrow-btn btn-four">{{ $aboutSection?->content?->button_text }} <img
                                    src="{{ asset('frontend/img/icons/right_arrow.svg') }}" class="injectable"></a>
                        @endif
                        @if ($aboutSection?->global_content?->phone_number)
                            <div class="about__contact">
                                <div class="icon">
                                    <i class="fas fa-phone-alt"></i>
                                    <svg width="61" height="57" viewBox="0 0 61 57" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M33.8271 1.03084C45.4231 1.45238 55.2747 9.02544 58.7825 19.8885C62.2129 30.5119 58.2066 41.852 49.1968 48.6277C39.3708 56.0171 26.0908 58.9731 15.8124 52.2032C4.34981 44.6532 -2.0548 30.6516 2.45508 17.8409C6.75857 5.61644 20.666 0.552417 33.8271 1.03084Z"
                                            stroke="currentcolor" stroke-width="2" />
                                    </svg>
                                </div>

                                <div class="content">
                                    <a
                                        href="tel:{{ $aboutSection?->global_content?->phone_number }}">{{ $aboutSection?->global_content?->phone_number }}</a>
                                    <span>{{ __('Call to Questions') }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="shape">
                        <img src="{{ asset('frontend/img/others/h5_about_shape02.png') }}" alt="shape"
                            class="alltuchtopdown">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="about__shape">
        <img src="{{ asset('frontend/img/others/h5_about_shape01.png') }}" alt="shape" data-aos="fade-right"
            data-aos-delay="800">
    </div>
</section>
