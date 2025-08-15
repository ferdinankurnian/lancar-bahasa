<section class="categories-area-two section-pt-140 section-pb-110">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-8">
                <div class="section__title mb-50 mb-xs-20">
                    <span class="sub-title">{{ __('Trending Categories') }}</span>
                    <h2 class="title bold">{{ __('Top Category We Have') }}</h2>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($trendingCategories as $category)
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="categories__item-two">
                        <a href="{{ route('courses', ['main_category' => $category->slug]) }}">
                            <div class="content">
                                <img src="{{ asset($category?->icon) }}" alt="img">
                                <span
                                    class="name"><strong>{{ $category?->translation?->name }}</strong>{{ $category->subCategories->sum('courses_count') }}
                                    {{ __('Courses') }}</span>
                            </div>
                            <div class="icon">
                                <i class="skillgro-next-2"></i>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>