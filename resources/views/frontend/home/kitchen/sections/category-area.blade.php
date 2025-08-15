<section class="categories-area-four fix section-pt-140 section-pb-110">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8">
                <div class="section__title text-center mb-50">
                    <span class="sub-title">{{ __('Top Search Categories') }}</span>
                    <h2 class="title bold">{{ __('Our Food categories') }}</h2>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($trendingCategories as $category)
                <div class="col-lg-3 col-sm-6">
                    <div class="categories__item-four shine__animate-item">
                        <a href="{{ route('courses', ['main_category' => $category->slug]) }}" class="shine__animate-link">
                            <img src="{{ asset($category->icon) }}" alt="img">
                            <span class="name">{{ $category?->name }} <strong>({{ $category->subCategories->sum('courses_count') }})</strong></span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="categories__shape-wrap-two">
        <img src="{{ asset('frontend/img/others/cat_shape01.svg') }}" alt="shape" data-aos="fade-down-right"
            data-aos-delay="400">
        <img src="{{ asset('frontend/img/others/cat_shape02.svg') }}" alt="shape" data-aos="fade-up-left"
            data-aos-delay="400">
    </div>
</section>
