<section class="slider__area home4_slider__area">
    <div class="swiper-container slider__active">
        <div class="swiper-wrapper">
            <div class="swiper-slide slider__single">
                <div class="slider__bg" data-background="{{ asset($slider?->global_content?->image_one) }}">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-6 col-lg-7">
                                <div class="slider__content">
                                    <span class="sub-title">{{ $slider?->content?->short_title_one }}</span>
                                    <h2 class="title">{!! clean(processText($slider?->content?->title_one)) !!}</h2>
                                    <p>{!! clean(processText($slider?->content?->sub_title_one)) !!}</p>
                                    <div class="slider__search">
                                        <form action="{{ route('courses') }}" class="slider__search-form">
                                            <input type="text" name="search"
                                                placeholder="{{ __('Search here') }} . . .">
                                            <button type="submit">{{ __('Find Courses') }}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide slider__single">
                <div class="slider__bg" data-background="{{ asset($slider?->global_content?->image_two) }}">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-6 col-lg-7">
                                <div class="slider__content">
                                    <span class="sub-title">{{ $slider?->content?->short_title_two }}</span>
                                    <h2 class="title">{!! clean(processText($slider?->content?->title_two)) !!}</h2>
                                    <p>{!! clean(processText($slider?->content?->sub_title_two)) !!}</p>
                                    <div class="slider__search">
                                        <form action="{{ route('courses') }}" class="slider__search-form">
                                            <input type="text" name="search"
                                                placeholder="{{ __('Search here') }} . . .">
                                            <button type="submit">{{ __('Find Courses') }}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide slider__single">
                <div class="slider__bg" data-background="{{ asset($slider?->global_content?->image_three) }}">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-6 col-lg-7">
                                <div class="slider__content">
                                    <span class="sub-title">{{ $slider?->content?->short_title_three }}</span>
                                    <h2 class="title">{!! clean(processText($slider?->content?->title_three)) !!}</h2>
                                    <p>{!! clean(processText($slider?->content?->sub_title_three)) !!}</p>
                                    <div class="slider__search">
                                        <form action="{{ route('courses') }}" class="slider__search-form">
                                            <input type="text" name="search"
                                                placeholder="{{ __('Search here') }} . . .">
                                            <button type="submit">{{ __('Find Courses') }}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
