<section class="testimonial__area-three youga_testimonial section-py-140 testimonial__bg-two"
    data-background="{{ asset('frontend/img/bg/h4_testimonial_bg.jpg') }}">
    <div class="container">
        <div class="swiper-container testimonial-active-three">
            <div class="swiper-wrapper">
                @foreach ($testimonials as $testimonial)
                    <div class="swiper-slide">
                        <div class="row align-items-center justify-content-center">
                            <div class="col-lg-6 col-md-10">
                                <div class="testimonial__img">
                                    <img src="{{ asset($testimonial?->image) }}"
                                        alt="img">
                                    <div class="shape">
                                        <img src="{{ asset('frontend/img/others/testimonial_img_shape.svg') }}"
                                            alt="shape" class="rotateme">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="testimonial__item-three">
                                    <div class="icon">
                                        <img src="{{ asset('frontend/img/icons/testi_icon.svg') }}" alt=""
                                            class="injectable">
                                    </div>
                                    <div class="rating">
                                        @for ($i = 0; $i < $testimonial->rating; $i++)
                                            <i class="fas fa-star"></i>
                                        @endfor
                                    </div>
                                    <p>“ {{ $testimonial?->comment }} “
                                    </p>
                                    <div class="testimonial__bottom">
                                        <h4 class="title">{{ $testimonial?->name }}</h4>
                                        <span>{{ $testimonial?->designation }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="testimonial-pagination"></div>
        </div>
    </div>
    <div class="testimonial__shape">
        <img src="{{ asset('frontend/img/others/h4_testimonial_shape.svg') }}" alt="shape" class="rotateme">
    </div>
</section>
