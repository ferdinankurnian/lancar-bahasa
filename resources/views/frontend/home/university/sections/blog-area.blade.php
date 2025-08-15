<section class="blog__post-area mt-0 blog__post-area_3">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section__title text-center mb-40">
                    <span class="sub-title">{{ __('News & Blogs') }}</span>
                    <h2 class="title">{{ __('Our Latest News Feed') }}</h2>
                </div>
            </div>
        </div>
        <div class="row gutter-20">
            @foreach ($featuredBlogs as $blog)
                <div class="col-xxl-3 col-md-6 col-lg-4">
                    <div class="blog__post-item shine__animate-item">
                        <div class="blog__post-thumb">
                            <a href="{{ route('blog.show', $blog->slug) }}" class="shine__animate-link blog"><img src="{{ asset($blog->image) }}"
                                    alt="img"></a>
                            <a href="{{ route('blogs', ['category' => $blog->category->slug]) }}"
                                class="post-tag">{{ $blog->category?->title }}</a>
                        </div>
                        <div class="blog__post-content">
                            <div class="blog__post-meta">
                                <ul class="list-wrap">
                                    <li><i class="flaticon-calendar"></i>{{ formatDate($blog->created_at) }}</li>
                                    <li><i class="flaticon-user-1"></i>{{ __('by') }} <a
                                            href="javascript:;">{{ truncate($blog->author->name, 14) }}</a>
                                    </li>
                                </ul>
                            </div>
                            <h4 class="title"><a
                                    href="{{ route('blog.show', $blog->slug) }}">{{ truncate($blog?->title, 50) }}</a>
                            </h4>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
