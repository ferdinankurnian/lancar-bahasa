<section class="features__area-four section-pb-90">
    <div class="container">
        <div class="features__item-wrap-two">
            <div class="row justify-content-center">
                <div class="col-lg-3 col-sm-6">
                    <div class="features__item-three orange">
                        <div class="features__icon-three">
                            <img src="{{ asset($ourFeatures?->global_content?->image_one) }}" class="injectable" alt="">
                        </div>
                        <div class="features__content-three">
                            <h2 class="title">{{ $ourFeatures?->content?->title_one }}</h2>
                            <p>{{ $ourFeatures?->content?->sub_title_one }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="features__item-three blue">
                        <div class="features__icon-three">
                            <img src="{{ asset($ourFeatures?->global_content?->image_two) }}" class="injectable" alt="">
                        </div>
                        <div class="features__content-three">
                            <h2 class="title">{{ $ourFeatures?->content?->title_two }}</h2>
                            <p>{{ $ourFeatures?->content?->sub_title_two }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="features__item-three red">
                        <div class="features__icon-three">
                            <img src="{{ asset($ourFeatures?->global_content?->image_three) }}" class="injectable" alt="">
                        </div>
                        <div class="features__content-three">
                            <h2 class="title">{{ $ourFeatures?->content?->title_three }}</h2>
                            <p>{{ $ourFeatures?->content?->sub_title_three }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="features__item-three green">
                        <div class="features__icon-three">
                            <img src="{{ asset($ourFeatures?->global_content?->image_four) }}" class="injectable" alt="">
                        </div>
                        <div class="features__content-three">
                            <h2 class="title">{{ $ourFeatures?->content?->title_four }}</h2>
                            <p>{{ $ourFeatures?->content?->sub_title_four }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
