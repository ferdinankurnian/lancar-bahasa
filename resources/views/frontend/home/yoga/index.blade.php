@extends('frontend.layouts.master')

@section('meta_title', $seo_setting['home_page']['seo_title'])
@section('meta_description', $seo_setting['home_page']['seo_description'])
@section('meta_keywords', '')

@section('contents')
    @if ($sectionSetting?->hero_section)
        <!-- banner-area -->
        @include('frontend.home.yoga.sections.banner-area')
        <!-- banner-area-end -->
    @endif
    @if ($sectionSetting?->our_features_section)
        <!-- features-area -->
        @include('frontend.home.yoga.sections.features-area')
        <!-- features-area-end -->
    @endif
    @if ($sectionSetting?->about_section)
        <!-- about-area -->
        @include('frontend.home.yoga.sections.about-area')
        <!-- about-area-end -->
    @endif
    @if ($sectionSetting?->featured_course_section)
        <!-- course-area -->
        @include('frontend.home.yoga.sections.course-area')
        <!-- course-area-end -->
    @endif
    @if ($sectionSetting?->banner_section)
        <!-- instructor-area-two -->
        @include('frontend.home.yoga.sections.join-us')
        <!-- instructor-area-two-end -->
    @endif
    @if ($sectionSetting?->featured_instructor_section)
        <!-- instructor-area -->
        @include('frontend.home.yoga.sections.instructor-area')
        <!-- instructor-area-end -->
    @endif
    @if ($sectionSetting?->brands_section)
        <!-- brand-area -->
        @include('frontend.home.main.sections.brand-area')
        <!-- brand-area-end -->
    @endif
    @if ($sectionSetting?->top_category_section)
        <!-- categories-area -->
        @include('frontend.home.yoga.sections.category-area')
        <!-- categories-area-end -->
    @endif
    @if ($sectionSetting?->testimonial_section)
        <!-- testimonial-area -->
        @include('frontend.home.yoga.sections.testimonial-area')
        <!-- testimonial-area-end -->
    @endif
    @if ($sectionSetting?->news_letter_section)
        <!-- newsletter-area -->
        @include('frontend.home.yoga.sections.newsletter-area')
        <!-- newsletter-area-end -->
    @endif
    @if ($sectionSetting?->latest_blog_section)
        <!-- blog-area -->
        @include('frontend.home.yoga.sections.blog-area')
        <!-- blog-area-end -->
    @endif
    @if ($sectionSetting?->banner_section)
        <!-- instructor-area-two -->
        @include('frontend.home.yoga.sections.join-us-two')
        <!-- instructor-area-two-end -->
    @endif
@endsection
@push('scripts')
    <script>
        const text = document.querySelector('.circle');
        text.innerHTML = text.textContent.replace(/\S/g, "<span>$&</span>");
        const element = document.querySelectorAll('.circle span');
        for (let i = 0; i < element.length; i++) {
            element[i].style.transform = "rotate(" + i * 13 + "deg)"
        }
    </script>
@endpush
@push('styles')
    <style>
        @if ($setting?->header_topbar_status == 'inactive')
            .home_yoga #sticky-header {
                top: 0;
            }
        @endif
    </style>
@endpush
