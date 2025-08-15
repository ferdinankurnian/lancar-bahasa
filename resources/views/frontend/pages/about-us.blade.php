@extends('frontend.layouts.master')

@section('meta_title', $seo_setting['about_page']['seo_title'])
@section('meta_description', $seo_setting['about_page']['seo_description'])

@section('contents')
    <!-- breadcrumb-area -->
    <x-frontend.breadcrumb :title="__('About Us')" :links="[['url' => route('home'), 'text' => __('Home')], ['url' => '', 'text' => __('about us')]]" />
    <!-- breadcrumb-area-end -->

    <!-- about-area -->
    <section class="about-area tg-motion-effects section-py-120">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-6 col-md-9">
                    <div class="about__images">
                        <img src="{{ asset($aboutSection?->global_content?->image) }}" alt="img" class="main-img">
                        <img src="{{ asset('frontend/img/others/about_shape.svg') }}" alt="img"
                            class="shape alltuchtopdown">
                        <a href="{{ $aboutSection?->global_content?->video_url }}" class="popup-video">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="28" viewBox="0 0 22 28"
                                fill="none">
                                <path
                                    d="M0.19043 26.3132V1.69421C0.190288 1.40603 0.245303 1.12259 0.350273 0.870694C0.455242 0.6188 0.606687 0.406797 0.79027 0.254768C0.973854 0.10274 1.1835 0.0157243 1.39936 0.00193865C1.61521 -0.011847 1.83014 0.0480663 2.02378 0.176003L20.4856 12.3292C20.6973 12.4694 20.8754 12.6856 20.9999 12.9535C21.1245 13.2214 21.1904 13.5304 21.1904 13.8456C21.1904 14.1608 21.1245 14.4697 20.9999 14.7376C20.8754 15.0055 20.6973 15.2217 20.4856 15.3619L2.02378 27.824C1.83056 27.9517 1.61615 28.0116 1.40076 27.9981C1.18536 27.9847 0.97607 27.8983 0.792638 27.7472C0.609205 27.596 0.457661 27.385 0.352299 27.1342C0.246938 26.8833 0.191236 26.6008 0.19043 26.3132Z"
                                    fill="currentcolor" />
                            </svg>
                        </a>
                        @use(App\Enums\ThemeList)
                        @php
                            $theme = session()->has('demo_theme') ? session()->get('demo_theme') : config('app.default_homepage');
                        @endphp
                        @if (!in_array($theme, [ThemeList::BUSINESS->value, ThemeList::KINDERGARTEN->value]))
                            <div class="about__enrolled" data-aos="fade-right" data-aos-delay="200">
                                <p class="title"><span>{{ $hero?->content?->total_student }}</span>
                                    {{ __('Enrolled Students') }}</p>
                                <img src="{{ asset($hero?->global_content?->enroll_students_image) }}" alt="img">
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about__content">
                        <div class="section__title">
                            <span class="sub-title">{{ __('Get More About Us') }}</span>
                            <h2 class="title">
                                {!! clean(processText($aboutSection?->content?->title)) !!}
                            </h2>
                        </div>

                        {!! clean(processText($aboutSection?->content?->description)) !!}
                        @if ($aboutSection?->global_content?->button_url != null)
                            <div class="tg-button-wrap">
                                <a href="{{ $aboutSection?->global_content?->button_url }}"
                                    class="btn arrow-btn">{{ $aboutSection?->content?->button_text }} <img
                                        src="{{ asset('frontend/img/icons/right_arrow.svg') }}" alt="img"
                                        class="injectable"></a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- about-area-end -->

    <!-- brand-area -->
    <div class="brand-area">
        <div class="container-fluid">
            <div class="marquee_mode">
                @foreach ($brands as $brand)
                    <div class="brand__item">
                        <a href="{{ $brand?->url }}"><img src="{{ asset($brand?->image) }}" alt="brand"></a>
                        <img src="{{ asset('frontend/img/icons/brand_star.svg') }}" alt="star">
                    </div>
                @endforeach

            </div>
        </div>
    </div>
    <!-- brand-area-end -->


    <section class="faq__area about">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="faq__img-wrap tg-svg">
                        <div class="faq__round-text">
                            <div class="curved-circle {{ getSessionLanguage() == 'en' ? '' : 'd-none' }}">
                                * {{ __('Education') }} * {{ __('System ') }} * {{ __('can') }} *
                                {{ __('Make ') }} * {{ __('Change ') }} *
                            </div>
                        </div>
                        <div class="faq__img">
                            <img src="{{ asset($faqSection?->global_content?->image) }}" alt="img">
                            <div class="shape-one">
                                <img src="{{ asset('frontend/img/others/faq_shape01.svg') }}"
                                    class="injectable tg-motion-effects4" alt="img">
                            </div>
                            <div class="shape-two">
                                <span class="svg-icon" id="faq-svg"
                                    data-svg-icon="{{ asset('frontend/img/others/faq_shape02.svg') }}"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="faq__content">
                        <div class="section__title pb-10">
                            <span class="sub-title">{{ $faqSection?->content?->short_title }}</span>
                            <h2 class="title">{!! clean(processText($faqSection?->content?->title)) !!}</h2>
                        </div>
                        <p>{!! clean(processText($faqSection?->content?->description)) !!}</p>
                        <div class="faq__wrap">
                            <div class="accordion" id="accordionExample">
                                @foreach ($faqs as $faq)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button {{ $loop?->first ? '' : 'collapsed' }}"
                                                type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapse{{ $faq?->id }}" aria-expanded="true"
                                                aria-controls="collapse{{ $faq?->id }}">
                                                {{ $faq?->translation?->question }}
                                            </button>
                                        </h2>
                                        <div id="collapse{{ $faq?->id }}"
                                            class="accordion-collapse collapse {{ $loop?->first ? 'show' : '' }}"
                                            data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <p>
                                                    {{ $faq?->translation?->answer }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @php
        $theme_name = session()->has('demo_theme') ? session()->get('demo_theme') : config('app.default_homepage');
    @endphp

    <!-- features-area -->
    <section class="features__area {{ isRoute('about-us', "feature_{$theme_name}") }}">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6">
                    <div class="section__title white-title text-center mb-50">
                        <span class="sub-title">{{ __('How We Start Journey') }}</span>
                        <h2 class="title">{{ __('Start your Learning Journey Today!') }}</h2>
                        <p>{{ __('Discover a World of Knowledge and Skills at Your Fingertips – Unlock Your Potential and Achieve Your Dreams with Our Comprehensive Learning Resources!') }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="features__item">
                        <div class="features__icon">
                            <img src="{{ asset($ourFeatures?->global_content?->image_one) }}" class="injectable"
                                alt="img">
                        </div>
                        <div class="features__content">
                            <h4 class="title">{{ $ourFeatures?->content?->title_one }}</h4>
                            <p>{{ $ourFeatures?->content?->sub_title_one }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="features__item">
                        <div class="features__icon">
                            <img src="{{ asset($ourFeatures?->global_content?->image_two) }}" class="injectable"
                                alt="img">
                        </div>
                        <div class="features__content">
                            <h4 class="title">{{ $ourFeatures?->content?->title_two }}</h4>
                            <p>{{ $ourFeatures?->content?->sub_title_two }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="features__item">
                        <div class="features__icon">
                            <img src="{{ asset($ourFeatures?->global_content?->image_three) }}" class="injectable"
                                alt="img">
                        </div>
                        <div class="features__content">
                            <h4 class="title">{{ $ourFeatures?->content?->title_three }}</h4>
                            <p>{{ $ourFeatures?->content?->sub_title_three }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="features__item">
                        <div class="features__icon">
                            <img src="{{ asset($ourFeatures?->global_content?->image_four) }}" class="injectable"
                                alt="img">
                        </div>
                        <div class="features__content">
                            <h4 class="title">{{ $ourFeatures?->content?->title_four }}</h4>
                            <p>{{ $ourFeatures?->content?->sub_title_four }}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- features-area-end -->

    <!-- testimonial-area -->
    <section class="testimonial__area about_testimonial section-py-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-5">
                    <div class="section__title text-center mb-50">
                        <span class="sub-title">{{ __('Our Testimonials') }}</span>
                        <h2 class="title">{{ __('What Students Think and Say About Us') }}</h2>
                        <p>{{ __('genuine feedback from our students about their experiences with our teaching') }}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="testimonial__item-wrap">
                        <div class="swiper-container testimonial-swiper-active">
                            <div class="swiper-wrapper">
                                @foreach ($reviews as $testimonial)
                                    <div class="swiper-slide">
                                        <div class="testimonial__item">
                                            <div class="testimonial__item-top">
                                                <div class="testimonial__author">
                                                    <div class="testimonial__author-thumb">
                                                        <img src="{{ asset($testimonial?->image) }}" alt="img">
                                                    </div>
                                                    <div class="testimonial__author-content">
                                                        <div class="rating">
                                                            @for ($i = 0; $i < $testimonial?->rating; $i++)
                                                                <i class="fas fa-star"></i>
                                                            @endfor
                                                        </div>
                                                        <h2 class="title">{{ $testimonial?->translation?->name }}</h2>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="testimonial__content">
                                                <p>“ {{ $testimonial?->translation?->comment }} ”</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="testimonial__nav">
                            <button class="testimonial-button-prev"><i class="flaticon-arrow-right"></i></button>
                            <button class="testimonial-button-next"><i class="flaticon-arrow-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- testimonial-area-end -->


    <!-- newsletter-area -->
    <section class="newsletter__area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4">
                    <div class="newsletter__img-wrap">
                        <img src="{{ asset($newsletterSection?->global_content?->image) }}" alt="img">
                        <img src="{{ asset('frontend/img/others/newsletter_shape01.png') }}" alt="img"
                            data-aos="fade-up" data-aos-delay="400">
                        <img src="{{ asset('frontend/img/others/newsletter_shape02.png') }}" alt="img"
                            class="alltuchtopdown">
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="newsletter__content">
                        <h2 class="title"><b>{{ __('Want to stay informed about') }}</b> <br>
                            <b>{{ __('new courses and study') }}?</b>
                        </h2>
                        <div class="newsletter__form">
                            <form action="" method="post" class="newsletter">
                                @csrf
                                <input type="email" placeholder="{{ __('Type your email') }}" name="email">
                                <button type="submit" class="btn">{{ __('Subscribe Now') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="newsletter__shape">
            <img src="{{ asset('frontend/img/others/newsletter_shape03.png') }}" alt="img" data-aos="fade-left"
                data-aos-delay="400">
        </div>
    </section>
    <!-- newsletter-area-end -->
@endsection
