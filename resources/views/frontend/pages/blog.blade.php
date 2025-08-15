@extends('frontend.layouts.master')
@section('meta_title', $seo_setting['blog_page']['seo_title'])
@section('meta_description', $seo_setting['blog_page']['seo_description'])
@section('contents')
    <!-- breadcrumb-area -->
    <x-frontend.breadcrumb :title="__('Blog')" :links="[
        ['url' => route('home'), 'text' => __('Home')],
        ['url' => route('blogs'), 'text' => __('Blog')],
    ]" />
    <!-- breadcrumb-area-end -->

    <!-- blog-area -->
    <section class="blog-area section-py-120">
        <div class="container">
            <div class="row">
                <div class="col-xl-9 col-lg-8">
                    <div class="row gutter-20">
                        @forelse($blogs as $blog)
                        <div class="col-xl-4 col-md-6">
                            <div class="blog__post-item shine__animate-item">
                                <div class="blog__post-thumb">
                                    <a href="{{ route('blog.show', $blog->slug) }}" class="shine__animate-link blog"><img
                                            src="{{ asset($blog->image) }}" alt="img"></a>
                                    <a href="{{ route('blogs', ['category' => $blog->category->slug]) }}" class="post-tag">{{ $blog->category->translation->title }}</a>
                                </div>
                                <div class="blog__post-content">
                                    <div class="blog__post-meta">
                                        <ul class="list-wrap">
                                            <li><i class="flaticon-calendar"></i>{{ formatDate($blog->created_at) }}</li>
                                            <li><i class="flaticon-user-1"></i>{{ __('by') }} <a href="javascript:;">{{ truncate($blog->author->name, 14) }}</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <h4 class="title"><a href="{{ route('blog.show', $blog->slug) }}">{{ truncate($blog->translation->title, 50) }}</a></h4>
                                </div>
                            </div>
                        </div>
                        @empty
                        <p class="text-center">{{ __('No Data Found') }}</p>
                        @endforelse
                    </div>
                    <nav class="pagination__wrap mt-25">
                        {{ $blogs->links() }}
                    </nav>
                </div>
                <div class="col-xl-3 col-lg-4">
                    <aside class="blog-sidebar">
                        <div class="blog-widget widget_search">
                            <div class="sidebar-search-form">
                                <form action="{{ route('blogs') }}" method="get">
                                    <input type="text" placeholder="{{ __('Search here') }}" name="search" value="{{ request('search') }}">
                                    <button type="submit"><i class="flaticon-search"></i></button>
                                </form>
                            </div>
                        </div>
                        <div class="blog-widget">
                            <h4 class="widget-title">{{ __('Categories') }}</h4>
                            <div class="shop-cat-list">
                                <ul class="list-wrap">
                                    @forelse($categories->sortBy('translation.title') as $category)
                                    <li>
                                        <a href="{{ route('blogs', ['category' => $category->slug]) }}"><i class="flaticon-angle-right"></i>{{ $category->translation->title }}</a>
                                    </li>
                                    @empty
                                    <li>
                                        {{ __('No Category Found') }}
                                    </li>
                                    @endforelse
                                   
                                </ul>
                            </div>
                        </div>
                        <div class="blog-widget">
                            <h4 class="widget-title">{{ __('Popular Posts') }}</h4>
                            @forelse($popularBlogs as $blog)
                            <div class="rc-post-item">
                                <div class="rc-post-thumb">
                                    <a href="{{ route('blog.show', $blog->slug) }}">
                                        <img class="h_60px" src="{{ asset($blog->image) }}" alt="img">
                                    </a>
                                </div>
                                <div class="rc-post-content">
                                    <span class="date"><i class="flaticon-calendar"></i> {{ formatDate($blog->created_at) }}</span>
                                    <h4 class="title"><a href="{{ route('blog.show', $blog->slug) }}">{{ truncate($blog->translation->title, 30) }}</a>
                                    </h4>
                                </div>
                            </div>
                            @empty
                            <p class="">{{ __('No latest post yet') }}.</p>
                            @endforelse
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>
    <!-- blog-area-end -->
@endsection
