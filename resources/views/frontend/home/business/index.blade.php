@extends('frontend.layouts.master')

@section('meta_title', $seo_setting['home_page']['seo_title'])
@section('meta_description', $seo_setting['home_page']['seo_description'])
@section('meta_keywords', '')

@section('contents')
    @if ($sectionSetting?->hero_section)
        <!-- banner-area -->
        @include('frontend.home.business.sections.banner-area')
        <!-- banner-area-end -->
    @endif
    @if ($sectionSetting?->our_features_section)
        <!-- features-area -->
        @include('frontend.home.business.sections.features-area')
        <!-- features-area-end -->
    @endif
    @if ($sectionSetting?->featured_course_section)
        <!-- course-area -->
        @include('frontend.home.business.sections.course-area')
        <!-- course-area-end -->
    @endif

    @if ($sectionSetting?->banner_section)
        <!-- instructor-area-two -->
        @include('frontend.home.business.sections.join-us')
        <!-- instructor-area-two-end -->
    @endif

    @if ($sectionSetting?->about_section)
        <!-- about-area -->
        @include('frontend.home.business.sections.about-area')
        <!-- about-area-end -->
    @endif

    @if ($sectionSetting?->top_category_section)
        <!-- categories-area -->
        @include('frontend.home.business.sections.category-area')
        <!-- categories-area-end -->
    @endif

    @if ($sectionSetting?->featured_instructor_section)
        <!-- instructor-area -->
        @include('frontend.home.business.sections.instructor-area')
        <!-- instructor-area-end -->
    @endif
    @if ($sectionSetting?->testimonial_section)
        <!-- testimonial-area -->
        @include('frontend.home.business.sections.testimonial-area')
        <!-- testimonial-area-end -->
    @endif

    @if ($sectionSetting?->brands_section)
        <!-- brand-area -->
        @include('frontend.home.business.sections.brand-area')
        <!-- brand-area-end -->
    @endif
    @if ($sectionSetting?->news_letter_section)
        <!-- newsletter-area -->
        @include('frontend.home.business.sections.newsletter-area')
        <!-- newsletter-area-end -->
    @endif

    @if ($sectionSetting?->latest_blog_section)
        <!-- blog-area -->
        @include('frontend.home.business.sections.blog-area')
        <!-- blog-area-end -->
    @endif
    @if ($sectionSetting?->banner_section)
        <!-- instructor-area-two -->
        <section class="newsletter__area-two">
            <div class="container">
                <div class="newsletter__inner-wrap">
                    <h2 class="title">{{__('Join our teaching team and inspire the next generation!')}}.</h2>
                    <div class="newsletter__btn">
                        <a href="{{ route('register') }}" class="btn arrow-btn btn-two">{{__('Get Started Now')}} <img src="{{ asset('frontend/img/icons/right_arrow.svg') }}" alt="" class="injectable"></a>
                    </div>
                    <img src="{{asset('frontend/img/others/h7_newsletter_shape01.svg')}}" alt="shape" data-aos="fade-down-right" data-aos-delay="400" class="shape shape-one">
                    <img src="{{asset('frontend/img/others/h7_newsletter_shape02.svg')}}" alt="shape" class="shape shape-two rotateme">
                </div>
            </div>
        </section>
        <!-- instructor-area-two-end -->
    @endif
@endsection
