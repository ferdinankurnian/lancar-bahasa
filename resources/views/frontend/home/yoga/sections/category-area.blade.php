<section class="categories-area section-py-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-7">
                <div class="section__title text-center mb-40">
                    <span class="sub-title">{{ __('Trending Categories') }}</span>
                    <h2 class="title">{{ __('Top Category We Have') }}</h2>
                    <p class="desc">{{ __('Check out the most demanding categories right now') }}</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="categories__wrap">
                    <div class="swiper categories-active">
                        <div class="swiper-wrapper">
                            @foreach ($trendingCategories as $category)
                                <div class="swiper-slide">
                                    <div class="categories__item">
                                        <a href="{{ route('courses', ['main_category' => $category->slug]) }}">
                                            <div class="icon">
                                                <img src="{{ asset($category?->icon) }}" alt="">
                                            </div>
                                            <span class="name">{{ $category?->translation?->name }}</span>
                                            <span
                                                class="courses">({{ $category->subCategories->sum('courses_count') }})</span>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="categories__nav">
                        <button class="categories-button-prev">
                            <svg width="16" height="14" viewBox="0 0 16 14" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M15 7L1 7M1 7L7 1M1 7L7 13" stroke="#161439" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                        <button class="categories-button-next">
                            <svg width="16" height="14" viewBox="0 0 16 14" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 7L15 7M15 7L9 1M15 7L9 13" stroke="#161439" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
