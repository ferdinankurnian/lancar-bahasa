<section class="testimonial__area-five section-pb-130">
    <div class="swiper-container testimonial-active-four">
        <div class="swiper-wrapper">
            @foreach ($testimonials as $testimonial)
                <div class="swiper-slide">
                    <div class="container">
                        <div class="row align-items-center justify-content-center">
                            <div class="col-xl-5 col-lg-6 col-md-8">
                                <div class="testimonial__img-three tg-svg">
                                    <div class="testimonial__mask-img">
                                        <img src="{{ asset($testimonial?->image) }}" alt="img">
                                    </div>
                                    <div class="banner__review" data-aos="fade-left" data-aos-delay="1000">
                                        <div class="icon">
                                            <img src="{{ asset('frontend/img/icons/star.svg') }}" alt=""
                                                class="injectable">
                                        </div>
                                        <h6 class="title">{{ $testimonial->rating }}/5
                                            <span>{{ __('Real Reviews') }}</span>
                                        </h6>
                                    </div>
                                    <div class="testimonial__img-icon">
                                        <img src="{{ asset('frontend/img/icons/quote02.svg') }}" alt=""
                                            class="injectable">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-7 col-lg-6">
                                <div class="testimonial__content-three">
                                    <div class="section__title mb-25">
                                        <span class="sub-title">{{ __('Testimonials') }}</span>
                                        <h2 class="title bold">{{ __('What Students Think and Say About Us') }}</h2>
                                    </div>
                                    <div class="testimonial__item-four">
                                        <div class="rating">
                                            @for ($i = 0; $i < $testimonial->rating; $i++)
                                                <i class="fas fa-star"></i>
                                            @endfor
                                        </div>
                                        <p>“ {{ $testimonial?->comment }} ”</p>
                                        <div class="testimonial__bottom-two">
                                            <h4 class="title">{{ $testimonial?->name }}</h4>
                                            <span>{{ $testimonial?->designation }}</span>
                                        </div>
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
</section>
