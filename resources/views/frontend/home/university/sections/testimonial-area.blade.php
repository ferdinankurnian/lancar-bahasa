<section class="testimonial__area section-py-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5">
                <div class="section__title text-center mb-50">
                    <span class="sub-title">{{ __('Our Testimonials') }}</span>
                    <h2 class="title">{{ __('What Students Think and Say About Us') }}</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="testimonial__item-wrap">
                    <div class="swiper-container testimonial-swiper-active">
                        <div class="swiper-wrapper">
                            @foreach ($testimonials as $testimonial)
                                <div class="swiper-slide">
                                    <div class="testimonial__item">
                                        <div class="testimonial__item-top">
                                            <div class="testimonial__author">
                                                <div class="testimonial__author-thumb">
                                                    <img src="{{ asset($testimonial->image) }}" alt="img">
                                                </div>
                                                <div class="testimonial__author-content">
                                                    <div class="rating">
                                                        @for ($i = 0; $i < $testimonial->rating; $i++)
                                                            <i class="fas fa-star"></i>
                                                        @endfor
                                                    </div>
                                                    <h2 class="title">{{ $testimonial?->name }}</h2>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="testimonial__content">
                                            <p>“ {{ $testimonial?->comment }} ”</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="testimonial__nav">
                        <button class="testimonial-button-prev"><i class="flaticon-arrow-right"></i></button>
                        <button class="testimonial-button-next"><i class="flaticon-arrow-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>