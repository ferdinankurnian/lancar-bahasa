<section class="blog__post-area-four section-pt-140 section-pb-110">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6">
                <div class="section__title text-center mb-40">
                    <span class="sub-title">{{ __('News & Blogs') }}</span>
                    <h2 class="title">{{ __('Our Latest News Feed') }}</h2>
                    <p>{{ __('Dont Miss Stay Updated with the Latest Articles and Insights') }}</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                @php
                    $firstBlog = $featuredBlogs->first();
                @endphp
                <div class="blog__post-item-two yoga_featured_blog">
                    <div class="blog__post-thumb-two">
                        <a href="{{ route('blog.show', $firstBlog?->slug) }}">
                            <img src="{{ asset($firstBlog?->image) }}" alt="img">
                        </a>
                    </div>
                    <div class="blog__post-content-two">
                        <a href="{{ route('blogs', ['category' => $firstBlog?->category?->slug]) }}"
                            class="post-tag-two">
                            {{ $firstBlog?->category?->title }}
                        </a>
                        <div class="blog__post-meta blog__post-meta-two">
                            <ul class="list-wrap">
                                <li><i class="flaticon-calendar"></i>{{ formatDate($firstBlog?->created_at) }}</li>
                                <li><i class="flaticon-user-1"></i>{{ __('by') }}
                                    <a href="{{ route('blog.show', $firstBlog?->slug) }}">
                                        {{ truncate($firstBlog?->author?->name, 14) }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <h2 class="title">
                            <a href="{{ route('blog.show', $firstBlog?->slug) }}">
                                {{ $firstBlog?->title }}
                            </a>
                        </h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                @foreach ($featuredBlogs->slice(1, 2) as $blog)
                    <div class="blog__post-item-three shine__animate-item">
                        <div class="blog__post-thumb-three">
                            <a href="{{ route('blog.show', $blog?->slug) }}" class="shine__animate-link"><img
                                    src="{{ asset($blog?->image) }}" alt="img"></a>
                        </div>
                        <div class="blog__post-content-three">
                            <a href="{{ route('blogs', ['category' => $blog?->category?->slug]) }}"
                                class="post-tag-two">{{ $blog?->category?->title }}</a>
                            <div class="blog__post-meta">
                                <ul class="list-wrap">
                                    <li><i class="flaticon-calendar"></i>{{ formatDate($blog->created_at) }}</li>
                                    <li><i class="flaticon-user-1"></i>{{ __('by') }} <a
                                            href="{{ route('blog.show', $blog?->slug) }}">{{ truncate($blog?->author?->name, 14) }}</a>
                                    </li>
                                </ul>
                            </div>
                            <h2 class="title"><a
                                    href="{{ route('blog.show', $blog?->slug) }}">{{ $blog?->category?->title }}</a>
                            </h2>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="blog__shape-wrap">
        <img src="{{ asset('frontend/img/blog/h4_blog_shape.svg') }}" alt="shape" class="rotateme">
        <img src="{{ asset('frontend/img/blog/h4_blog_shape.svg') }}" alt="shape" class="rotateme">
    </div>
</section>
