<section class="features__area-six section-pt-140 section-pb-110">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8">
                <div class="section__title text-center mb-40">
                    <h2 class="title bold">{{ __('Grow and expand your skills through enjoyable & imaginative') }}</h2>
                    <p>{{ __('Discover a World of Knowledge and Skills at Your Fingertips – Unlock Your Potential and Achieve Your Dreams with Our Comprehensive Learning Resources!') }}
                    </p>
                </div>
            </div>
        </div>
        <div class="features__item-wrap-three">
            <div class="row justify-content-center">
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8">
                    <div class="features__item-five">
                        <div class="features__item-five-shape">
                            <div class="shape-one">
                                <img src="{{ asset('frontend/img/others/h5_features_item_shape.svg') }}"
                                    class="injectable">
                            </div>
                            <div class="shape-two">
                                <img src="{{ asset('frontend/img/others/h5_features_item_shape02.svg') }}"
                                    class="injectable">
                            </div>
                        </div>
                        <div class="features__icon-five">
                            <i class="skillgro-video-tutorial"></i>
                            <img src="{{ asset('frontend/img/icons/h5_features_icon.svg') }}" class="injectable">
                        </div>
                        <div class="features__content-five">
                            <h2 class="title">{{ $ourFeatures?->content?->title_one }}</h2>
                            <p>{{ $ourFeatures?->content?->sub_title_one }}</p>
                            <a href="{{ $ourFeatures?->global_content?->button_url_one ?? route('about-us') }}"
                                class="btn arrow-btn">{{ __('Read More') }} <img
                                    src="{{ asset('frontend/img/icons/right_arrow.svg') }}" class="injectable"></a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8">
                    <div class="features__item-five">
                        <div class="features__item-five-shape">
                            <div class="shape-one">
                                <img src="{{ asset('frontend/img/others/h5_features_item_shape.svg') }}"
                                    class="injectable">
                            </div>
                            <div class="shape-two">
                                <img src="{{ asset('frontend/img/others/h5_features_item_shape02.svg') }}"
                                    class="injectable">
                            </div>
                        </div>
                        <div class="features__icon-five">
                            <i class="skillgro-verified"></i>
                            <img src="{{ asset('frontend/img/icons/h5_features_icon.svg') }}" class="injectable">
                        </div>
                        <div class="features__content-five">
                            <h2 class="title">{{ $ourFeatures?->content?->title_two }}</h2>
                            <p>{{ $ourFeatures?->content?->sub_title_two }}</p>
                            <a href="{{ $ourFeatures?->global_content?->button_url_two ?? route('about-us') }}"
                                class="btn arrow-btn">{{ __('Read More') }} <img
                                    src="{{ asset('frontend/img/icons/right_arrow.svg') }}" class="injectable"></a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8">
                    <div class="features__item-five">
                        <div class="features__item-five-shape">
                            <div class="shape-one">
                                <img src="{{ asset('frontend/img/others/h5_features_item_shape.svg') }}"
                                    class="injectable">
                            </div>
                            <div class="shape-two">
                                <img src="{{ asset('frontend/img/others/h5_features_item_shape02.svg') }}"
                                    class="injectable">
                            </div>
                        </div>
                        <div class="features__icon-five">
                            <i class="skillgro-instructor"></i>
                            <img src="{{ asset('frontend/img/icons/h5_features_icon.svg') }}" class="injectable">
                        </div>
                        <div class="features__content-five">
                            <h2 class="title">{{ $ourFeatures?->content?->title_three }}</h2>
                            <p>{{ $ourFeatures?->content?->sub_title_three }}</p>
                            <a href="{{ $ourFeatures?->global_content?->button_url_three ?? route('about-us') }}"
                                class="btn arrow-btn">{{ __('Read More') }} <img
                                    src="{{ asset('frontend/img/icons/right_arrow.svg') }}" class="injectable"></a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8">
                    <div class="features__item-five">
                        <div class="features__item-five-shape">
                            <div class="shape-one">
                                <img src="{{ asset('frontend/img/others/h5_features_item_shape.svg') }}"
                                    class="injectable">
                            </div>
                            <div class="shape-two">
                                <img src="{{ asset('frontend/img/others/h5_features_item_shape02.svg') }}"
                                    class="injectable">
                            </div>
                        </div>
                        <div class="features__icon-five">
                            <i class="skillgro-book-1"></i>
                            <img src="{{ asset('frontend/img/icons/h5_features_icon.svg') }}" class="injectable">
                        </div>
                        <div class="features__content-five">
                            <h2 class="title">{{ $ourFeatures?->content?->title_four }}</h2>
                            <p>{{ $ourFeatures?->content?->sub_title_four }}</p>
                            <a href="{{ $ourFeatures?->global_content?->button_url_four ?? route('about-us') }}"
                                class="btn arrow-btn">{{ __('Read More') }} <img
                                    src="{{ asset('frontend/img/icons/right_arrow.svg') }}" class="injectable"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="features__shape-wrap-two">
        <img src="{{ asset('frontend/img/others/h5_features_shape01.svg') }}" alt="shape" class="rotateme">
        <img src="{{ asset('frontend/img/others/h5_features_shape02.svg') }}" alt="shape"
            data-aos="fade-down-left" data-aos-delay="400">
    </div>
</section>
