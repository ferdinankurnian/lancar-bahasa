<section class="features__area-five features__bg section-pt-120 section-pb-90"
    data-background="{{ asset('frontend/img/bg/features_bg.jpg') }}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="section__title text-center white-title mb-60">
                    <h2 class="title">{!! clean(processText($ourFeatures?->content?->sec_title)) !!}</h2>
                    <p>{!! clean(processText($ourFeatures?->content?->sec_description)) !!}</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6">
                        <div class="features__item-four">
                            <div class="features__icon-four">
                                <img src="{{ asset($ourFeatures?->global_content?->image_one) }}" alt=""
                                    class="injectable">
                            </div>
                            <div class="features__content-four">
                                <h3 class="title">{{ $ourFeatures?->content?->title_one }}</h3>
                                <p>{{ $ourFeatures?->content?->sub_title_one }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="features__item-four">
                            <div class="features__icon-four">
                                <img src="{{ asset($ourFeatures?->global_content?->image_two) }}" alt=""
                                    class="injectable">
                            </div>
                            <div class="features__content-four">
                                <h3 class="title">{{ $ourFeatures?->content?->title_two }}</h3>
                                <p>{{ $ourFeatures?->content?->sub_title_two }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="features__item-four">
                            <div class="features__icon-four">
                                <img src="{{ asset($ourFeatures?->global_content?->image_three) }}" alt=""
                                    class="injectable">
                            </div>
                            <div class="features__content-four">
                                <h3 class="title">{{ $ourFeatures?->content?->title_three }}</h3>
                                <p>{{ $ourFeatures?->content?->sub_title_three }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="features__shape-wrap">
        <img src="{{ asset('frontend/img/others/h4_features_shape01.svg') }}" alt="shape" data-aos="fade-right"
            data-aos-delay="200">
        <img src="{{ asset('frontend/img/others/h4_features_shape02.svg') }}" alt="shape" data-aos="fade-left"
            data-aos-delay="200">
    </div>
</section>
