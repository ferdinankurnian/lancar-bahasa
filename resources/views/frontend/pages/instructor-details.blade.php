@extends('frontend.layouts.master')
@section('meta_title', 'Instructor Details' . ' || ' . $setting->app_name)

@section('contents')
    <!-- breadcrumb-area -->
    <x-frontend.breadcrumb :title="__('Instructor Details')" :links="[['url' => route('home'), 'text' => __('Home')], ['url' => '', 'text' => __('Instructor Details')]]" />
    <!-- breadcrumb-area-end -->

    <!-- instructor-details-area -->
    <section class="instructor__details-area section-pt-120 section-pb-90">
        <div class="container">
            <div class="row">
                <div class="col-xl-9">
                    <div class="instructor__details-wrap">
                        <div class="instructor__details-info">
                            <div class="instructor__details-thumb">
                                <img src="{{ asset($instructor->image) }}" alt="img">
                            </div>
                            <div class="instructor__details-content">
                                <div class="badges">
                                    @if ($instructor->created_at->diffInDays(now()) >= $badges['registration_badge_three'][0]->condition_from)
                                        <li><img src="{{ asset($badges['registration_badge_three'][0]->image) }}"
                                                alt="{{ $badges['registration_badge_three'][0]->name }}"></li>
                                    @elseif (
                                        $instructor->created_at->diffInDays(now()) >= $badges['registration_badge_two'][0]->condition_from &&
                                            $instructor->created_at->diffInDays(now()) < $badges['registration_badge_two'][0]->condition_to)
                                        <li><img src="{{ asset($badges['registration_badge_two'][0]->image) }}"
                                                alt="{{ $badges['registration_badge_two'][0]->name }}"></li>
                                    @elseif (
                                        $instructor->created_at->diffInDays(now()) >= $badges['registration_badge_one'][0]->condition_from &&
                                            $instructor->created_at->diffInDays(now()) < $badges['registration_badge_one'][0]->condition_to)
                                        <li><img src="{{ asset($badges['registration_badge_one'][0]->image) }}"
                                                alt="{{ $badges['registration_badge_one'][0]->name }}"></li>
                                    @endif

                                    @if ($instructor->courses->count() >= $badges['course_count_badge_three'][0]->condition_from)
                                        <li><img src="{{ asset($badges['course_count_badge_three'][0]->image) }}"
                                                alt="{{ $badges['course_count_badge_three'][0]->name }}"></li>
                                    @elseif (
                                        $instructor->courses->count() >= $badges['course_count_badge_two'][0]->condition_from &&
                                            $instructor->courses->count() < $badges['course_count_badge_two'][0]->condition_to)
                                        <li><img src="{{ asset($badges['course_count_badge_two'][0]->image) }}"
                                                alt="{{ $badges['course_count_badge_two'][0]->name }}"></li>
                                    @elseif (
                                        $instructor->courses->count() >= $badges['course_count_badge_one'][0]->condition_from &&
                                            $instructor->courses->count() < $badges['course_count_badge_one'][0]->condition_to)
                                        <li><img src="{{ asset($badges['course_count_badge_one'][0]->image) }}"
                                                alt="{{ $badges['course_count_badge_one'][0]->name }}"></li>
                                    @endif

                                    @if ($instructor->courses->avg('avg_rating') >= $badges['course_rating_badge_three'][0]->condition_from)
                                        <li><img src="{{ asset($badges['course_rating_badge_three'][0]->image) }}"
                                                alt="{{ $badges['course_rating_badge_three'][0]->name }}"></li>
                                    @elseif (
                                        $instructor->courses->avg('avg_rating') >= $badges['course_rating_badge_two'][0]->condition_from &&
                                            $instructor->courses->avg('avg_rating') < $badges['course_rating_badge_two'][0]->condition_to)
                                        <li><img src="{{ asset($badges['course_rating_badge_two'][0]->image) }}"
                                                alt="{{ $badges['course_rating_badge_two'][0]->name }}"></li>
                                    @elseif (
                                        $instructor->courses->avg('avg_rating') >= $badges['course_rating_badge_one'][0]->condition_from &&
                                            $instructor->courses->avg('avg_rating') < $badges['course_rating_badge_one'][0]->condition_to)
                                        <li><img src="{{ asset($badges['course_rating_badge_one'][0]->image) }}"
                                                alt="{{ $badges['course_rating_badge_one'][0]->name }}"></li>
                                    @endif
                                    @php
                                        $totalEnrollment = 0;
                                        foreach ($instructor->courses as $course) {
                                            $totalEnrollment += $course->enrollments->count();
                                        }
                                    @endphp

                                    @if ($totalEnrollment >= $badges['course_enroll_badge_three'][0]->condition_from)
                                        <li><img src="{{ asset($badges['course_enroll_badge_three'][0]->image) }}"
                                                alt="{{ $badges['course_enroll_badge_three'][0]->name }}"></li>
                                    @elseif (
                                        $totalEnrollment >= $badges['course_enroll_badge_two'][0]->condition_from &&
                                            $totalEnrollment < $badges['course_enroll_badge_two'][0]->condition_to)
                                        <li><img src="{{ asset($badges['course_enroll_badge_two'][0]->image) }}"
                                                alt="{{ $badges['course_enroll_badge_two'][0]->name }}"></li>
                                    @elseif (
                                        $totalEnrollment >= $badges['course_enroll_badge_one'][0]->condition_from &&
                                            $totalEnrollment < $badges['course_enroll_badge_one'][0]->condition_to)
                                        <li><img src="{{ asset($badges['course_enroll_badge_one'][0]->image) }}"
                                                alt="{{ $badges['course_enroll_badge_one'][0]->name }}"></li>
                                    @endif

                                </div>
                                <h2 class="title">{{ $instructor->name }}</h2>
                                <span class="designation">{{ $instructor->job_title }}</span>
                                <ul class="list-wrap">
                                    <li class="avg-rating"><i
                                            class="fas fa-star"></i>({{ number_format($instructor->courses->avg('avg_rating'), 1) }}
                                        {{ __('Reviews') }})</li>
                                    <li><i class="far fa-envelope"></i><a
                                            href="mailto:{{ $instructor->email }}">{{ $instructor->email }}</a></li>
                                    @if ($instructor?->country?->name)
                                        <li><i class="fas fa-search-location"></i><a
                                                href="javascript:;">{{ $instructor?->country?->name }}</a></li>
                                    @endif
                                </ul>
                                <p>{{ $instructor->short_bio }}</p>
                                <div class="instructor__details-social">
                                    <ul class="list-wrap">
                                        @if ($instructor->facebook)
                                            <li><a href="{{ $instructor->facebook }}"><i class="fab fa-facebook-f"></i></a>
                                            </li>
                                        @endif
                                        @if ($instructor->twitter)
                                            <li><a href="{{ $instructor->twitter }}"><i class="fab fa-twitter"></i></a>
                                            </li>
                                        @endif
                                        @if ($instructor->linkedin)
                                            <li><a href="{{ $instructor->linkedin }}"><i class="fab fa-linkedin"></i></a>
                                            </li>
                                        @endif
                                        @if ($instructor->github)
                                            <li><a href="{{ $instructor->github }}"><i class="fab fa-github"></i></a></li>
                                        @endif
                                        @if ($instructor->website)
                                            <li><a href="{{ $instructor->website }}"><i class="fas fa-link"></i></a></li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="instructor__details-biography">
                            <h4 class="title">{{ __('Biography') }}</h4>
                            <p>{!! clean(nl2br($instructor->bio)) !!}</p>
                        </div>
                        <div class="instructor__details-Skill">
                            <h4 class="title">{{ __('Experience') }}</h4>
                            <!-- Timeline 1 - Bootstrap Brain Component -->
                            <div class="bsb-timeline-1">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-10 col-md-8 col-xl-8">

                                            <ul class="timeline">
                                                @foreach ($experiences as $experience)
                                                    <li class="timeline-item">
                                                        <div class="timeline-body">
                                                            <div class="timeline-content">
                                                                <div class="card border-0">
                                                                    <div class="card-body p-0">
                                                                        <h6 class="card-subtitle text-secondary mb-1">
                                                                            {{ formatDate($experience->start_date) }} -
                                                                            {{ $experience->current == 1 ? 'Present' : formatDate($experience->end_date) }}
                                                                        </h6>
                                                                        <h5 class="card-title mb-3">
                                                                            {{ $experience->company }}</h5>
                                                                        <h6 class="card-subtitle text-secondary mb-1">
                                                                            {{ $experience->position }}
                                                                        </h6>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="instructor__details-Skill">
                            <h4 class="title">{{ __('Education') }}</h4>
                            <div class="bsb-timeline-1">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-10 col-md-8 col-xl-6">

                                            <ul class="timeline">
                                                @foreach ($educations as $education)
                                                    <li class="timeline-item">
                                                        <div class="timeline-body">
                                                            <div class="timeline-content">
                                                                <div class="card border-0">
                                                                    <div class="card-body p-0">
                                                                        <h6 class="card-subtitle text-secondary mb-1">
                                                                            {{ formatDate($education->start_date) }} -
                                                                            {{ $education->current == 1 ? 'Present' : formatDate($education->end_date) }}
                                                                        </h6>

                                                                        <h5 class="card-title mb-3">
                                                                            {{ $education->organization }}</h5>
                                                                            <h6 class="card-subtitle text-secondary mb-1">
                                                                                {{ $education->degree }}
                                                                            </h6>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        @if ($courses->count() > 0)
                            <div class="instructor__details-courses">
                                <div class="row align-items-center mb-30">
                                    <div class="col-md-8">
                                        <h2 class="main-title">{{ __('My Courses') }}</h2>
                                        <p>{{ __('Checkout my latest courses') }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="instructor__details-nav">
                                            <button class="courses-button-prev"><i
                                                    class="flaticon-arrow-right"></i></button>
                                            <button class="courses-button-next"><i
                                                    class="flaticon-arrow-right"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper courses-swiper-active-two">
                                    <div class="swiper-wrapper">
                                        @foreach ($courses as $course)
                                            <div class="swiper-slide">
                                                <div class="courses__item shine__animate-item">
                                                    <div class="courses__item-thumb">
                                                        <a href="{{ route('course.show', $course->slug) }}"
                                                            class="shine__animate-link">
                                                            <img src="{{ asset($course->thumbnail) }}" alt="img">
                                                        </a>
                                                    </div>
                                                    <div class="courses__item-content">
                                                        <ul class="courses__item-meta list-wrap">
                                                            <li class="courses__item-tag">
                                                                <a
                                                                    href="course.html">{{ $course->category->translation->name }}</a>
                                                            </li>
                                                            <li class="avg-rating"><i class="fas fa-star"></i>
                                                                {{ number_format($course->reviews()->avg('rating'), 1) ?? 0 }}
                                                            </li>
                                                        </ul>
                                                        <h5 class="title"><a
                                                                href="{{ route('course.show', $course->slug) }}">{{ truncate($course->title, 50) }}</a>
                                                        </h5>
                                                        <p class="author">{{ __('By') }} <a
                                                                href="{{ route('instructor-details', ['id' => $course->instructor->id, 'slug' => Str::slug($course->instructor->name)]) }}">{{ $course->instructor->name }}</a>
                                                        </p>
                                                        <div class="courses__item-bottom">
                                                            @if (in_array($course->id, session('enrollments') ?? []))
                                                                <div class="button">
                                                                    <a href="{{ route('student.enrolled-courses') }}"
                                                                        class="already-enrolled-btn" data-id="">
                                                                        <span class="text">{{ __('Enrolled') }}</span>
                                                                        <i class="flaticon-arrow-right"></i>
                                                                    </a>
                                                                </div>
                                                            @elseif ($course->enrollments->count() >= $course->capacity && $course->capacity != null)
                                                                <div class="button">
                                                                    <a href="javascript:;" class=""
                                                                        data-id="{{ $course->id }}">
                                                                        <span class="text">{{ __('Booked') }}</span>
                                                                        <i class="flaticon-arrow-right"></i>
                                                                    </a>
                                                                </div>
                                                            @else
                                                                <div class="button">
                                                                    <a href="javascript:;" class="add-to-cart"
                                                                        data-id="{{ $course->id }}">
                                                                        <span
                                                                            class="text">{{ __('Add To Cart') }}</span>
                                                                        <i class="flaticon-arrow-right"></i>
                                                                    </a>
                                                                </div>
                                                            @endif
                                                            @if ($course->price == 0)
                                                                <h5 class="price">{{ __('Free') }}</h5>
                                                            @elseif ($course->price > 0 && $course->discount > 0)
                                                                <h5 class="price">{{ currency($course->discount) }}</h5>
                                                            @else
                                                                <h5 class="price">{{ currency($course->price) }}</h5>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="instructor__sidebar">
                        <h4 class="title">{{ __('Quick Contact') }}</h4>
                        <p>{{ __('Feel free to contact me through mail') }}!</p>
                        <form action="{{ route('quick-connect', $instructor->id) }}" method="POST">
                            @csrf
                            <div class="form-grp">
                                <input type="text" placeholder="Name" name="name">
                            </div>
                            <div class="form-grp">
                                <input type="email" placeholder="E-mail" name="email">
                            </div>
                            <div class="form-grp">
                                <input type="text" placeholder="subject" name="subject">
                            </div>
                            <div class="form-grp">
                                <textarea name="message" placeholder="Type Message"></textarea>
                            </div>
                            @if (Cache::get('setting')->recaptcha_status === 'active')
                                <div class="form-group mt-3">
                                    <div class="g-recaptcha overflow-hidden"
                                        data-sitekey="{{ Cache::get('setting')->recaptcha_site_key }}"></div>
                                </div>
                            @endif
                            <button type="submit" class="btn arrow-btn">{{ __('Send Message') }} <img
                                    src="{{ asset('frontend/img/icons/right_arrow.svg') }}" alt="img"
                                    class="injectable"></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- instructor-details-area-end -->
@endsection
@if (session('instructorQuickContact') && $setting->google_tagmanager_status == 'active' && $marketing_setting?->instructor_contact)
    @php
        $instructorQuickContact = session('instructorQuickContact');
        session()->forget('instructorQuickContact');
    @endphp
    @push('scripts')
        <script>
            $(function() {
                dataLayer.push({
                    'event': 'instructorQuickContact',
                    'contact_info': @json($instructorQuickContact)
                });
            });
        </script>
    @endpush
@endif
