<section class="testimonial__area-six section-py-140 testimonial__bg-three"
    data-background="{{ asset('frontend/img/bg/h8_testimonial_bg.jpg') }}">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-5 col-lg-6 col-md-8">
                <div class="section__title mb-50">
                    <span class="sub-title">{{ __('Our Testimonials') }}</span>
                    <h2 class="title">{{ __('What Students Think and Say About Us') }}</h2>
                </div>
            </div>
            <div class="col-xl-7 col-lg-6 col-md-4">
                <div class="testimonial__nav-two">
                    <button class="testimonial-button-prev"><i class="flaticon-arrow-right"></i></button>
                    <button class="testimonial-button-next"><i class="flaticon-arrow-right"></i></button>
                </div>
            </div>
        </div>
        <div class="swiper-container testimonial-active-five">
            <div class="swiper-wrapper">
                @foreach ($testimonials as $testimonial)
                    <div class="swiper-slide">
                        <div class="testimonial__item-two testimonial__item-five">
                            <div class="testimonial__content-two">
                                <h2 class="title">{{ __('Great Quality') }}</h2>
                                <div class="rating">
                                    @for ($i = 0; $i < $testimonial->rating; $i++)
                                        <i class="fas fa-star"></i>
                                    @endfor
                                </div>
                                <p>“ {{ $testimonial?->comment }} ”</p>
                            </div>
                            <div class="testimonial__author testimonial__author-two">
                                <div class="testimonial__author-thumb testimonial__author-thumb-two">
                                    <img src="{{ asset($testimonial?->image) }}" alt="img">
                                </div>
                                <div class="testimonial__author-content testimonial__author-content-two">
                                    <h2 class="title">{{ $testimonial?->name }}</h2>
                                    <span>{{ $testimonial?->designation }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="testimonial__shape-wrap-two">
        <img src="{{ asset('frontend/img/others/h8_testimonial_shape01.svg') }}" alt="shape"
            data-aos="fade-down-left" data-aos-delay="400">
        <img src="{{ asset('frontend/img/others/h8_testimonial_shape02.svg') }}" alt="shape" data-aos="fade-up-right"
            data-aos-delay="400">
    </div>
</section>
