<section class="banner-area fix banner-bg-seven tg-motion-effects"
    data-background="{{ asset($hero?->global_content?->hero_background) }}">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-6">
                <div class="banner__content-seven">
                    <h2 class="title">{!! clean(processText($hero?->content?->title)) !!}</h2>
                    <p>{!! clean(processText($hero?->content?->sub_title)) !!}</p>
                    <div class="slider__search banner__search">
                        <form action="{{ route('courses') }}" class="slider__search-form">
                            <input type="text" name="search" placeholder="{{ __('Search here') }} . . .">
                            <button type="submit">{{ __('Find Courses') }}</button>
                        </form>
                    </div>
                    @if ($sectionSetting?->brands_section)
                        <!-- brand-area -->
                        <div class="banner__brand-wrap">
                            <div class="swiper-container brand-swiper-active-two">
                                <div class="swiper-wrapper">
                                    @foreach ($brands as $brand)
                                        <div class="swiper-slide">
                                            <div class="brand__item-two">
                                                <a href="{{ $brand?->url }}"><img src="{{ asset($brand?->image) }}" alt="{{ $brand?->name }}"></a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <!-- brand-area-end -->
                    @endif
                </div>
            </div>
            <div class="col-lg-6 col-md-10">
                <div class="banner__images-seven">
                    <img src="{{ asset($hero?->global_content?->banner_image) }}" alt="img" class="main-img">
                    <div class="big_shape">
                        <img src="{{ asset($hero?->global_content?->banner_background_two) }}" alt=""
                            class="injectable tg-motion-effects1">
                    </div>
                    <div class="shape">
                        <img src="{{ asset($hero?->global_content?->banner_background) }}" alt=""
                            class="rotateme">
                    </div>
                    <div class="about__enrolled" data-aos="fade-right" data-aos-delay="200">
                        <p class="title"><span>{{ $hero?->content?->total_student }}</span>
                            {{ __('Enrolled Students') }}</p>
                        <img src="{{ asset($hero?->global_content?->enroll_students_image) }}" alt="img">
                    </div>
                    @if ($hero?->content?->total_courses)
                        <div class="banner__all-recipe" data-aos="fade-left" data-aos-delay="200">
                            <h2 class="count">{{ $hero?->content?->total_courses }}</h2>
                            <span>{{ __('All Recipes') }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
