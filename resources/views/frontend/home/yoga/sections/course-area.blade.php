<section class="courses-area-three youga_course_area section-pt-140 section-pb-110 courses__bg-two"
    data-background="{{ asset('frontend/img/bg/h4_courses_bg.jpg') }}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xxl-8 col-lg-10 col-md-12">
                <div class="section__title text-center mb-50">
                    <span class="sub-title">{{ __('Top Class Courses') }}</span>
                    <h2 class="title">{{ __('My special yoga classes to improve yourself') }}</h2>
                </div>
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
                <div class="row gutter-24 justify-content-center">
                    @foreach ($allCourses ?? [] as $course)
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="courses__item-five shine__animate-item">
                                <div class="courses__item-thumb-four shine__animate-link">
                                    <a href="{{ route('course.show', $course->slug) }}"><img
                                            src="{{ asset($course->thumbnail) }}" alt="img"></a>
                                    @if ($course->price == 0)
                                        <span class="courses__price-two">{{ __('Free') }}</span>
                                    @elseif ($course->price > 0 && $course->discount > 0)
                                        <span class="courses__price-two">{{ currency($course->discount) }}</span>
                                    @else
                                        <span class="courses__price-two">{{ currency($course->price) }}</span>
                                    @endif
                                </div>
                                <div class="courses__item-content-four">
                                    <ul class="courses__item-meta list-wrap">
                                        <li class="courses__item-tag courses__item-tag-two">
                                            <a
                                                href="{{ route('courses', ['category' => $course->category->id]) }}">{{ $course->category?->name }}</a>
                                        </li>
                                        <li class="avg-rating"><i class="fas fa-star"></i>
                                            ({{ number_format($course->avg_rating, 1) ?? 0 }}
                                            {{ __('Reviews') }})
                                        </li>
                                    </ul>
                                    <h2 class="title"><a
                                            href="{{ route('course.show', $course->slug) }}">{{ truncate($course->title, 50) }}</a>
                                    </h2>
                                    <div class="courses__item-bottom-three">
                                        <ul class="list-wrap">
                                            <li><i class="flaticon-book"></i>{{ __('Lessons') }}
                                                {{ $course?->lessons_count }}</li>
                                            <li><i class="flaticon-mortarboard"></i>{{ __('Students') }}
                                                {{ $course?->enrollments_count }}</li>
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
                            <div class="courses__item-five shine__animate-item">
                                <div class="courses__item-thumb-four shine__animate-link">
                                    <a href="{{ route('course.show', $course->slug) }}"><img
                                            src="{{ asset($course->thumbnail) }}" alt="img"></a>
                                    @if ($course->price == 0)
                                        <span class="courses__price-two">{{ __('Free') }}</span>
                                    @elseif ($course->price > 0 && $course->discount > 0)
                                        <span class="courses__price-two">{{ currency($course->discount) }}</span>
                                    @else
                                        <span class="courses__price-two">{{ currency($course->price) }}</span>
                                    @endif
                                </div>
                                <div class="courses__item-content-four">
                                    <ul class="courses__item-meta list-wrap">
                                        <li class="courses__item-tag courses__item-tag-two">
                                            <a
                                                href="{{ route('courses', ['category' => $course->category->id]) }}">{{ $course->category?->name }}</a>
                                        </li>
                                        <li class="avg-rating"><i class="fas fa-star"></i>
                                            ({{ number_format($course->avg_rating, 1) ?? 0 }}
                                            {{ __('Reviews') }})
                                        </li>
                                    </ul>
                                    <h2 class="title"><a
                                            href="{{ route('course.show', $course->slug) }}">{{ truncate($course->title, 50) }}</a>
                                    </h2>
                                    <div class="courses__item-bottom-three">
                                        <ul class="list-wrap">
                                            <li><i class="flaticon-book"></i>{{ __('Lessons') }}
                                                {{ $course?->lessons_count }}</li>
                                            <li><i class="flaticon-mortarboard"></i>{{ __('Students') }}
                                                {{ $course?->enrollments_count }}</li>
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
                            <div class="courses__item-five shine__animate-item">
                                <div class="courses__item-thumb-four shine__animate-link">
                                    <a href="{{ route('course.show', $course->slug) }}"><img
                                            src="{{ asset($course->thumbnail) }}" alt="img"></a>
                                    @if ($course->price == 0)
                                        <span class="courses__price-two">{{ __('Free') }}</span>
                                    @elseif ($course->price > 0 && $course->discount > 0)
                                        <span class="courses__price-two">{{ currency($course->discount) }}</span>
                                    @else
                                        <span class="courses__price-two">{{ currency($course->price) }}</span>
                                    @endif
                                </div>
                                <div class="courses__item-content-four">
                                    <ul class="courses__item-meta list-wrap">
                                        <li class="courses__item-tag courses__item-tag-two">
                                            <a
                                                href="{{ route('courses', ['category' => $course->category->id]) }}">{{ $course->category?->name }}</a>
                                        </li>
                                        <li class="avg-rating"><i class="fas fa-star"></i>
                                            ({{ number_format($course->avg_rating, 1) ?? 0 }}
                                            {{ __('Reviews') }})
                                        </li>
                                    </ul>
                                    <h2 class="title"><a
                                            href="{{ route('course.show', $course->slug) }}">{{ truncate($course->title, 50) }}</a>
                                    </h2>
                                    <div class="courses__item-bottom-three">
                                        <ul class="list-wrap">
                                            <li><i class="flaticon-book"></i>{{ __('Lessons') }}
                                                {{ $course?->lessons_count }}</li>
                                            <li><i class="flaticon-mortarboard"></i>{{ __('Students') }}
                                                {{ $course?->enrollments_count }}</li>
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
                            <div class="courses__item-five shine__animate-item">
                                <div class="courses__item-thumb-four shine__animate-link">
                                    <a href="{{ route('course.show', $course->slug) }}"><img
                                            src="{{ asset($course->thumbnail) }}" alt="img"></a>
                                    @if ($course->price == 0)
                                        <span class="courses__price-two">{{ __('Free') }}</span>
                                    @elseif ($course->price > 0 && $course->discount > 0)
                                        <span class="courses__price-two">{{ currency($course->discount) }}</span>
                                    @else
                                        <span class="courses__price-two">{{ currency($course->price) }}</span>
                                    @endif
                                </div>
                                <div class="courses__item-content-four">
                                    <ul class="courses__item-meta list-wrap">
                                        <li class="courses__item-tag courses__item-tag-two">
                                            <a
                                                href="{{ route('courses', ['category' => $course->category->id]) }}">{{ $course->category?->name }}</a>
                                        </li>
                                        <li class="avg-rating"><i class="fas fa-star"></i>
                                            ({{ number_format($course->avg_rating, 1) ?? 0 }}
                                            {{ __('Reviews') }})
                                        </li>
                                    </ul>
                                    <h2 class="title"><a
                                            href="{{ route('course.show', $course->slug) }}">{{ truncate($course->title, 50) }}</a>
                                    </h2>
                                    <div class="courses__item-bottom-three">
                                        <ul class="list-wrap">
                                            <li><i class="flaticon-book"></i>{{ __('Lessons') }}
                                                {{ $course?->lessons_count }}</li>
                                            <li><i class="flaticon-mortarboard"></i>{{ __('Students') }}
                                                {{ $course?->enrollments_count }}</li>
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
                            <div class="courses__item-five shine__animate-item">
                                <div class="courses__item-thumb-four shine__animate-link">
                                    <a href="{{ route('course.show', $course->slug) }}"><img
                                            src="{{ asset($course->thumbnail) }}" alt="img"></a>
                                    @if ($course->price == 0)
                                        <span class="courses__price-two">{{ __('Free') }}</span>
                                    @elseif ($course->price > 0 && $course->discount > 0)
                                        <span class="courses__price-two">{{ currency($course->discount) }}</span>
                                    @else
                                        <span class="courses__price-two">{{ currency($course->price) }}</span>
                                    @endif
                                </div>
                                <div class="courses__item-content-four">
                                    <ul class="courses__item-meta list-wrap">
                                        <li class="courses__item-tag courses__item-tag-two">
                                            <a
                                                href="{{ route('courses', ['category' => $course->category->id]) }}">{{ $course->category?->name }}</a>
                                        </li>
                                        <li class="avg-rating"><i class="fas fa-star"></i>
                                            ({{ number_format($course->avg_rating, 1) ?? 0 }}
                                            {{ __('Reviews') }})
                                        </li>
                                    </ul>
                                    <h2 class="title"><a
                                            href="{{ route('course.show', $course->slug) }}">{{ truncate($course->title, 50) }}</a>
                                    </h2>
                                    <div class="courses__item-bottom-three">
                                        <ul class="list-wrap">
                                            <li><i class="flaticon-book"></i>{{ __('Lessons') }}
                                                {{ $course?->lessons_count }}</li>
                                            <li><i class="flaticon-mortarboard"></i>{{ __('Students') }}
                                                {{ $course?->enrollments_count }}</li>
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
                            <div class="courses__item-five shine__animate-item">
                                <div class="courses__item-thumb-four shine__animate-link">
                                    <a href="{{ route('course.show', $course->slug) }}"><img
                                            src="{{ asset($course->thumbnail) }}" alt="img"></a>
                                    @if ($course->price == 0)
                                        <span class="courses__price-two">{{ __('Free') }}</span>
                                    @elseif ($course->price > 0 && $course->discount > 0)
                                        <span class="courses__price-two">{{ currency($course->discount) }}</span>
                                    @else
                                        <span class="courses__price-two">{{ currency($course->price) }}</span>
                                    @endif
                                </div>
                                <div class="courses__item-content-four">
                                    <ul class="courses__item-meta list-wrap">
                                        <li class="courses__item-tag courses__item-tag-two">
                                            <a
                                                href="{{ route('courses', ['category' => $course->category->id]) }}">{{ $course->category?->name }}</a>
                                        </li>
                                        <li class="avg-rating"><i class="fas fa-star"></i>
                                            ({{ number_format($course->avg_rating, 1) ?? 0 }}
                                            {{ __('Reviews') }})
                                        </li>
                                    </ul>
                                    <h2 class="title"><a
                                            href="{{ route('course.show', $course->slug) }}">{{ truncate($course->title, 50) }}</a>
                                    </h2>
                                    <div class="courses__item-bottom-three">
                                        <ul class="list-wrap">
                                            <li><i class="flaticon-book"></i>{{ __('Lessons') }}
                                                {{ $course?->lessons_count }}</li>
                                            <li><i class="flaticon-mortarboard"></i>{{ __('Students') }}
                                                {{ $course?->enrollments_count }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="discover-courses-btn-two text-center mt-30">
                <a href="{{ route('courses') }}" class="btn arrow-btn btn-four">{{ __('Discover All Class') }} <img
                        src="{{ asset('frontend/img/icons/right_arrow.svg') }}" alt=""
                        class="injectable"></a>
            </div>
        </div>
    </div>
    <div class="courses__shape-wrap-two">
        <img src="{{ asset('frontend/img/others/h4_course_shape.svg') }}" alt="shape" class="rotateme">
        <img src="{{ asset('frontend/img/others/h4_course_shape.svg') }}" alt="shape" class="rotateme">
    </div>
</section>
