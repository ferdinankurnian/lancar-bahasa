<section class="courses-area-four courses__bg-three" data-background="{{ asset('frontend/img/bg/h5_courses_bg.jpg') }}">
    <div class="courses__bg-shape-one">
        <img src="{{ asset('frontend/img/courses/h5_courses_bg_shape01.svg') }}" class="injectable">
    </div>
    <div class="courses__bg-shape-two">
        <img src="{{ asset('frontend/img/courses/h5_courses_bg_shape02.svg') }}" class="injectable">
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9 col-xl-8 col-xxl-6">
                <div class="section__title text-center mb-50">
                    <span class="sub-title">{{ __('Top Class Courses') }}</span>
                    <h2 class="title bold">{{ __('Get The Best Exciting Class Experience With us') }}</h2>
                    <p class="desc">{{ __('Check out the most demanding courses right now') }}</p>
                </div>
            </div>
            <div class="col-xxl-10 col-xl-9 col-lg-10">
                <div class="courses__nav-two mb-50">
                    <ul class="nav nav-tabs" id="courseTab" role="tablist">
                        @php
                            $allCoursesIds = json_decode(
                                $featuredCourse?->all_category_ids ? $featuredCourse->all_category_ids : '[]',
                            );
                            $allCourses = App\Models\Course::with('category.translation', 'instructor:id,name')
                                ->whereIn('id', $allCoursesIds)
                                ->withCount([
                                    'reviews as avg_rating' => function ($query) {
                                        $query->select(DB::raw('coalesce(avg(rating), 0)'));
                                    },
                                ])
                                ->withCount([
                                    'lessons' => function ($query) {
                                        $query->where('status', 'active');
                                    },
                                ])
                                ->withCount('enrollments')
                                ->get();
                        @endphp
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="all-tab" data-bs-toggle="tab"
                                data-bs-target="#all-tab-pane" type="button" role="tab"
                                aria-controls="all-tab-pane" aria-selected="true">
                                {{ __('All') }}
                            </button>
                        </li>
                        @if ($featuredCourse?->category_one_status == 1)
                            <li class="nav-item" role="presentation">
                                @php
                                    $categoryOne = Modules\Course\app\Models\CourseCategory::with(['translation'])
                                        ->where('id', $featuredCourse->category_one)
                                        ->first();
                                    $categoryOneIds = json_decode($featuredCourse->category_one_ids);
                                    $categoryOneCourses = App\Models\Course::with(
                                        'category.translation',
                                        'instructor:id,name',
                                    )
                                        ->whereIn('id', $categoryOneIds)
                                        ->withCount([
                                            'reviews as avg_rating' => function ($query) {
                                                $query->select(DB::raw('coalesce(avg(rating), 0)'));
                                            },
                                        ])
                                        ->withCount('enrollments')
                                        ->get();
                                @endphp
                                <button class="nav-link" id="chinese-tab" data-bs-toggle="tab"
                                    data-bs-target="#chinese-tab-pane" type="button" role="tab"
                                    aria-controls="chinese-tab-pane" aria-selected="false">
                                    {{ $categoryOne?->name }}
                                </button>
                            </li>
                        @endif
                        @if ($featuredCourse?->category_two_status == 1)
                            <li class="nav-item" role="presentation">
                                @php
                                    $categoryTwo = Modules\Course\app\Models\CourseCategory::with(['translation'])
                                        ->where('id', $featuredCourse->category_two)
                                        ->first();
                                    $categoryTwoIds = json_decode($featuredCourse->category_two_ids);
                                    $categoryTwoCourses = App\Models\Course::with(
                                        'category.translation',
                                        'instructor:id,name',
                                    )
                                        ->whereIn('id', $categoryTwoIds)
                                        ->withCount([
                                            'reviews as avg_rating' => function ($query) {
                                                $query->select(DB::raw('coalesce(avg(rating), 0)'));
                                            },
                                        ])
                                        ->withCount('enrollments')
                                        ->get();
                                @endphp
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="dessert-tab" data-bs-toggle="tab"
                                    data-bs-target="#dessert-tab-pane" type="button" role="tab"
                                    aria-controls="dessert-tab-pane" aria-selected="false">
                                    {{ $categoryTwo?->name }}
                                </button>
                            </li>
                        @endif
                        @if ($featuredCourse?->category_three_status == 1)
                            <li class="nav-item" role="presentation">
                                @php
                                    $categoryThree = Modules\Course\app\Models\CourseCategory::with(['translation'])
                                        ->where('id', $featuredCourse->category_three)
                                        ->first();
                                    $categoryThreeIds = json_decode($featuredCourse->category_three_ids);
                                    $categoryThreeCourses = App\Models\Course::with(
                                        'category.translation',
                                        'instructor:id,name',
                                    )
                                        ->whereIn('id', $categoryThreeIds)
                                        ->withCount([
                                            'reviews as avg_rating' => function ($query) {
                                                $query->select(DB::raw('coalesce(avg(rating), 0)'));
                                            },
                                        ])
                                        ->withCount('enrollments')
                                        ->get();
                                @endphp
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="italian-tab" data-bs-toggle="tab"
                                    data-bs-target="#italian-tab-pane" type="button" role="tab"
                                    aria-controls="italian-tab-pane" aria-selected="false">
                                    {{ $categoryThree?->name }}
                                </button>
                            </li>
                        @endif
                        @if ($featuredCourse?->category_four_status == 1)
                            <li class="nav-item" role="presentation">
                                @php
                                    $categoryFour = Modules\Course\app\Models\CourseCategory::with(['translation'])
                                        ->where('id', $featuredCourse->category_four)
                                        ->first();
                                    $categoryFourIds = json_decode($featuredCourse->category_four_ids);
                                    $categoryFourCourses = App\Models\Course::with(
                                        'category.translation',
                                        'instructor:id,name',
                                    )
                                        ->whereIn('id', $categoryFourIds)
                                        ->withCount([
                                            'reviews as avg_rating' => function ($query) {
                                                $query->select(DB::raw('coalesce(avg(rating), 0)'));
                                            },
                                        ])
                                        ->withCount('enrollments')
                                        ->get();
                                @endphp
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pizza-tab" data-bs-toggle="tab"
                                    data-bs-target="#pizza-tab-pane" type="button" role="tab"
                                    aria-controls="pizza-tab-pane" aria-selected="false">
                                    {{ $categoryFour?->name }}
                                </button>
                            </li>
                        @endif
                        @if ($featuredCourse?->category_five_status == 1)
                            <li class="nav-item" role="presentation">
                                @php
                                    $categoryFive = Modules\Course\app\Models\CourseCategory::with(['translation'])
                                        ->where('id', $featuredCourse->category_five)
                                        ->first();
                                    $categoryFiveIds = json_decode($featuredCourse->category_five_ids);
                                    $categoryFiveCourses = App\Models\Course::with(
                                        'category.translation',
                                        'instructor:id,name',
                                    )
                                        ->whereIn('id', $categoryFiveIds)
                                        ->withCount([
                                            'reviews as avg_rating' => function ($query) {
                                                $query->select(DB::raw('coalesce(avg(rating), 0)'));
                                            },
                                        ])
                                        ->withCount('enrollments')
                                        ->get();
                                @endphp
                                <button class="nav-link" id="development-tab" data-bs-toggle="tab"
                                    data-bs-target="#development-tab-pane" type="button" role="tab"
                                    aria-controls="development-tab-pane" aria-selected="false">
                                    {{ $categoryFive?->name }}
                                </button>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="all-tab-pane" role="tabpanel" aria-labelledby="all-tab"
                tabindex="0">
                <div class="row justify-content-center">
                    @foreach ($allCourses ?? [] as $course)
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="courses__item-six shine__animate-item">
                                <div class="courses__item-thumb-five shine__animate-link">
                                    <a href="{{ route('course.show', $course->slug) }}"><img
                                            src="{{ asset($course->thumbnail) }}" alt="{{ $course->title }}"></a>
                                </div>
                                <div class="courses__item-content-five">
                                    <ul class="courses__item-meta list-wrap">
                                        <li class="courses__review courses__review-two">
                                            <div class="rating">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= floor($course->avg_rating))
                                                        <i class="fas fa-solid fa-star"></i>
                                                    @elseif ($i - 0.5 <= $course->avg_rating)
                                                        <i class="fas fa-solid fa-star-half-alt"></i>
                                                    @else
                                                        <i class="far fa-star"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <span>({{ number_format($course->avg_rating, 1) ?? 0 }})</span>
                                        </li>
                                        @if ($course->price == 0)
                                            <li class="price">{{ __('Free') }}</li>
                                        @elseif ($course->price > 0 && $course->discount > 0)
                                            <li class="price">{{ currency($course->discount) }}</li>
                                        @else
                                            <li class="price">{{ currency($course->price) }}</li>
                                        @endif
                                    </ul>
                                    <h2 class="title"><a
                                            href="{{ route('course.show', $course->slug) }}">{{ truncate($course->title, 38) }}</a>
                                    </h2>
                                    <p>{{ truncate($course->seo_description, 50) }}</p>
                                    <div class="courses__item-content-bottom-two">
                                        <ul class="list-wrap">
                                            <li>
                                                <div class="icon">
                                                    <i class="flaticon-book"></i>
                                                </div>
                                                <p><span>{{ __('Lessons') }}:</span>{{ $course?->lessons_count }}</p>
                                            </li>
                                            <li>
                                                <div class="icon">
                                                    <i class="flaticon-mortarboard"></i>
                                                </div>
                                                <p><span>{{ __('Students') }}:
                                                    </span>{{ $course?->enrollments_count }}</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="tab-pane fade" id="chinese-tab-pane" role="tabpanel" aria-labelledby="chinese-tab"
                tabindex="0">
                <div class="row justify-content-center">
                    @foreach ($categoryOneCourses ?? [] as $course)
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="courses__item-six shine__animate-item">
                                <div class="courses__item-thumb-five shine__animate-link">
                                    <a href="{{ route('course.show', $course->slug) }}"><img
                                            src="{{ asset($course->thumbnail) }}" alt="{{ $course->title }}"></a>
                                </div>
                                <div class="courses__item-content-five">
                                    <ul class="courses__item-meta list-wrap">
                                        <li class="courses__review courses__review-two">
                                            <div class="rating">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= floor($course->avg_rating))
                                                        <i class="fas fa-solid fa-star"></i>
                                                    @elseif ($i - 0.5 <= $course->avg_rating)
                                                        <i class="fas fa-solid fa-star-half-alt"></i>
                                                    @else
                                                        <i class="far fa-star"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <span>({{ number_format($course->avg_rating, 1) ?? 0 }})</span>
                                        </li>
                                        @if ($course->price == 0)
                                            <li class="price">{{ __('Free') }}</li>
                                        @elseif ($course->price > 0 && $course->discount > 0)
                                            <li class="price">{{ currency($course->discount) }}</li>
                                        @else
                                            <li class="price">{{ currency($course->price) }}</li>
                                        @endif
                                    </ul>
                                    <h2 class="title"><a
                                            href="{{ route('course.show', $course->slug) }}">{{ truncate($course->title, 38) }}</a>
                                    </h2>
                                    <p>{{ truncate($course->seo_description, 50) }}</p>
                                    <div class="courses__item-content-bottom-two">
                                        <ul class="list-wrap">
                                            <li>
                                                <div class="icon">
                                                    <i class="flaticon-book"></i>
                                                </div>
                                                <p><span>{{ __('Lessons') }}:</span>{{ $course?->lessons_count }}</p>
                                            </li>
                                            <li>
                                                <div class="icon">
                                                    <i class="flaticon-mortarboard"></i>
                                                </div>
                                                <p><span>{{ __('Students') }}:
                                                    </span>{{ $course?->enrollments_count }}</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="tab-pane fade" id="dessert-tab-pane" role="tabpanel" aria-labelledby="dessert-tab"
                tabindex="0">
                <div class="row justify-content-center">
                    @foreach ($categoryTwoCourses ?? [] as $course)
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="courses__item-six shine__animate-item">
                                <div class="courses__item-thumb-five shine__animate-link">
                                    <a href="{{ route('course.show', $course->slug) }}"><img
                                            src="{{ asset($course->thumbnail) }}" alt="{{ $course->title }}"></a>
                                </div>
                                <div class="courses__item-content-five">
                                    <ul class="courses__item-meta list-wrap">
                                        <li class="courses__review courses__review-two">
                                            <div class="rating">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= floor($course->avg_rating))
                                                        <i class="fas fa-solid fa-star"></i>
                                                    @elseif ($i - 0.5 <= $course->avg_rating)
                                                        <i class="fas fa-solid fa-star-half-alt"></i>
                                                    @else
                                                        <i class="far fa-star"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <span>({{ number_format($course->avg_rating, 1) ?? 0 }})</span>
                                        </li>
                                        @if ($course->price == 0)
                                            <li class="price">{{ __('Free') }}</li>
                                        @elseif ($course->price > 0 && $course->discount > 0)
                                            <li class="price">{{ currency($course->discount) }}</li>
                                        @else
                                            <li class="price">{{ currency($course->price) }}</li>
                                        @endif
                                    </ul>
                                    <h2 class="title"><a
                                            href="{{ route('course.show', $course->slug) }}">{{ truncate($course->title, 38) }}</a>
                                    </h2>
                                    <p>{{ truncate($course->seo_description, 50) }}</p>
                                    <div class="courses__item-content-bottom-two">
                                        <ul class="list-wrap">
                                            <li>
                                                <div class="icon">
                                                    <i class="flaticon-book"></i>
                                                </div>
                                                <p><span>{{ __('Lessons') }}:</span>{{ $course?->lessons_count }}</p>
                                            </li>
                                            <li>
                                                <div class="icon">
                                                    <i class="flaticon-mortarboard"></i>
                                                </div>
                                                <p><span>{{ __('Students') }}:
                                                    </span>{{ $course?->enrollments_count }}</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="tab-pane fade" id="italian-tab-pane" role="tabpanel" aria-labelledby="italian-tab"
                tabindex="0">
                <div class="row justify-content-center">
                    @foreach ($categoryThreeCourses ?? [] as $course)
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="courses__item-six shine__animate-item">
                                <div class="courses__item-thumb-five shine__animate-link">
                                    <a href="{{ route('course.show', $course->slug) }}"><img
                                            src="{{ asset($course->thumbnail) }}" alt="{{ $course->title }}"></a>
                                </div>
                                <div class="courses__item-content-five">
                                    <ul class="courses__item-meta list-wrap">
                                        <li class="courses__review courses__review-two">
                                            <div class="rating">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= floor($course->avg_rating))
                                                        <i class="fas fa-solid fa-star"></i>
                                                    @elseif ($i - 0.5 <= $course->avg_rating)
                                                        <i class="fas fa-solid fa-star-half-alt"></i>
                                                    @else
                                                        <i class="far fa-star"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <span>({{ number_format($course->avg_rating, 1) ?? 0 }})</span>
                                        </li>
                                        @if ($course->price == 0)
                                            <li class="price">{{ __('Free') }}</li>
                                        @elseif ($course->price > 0 && $course->discount > 0)
                                            <li class="price">{{ currency($course->discount) }}</li>
                                        @else
                                            <li class="price">{{ currency($course->price) }}</li>
                                        @endif
                                    </ul>
                                    <h2 class="title"><a
                                            href="{{ route('course.show', $course->slug) }}">{{ truncate($course->title, 38) }}</a>
                                    </h2>
                                    <p>{{ truncate($course->seo_description, 50) }}</p>
                                    <div class="courses__item-content-bottom-two">
                                        <ul class="list-wrap">
                                            <li>
                                                <div class="icon">
                                                    <i class="flaticon-book"></i>
                                                </div>
                                                <p><span>{{ __('Lessons') }}:</span>{{ $course?->lessons_count }}</p>
                                            </li>
                                            <li>
                                                <div class="icon">
                                                    <i class="flaticon-mortarboard"></i>
                                                </div>
                                                <p><span>{{ __('Students') }}:
                                                    </span>{{ $course?->enrollments_count }}</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="tab-pane fade" id="pizza-tab-pane" role="tabpanel" aria-labelledby="pizza-tab"
                tabindex="0">
                <div class="row justify-content-center">
                    @foreach ($categoryFourCourses ?? [] as $course)
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="courses__item-six shine__animate-item">
                                <div class="courses__item-thumb-five shine__animate-link">
                                    <a href="{{ route('course.show', $course->slug) }}"><img
                                            src="{{ asset($course->thumbnail) }}" alt="{{ $course->title }}"></a>
                                </div>
                                <div class="courses__item-content-five">
                                    <ul class="courses__item-meta list-wrap">
                                        <li class="courses__review courses__review-two">
                                            <div class="rating">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= floor($course->avg_rating))
                                                        <i class="fas fa-solid fa-star"></i>
                                                    @elseif ($i - 0.5 <= $course->avg_rating)
                                                        <i class="fas fa-solid fa-star-half-alt"></i>
                                                    @else
                                                        <i class="far fa-star"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <span>({{ number_format($course->avg_rating, 1) ?? 0 }})</span>
                                        </li>
                                        @if ($course->price == 0)
                                            <li class="price">{{ __('Free') }}</li>
                                        @elseif ($course->price > 0 && $course->discount > 0)
                                            <li class="price">{{ currency($course->discount) }}</li>
                                        @else
                                            <li class="price">{{ currency($course->price) }}</li>
                                        @endif
                                    </ul>
                                    <h2 class="title"><a
                                            href="{{ route('course.show', $course->slug) }}">{{ truncate($course->title, 38) }}</a>
                                    </h2>
                                    <p>{{ truncate($course->seo_description, 50) }}</p>
                                    <div class="courses__item-content-bottom-two">
                                        <ul class="list-wrap">
                                            <li>
                                                <div class="icon">
                                                    <i class="flaticon-book"></i>
                                                </div>
                                                <p><span>{{ __('Lessons') }}:</span>{{ $course?->lessons_count }}</p>
                                            </li>
                                            <li>
                                                <div class="icon">
                                                    <i class="flaticon-mortarboard"></i>
                                                </div>
                                                <p><span>{{ __('Students') }}:
                                                    </span>{{ $course?->enrollments_count }}</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="tab-pane fade" id="development-tab-pane" role="tabpanel" aria-labelledby="development-tab"
                tabindex="0">
                <div class="row justify-content-center">
                    @foreach ($categoryFiveCourses ?? [] as $course)
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="courses__item-six shine__animate-item">
                                <div class="courses__item-thumb-five shine__animate-link">
                                    <a href="{{ route('course.show', $course->slug) }}"><img
                                            src="{{ asset($course->thumbnail) }}" alt="{{ $course->title }}"></a>
                                </div>
                                <div class="courses__item-content-five">
                                    <ul class="courses__item-meta list-wrap">
                                        <li class="courses__review courses__review-two">
                                            <div class="rating">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= floor($course->avg_rating))
                                                        <i class="fas fa-solid fa-star"></i>
                                                    @elseif ($i - 0.5 <= $course->avg_rating)
                                                        <i class="fas fa-solid fa-star-half-alt"></i>
                                                    @else
                                                        <i class="far fa-star"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <span>({{ number_format($course->avg_rating, 1) ?? 0 }})</span>
                                        </li>
                                        @if ($course->price == 0)
                                            <li class="price">{{ __('Free') }}</li>
                                        @elseif ($course->price > 0 && $course->discount > 0)
                                            <li class="price">{{ currency($course->discount) }}</li>
                                        @else
                                            <li class="price">{{ currency($course->price) }}</li>
                                        @endif
                                    </ul>
                                    <h2 class="title"><a
                                            href="{{ route('course.show', $course->slug) }}">{{ truncate($course->title, 38) }}</a>
                                    </h2>
                                    <p>{{ truncate($course->seo_description, 50) }}</p>
                                    <div class="courses__item-content-bottom-two">
                                        <ul class="list-wrap">
                                            <li>
                                                <div class="icon">
                                                    <i class="flaticon-book"></i>
                                                </div>
                                                <p><span>{{ __('Lessons') }}:</span>{{ $course?->lessons_count }}</p>
                                            </li>
                                            <li>
                                                <div class="icon">
                                                    <i class="flaticon-mortarboard"></i>
                                                </div>
                                                <p><span>{{ __('Students') }}:
                                                    </span>{{ $course?->enrollments_count }}</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="courses__shape-wrap-three">
        <img src="{{ asset('frontend/img/courses/h5_courses_shape01.svg') }}" alt="shape" data-aos="fade-right"
            data-aos-delay="400">
        <img src="{{ asset('frontend/img/courses/h5_courses_shape02.svg') }}" alt="shape"
            data-aos="fade-up-right" data-aos-delay="400">
        <img src="{{ asset('frontend/img/courses/h5_courses_shape03.svg') }}" alt="shape" class="alltuchtopdown">
        <img src="{{ asset('frontend/img/courses/h5_courses_shape04.svg') }}" alt="shape" data-aos="fade-up-left"
            data-aos-delay="400">
    </div>
</section>
