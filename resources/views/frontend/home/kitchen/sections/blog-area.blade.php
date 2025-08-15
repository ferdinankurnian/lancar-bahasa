<section class="blog__post-area-eight section-pt-140 section-pb-110">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6">
                <div class="section__title text-center mb-50">
                    <span class="sub-title">{{ __('News & Blogs') }}</span>
                    <h2 class="title bold">{{ __('Our Latest News Feed') }}</h2>
                    <p>{{ __('Dont Miss Stay Updated with the Latest Articles and Insights') }}</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            @foreach ($featuredBlogs->take(3) as $blog)
            <div class="col-lg-4 col-md-6">
                <div class="blog__post-item-six shine__animate-item">
                    <div class="blog__post-thumb-six">
                        <a href="{{ route('blog.show', $blog->slug) }}" class="shine__animate-link"><img
                                src="{{ asset($blog->image) }}" alt="img"></a>
                        <a href="{{ route('blogs', ['category' => $blog->category->slug]) }}" class="post-tag-four">{{ $blog->category?->title }}</a>
                    </div>
                    <div class="blog__post-content-six">
                        <div class="blog__post-meta">
                            <ul class="list-wrap">
                                <li><i class="flaticon-calendar"></i>{{ formatDate($blog->created_at) }}</li>
                                <li><i class="flaticon-user-1"></i>{{ __('by') }} <a href="{{ route('blog.show', $blog->slug) }}">{{ truncate($blog->author->name, 14) }}</a></li>
                            </ul>
                        </div>
                        <h2 class="title"><a href="{{ route('blog.show', $blog->slug) }}">{{ truncate($blog?->title, 50) }}</a></h2>
                        <a href="{{ route('blog.show', $blog->slug) }}" class="btn arrow-btn">{{__('Read More')}} <img
                                src="{{ asset('frontend/img/icons/right_arrow.svg') }}" alt="" class="injectable"></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="blog__shape-wrap-three">
        <img src="{{ asset('frontend/img/others/h8_blog_shape01.svg') }}" alt="shape" data-aos="fade-down-left"
            data-aos-delay="400">
        <img src="{{ asset('frontend/img/others/h8_blog_shape02.svg') }}" alt="shape" data-aos="fade-up-right"
            data-aos-delay="400">
    </div>
</section>