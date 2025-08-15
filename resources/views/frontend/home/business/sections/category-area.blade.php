<section class="categories-area-three fix section-pt-140 section-pb-110 categories__bg"
    data-background="{{ asset('frontend/img/bg/categories_bg.jpg') }}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8">
                <div class="section__title text-center mb-50">
                    <span class="sub-title">{{ __('Our Top Categories') }}</span>
                    <h2 class="title bold">{{ __('Your Creative and Passionate Business Coach') }}</h2>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($trendingCategories as $category)
                <div class="col-lg-3 col-sm-6">
                    <div class="categories__item-three">
                        <a href="{{ route('courses', ['main_category' => $category->slug]) }}">
                            <div class="icon">
                                <img src="{{ asset($category->icon) }}" alt="">
                            </div>
                            <span class="name">{{ $category?->name }}</span>
                            <span class="courses">{{ $category->subCategories->sum('courses_count') }}
                                {{ __('Courses') }}</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="categories__shape-wrap">
        <img src="{{ asset('frontend/img/others/h7_categories_shape01.svg') }}" alt="shape" class="rotateme">
        <img src="{{ asset('frontend/img/others/h7_categories_shape02.svg') }}" alt="shape" data-aos="fade-down-left"
            data-aos-delay="400">
        <img src="{{ asset('frontend/img/others/h7_categories_shape03.svg') }}" alt="shape" class="alltuchtopdown">
        <img src="{{ asset('frontend/img/others/h7_categories_shape04.svg') }}" alt="shape" data-aos="fade-up-right"
            data-aos-delay="400">
    </div>
</section>
