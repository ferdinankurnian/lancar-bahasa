<section class="testimonial__area-four tg-motion-effects">
    <div class="testimonial__bg-shape-one">
        <img src="{{ asset('frontend/img/others/h5_testimonial_bg_shape01.svg') }}" class="injectable">
    </div>
    <div class="testimonial__bg-shape-two">
        <img src="{{ asset('frontend/img/others/h5_testimonial_bg_shape02.svg') }}" class="injectable">
    </div>


    <div class="swiper-container testimonial-active-four">
        <div class="swiper-wrapper">
            @foreach ($testimonials as $testimonial)
                <div class="swiper-slide">
                    <div class="container">
                        <div class="row align-items-center justify-content-center">
                            <div class="col-lg-7 order-0 order-lg-2">
                                <div class="testimonial__item-four">
                                    <div class="rating">
                                        @for ($i = 0; $i < $testimonial->rating; $i++)
                                            <i class="fas fa-star"></i>
                                        @endfor
                                    </div>
                                    <p>“ {{ $testimonial?->comment }} ”
                                    </p>
                                    <div class="testimonial__bottom-two">
                                        <h4 class="title">{{ $testimonial?->name }}</h4>
                                        <span>{{ $testimonial?->designation }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-7">
                                <div class="testimonial__img-two">
                                    <img src="{{ asset($testimonial?->image) }}" alt="img">
                                    <div class="shape">
                                        <img src="{{ asset('frontend/img/others/h5_testimonial_shape01.svg') }}"
                                            alt="shape" class="alltuchtopdown">
                                        <img src="{{ asset('frontend/img/others/h5_testimonial_shape02.svg') }}"
                                            alt="shape" class="tg-motion-effects4">
                                        <img src="{{ asset('frontend/img/others/h5_testimonial_shape03.svg') }}"
                                            alt="shape" class="tg-motion-effects3">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
        <div class="testimonial-pagination testimonial-pagination-two"></div>
    </div>

    <div class="testimonial__shape-wrap">
        <img src="{{ asset('frontend/img/others/h5_testimonial_shape04.svg') }}" alt="shape" data-aos="fade-up"
            data-aos-delay="400">
        <img src="{{ asset('frontend/img/others/h5_testimonial_shape05.svg') }}" alt="shape"
            data-aos="fade-down-left" data-aos-delay="400">
    </div>
</section>
