@extends('frontend.layouts.master')

@section('meta_title', $seo_setting['home_page']['seo_title'])
@section('meta_description', $seo_setting['home_page']['seo_description'])
@section('meta_keywords', '')

@section('contents')
    @if ($sectionSetting?->hero_section)
        <!-- banner-area -->
        @include('frontend.home.language.sections.banner-area')
        <!-- banner-area-end -->
    @endif

    @if ($sectionSetting?->top_category_section)
        <!-- categories-area -->
        @include('frontend.home.language.sections.category-area')
        <!-- categories-area-end -->
    @endif

    @if ($sectionSetting?->about_section)
        <!-- about-area -->
        @include('frontend.home.language.sections.about-area')
        <!-- about-area-end -->
    @endif

    @if ($sectionSetting?->featured_course_section)
        <!-- course-area -->
        @include('frontend.home.language.sections.course-area')
        <!-- course-area-end -->
    @endif

    @if ($sectionSetting?->faq_section)
        <!-- faq-area -->
        @include('frontend.home.language.sections.faq-area')
        <!-- faq-area-end -->
    @endif

    @if ($sectionSetting?->testimonial_section)
        <!-- testimonial-area -->
        @include('frontend.home.language.sections.testimonial-area')
        <!-- testimonial-area-end -->
    @endif

    @if ($sectionSetting?->counter_section)
        <!-- fact-area -->
        @include('frontend.home.language.sections.fact-area')
        <!-- fact-area-end -->
    @endif

    @if ($sectionSetting?->latest_blog_section)
        <!-- blog-area -->
        @include('frontend.home.language.sections.blog-area')
        <!-- blog-area-end -->
    @endif
    @if ($sectionSetting?->news_letter_section)
        <!-- newsletter-area -->
        @include('frontend.home.language.sections.newsletter-area')
        <!-- newsletter-area-end -->
    @endif
@endsection
