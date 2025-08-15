<section class="features__area-two section-pt-120 section-pb-90">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8">
                <div class="section__title text-center mb-40">
                    <span class="sub-title">{{ __('Our Top Features') }}</span>
                    <h2 class="title">{{ __('Achieve Your Goal With Us') }}</h2>
                    <p>{{ __('Join Us on a Journey Where Your Ambitions Meet Our Expertise, Turning Your Dreams into Reality Every Step of the Way') }}
                    </p>
                </div>
            </div>
        </div>
        <div class="features__item-wrap">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6">
                    <div class="features__item-two">
                        <div class="features__content-two">
                            <div class="content-top">
                                <div class="features__icon-two">
                                    <img src="{{ asset($ourFeatures?->global_content?->image_one) }}" alt="img">
                                </div>
                                <h2 class="title">{{ $ourFeatures?->content?->title_one }}</h2>
                            </div>
                            <p>{{ $ourFeatures?->content?->sub_title_one }}</p>
                        </div>
                        <div class="features__item-shape">
                            <img src="{{ asset('frontend/img/others/features_item_shape.svg') }}" alt="img" class="injectable">
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="features__item-two">
                        <div class="features__content-two">
                            <div class="content-top">
                                <div class="features__icon-two">
                                    <img src="{{ asset($ourFeatures?->global_content?->image_two) }}" alt="img">
                                </div>
                                <h2 class="title">{{ $ourFeatures?->content?->title_two }}</h2>
                            </div>
                            <p>{{ $ourFeatures?->content?->sub_title_two }}</p>
                        </div>
                        <div class="features__item-shape">
                            <img src="{{ asset('frontend/img/others/features_item_shape.svg') }}" alt="img" class="injectable">
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="features__item-two">
                        <div class="features__content-two">
                            <div class="content-top">
                                <div class="features__icon-two">
                                    <img src="{{ asset($ourFeatures?->global_content?->image_three) }}" alt="img">
                                </div>
                                <h2 class="title">{{ $ourFeatures?->content?->title_three }}</h2>
                            </div>
                            <p>{{ $ourFeatures?->content?->sub_title_three }}</p>
                        </div>
                        <div class="features__item-shape">
                            <img src="{{ asset('frontend/img/others/features_item_shape.svg') }}" alt="img" class="injectable">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
