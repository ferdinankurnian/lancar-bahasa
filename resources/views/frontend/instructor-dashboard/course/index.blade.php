@extends('frontend.instructor-dashboard.layouts.master')

@section('dashboard-contents')
    <div class="dashboard__content-wrap pb-0">
        <div class="dashboard__content-title d-flex flex-wrap justify-content-between">
            <h4 class="title">{{ __('All Courses') }}</h4>
            <a href="{{ route('instructor.courses.create') }}"
                class="btn btn-primary btn-hight-basic">{{ __('Add Course') }}</a>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="dashboard__review-table dash_instructor_course">
                    <div class="row">
                        <div class="col-12">
                            <div class="tab-content" id="courseTabContent">
                                @forelse($courses as $course)
                                    <div class="tab-pane fade show active" id="all-tab-pane" role="tabpanel"
                                        aria-labelledby="all-tab" tabindex="0">
                                        <div class="dashboard-courses-active dashboard_courses">
                                            <div class="courses__item courses__item-two shine__animate-item">
                                                <div class="row align-items-center">
                                                    <div class="col-xl-5">
                                                        <div class="courses__item-thumb courses__item-thumb-two">
                                                            <a href="{{ route('instructor.courses.edit-view', $course->id) }}"
                                                                class="shine__animate-link">
                                                                <img src="{{ asset($course->thumbnail) }}" alt="img">
                                                            </a>
                                                            @if ($course->is_approved == 'pending')
                                                                <p class="bg-warning">{{ __('Pending') }}</p>
                                                            @elseif($course->is_approved == 'rejected')
                                                                <p>{{ __('Rejected') }}</p>
                                                            @else
                                                                @if ($course->status == 'active')
                                                                    <p class="bg-success">{{ __('Published') }}</p>
                                                                @elseif($course->status == 'inactive')
                                                                    <p class="bg-danger">{{ __('Unpublished') }}</p>
                                                                @else
                                                                    <p class="bg-danger">{{ __('Draft') }}</p>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-7">
                                                        <div class="courses__item-content courses__item-content-two">
                                                            <ul class="courses__item-meta list-wrap">
                                                                @if (@$course->category->translation->name)
                                                                    <li class="courses__item-tag">
                                                                        <a
                                                                            href="javascript:;">{{ @$course->category->translation->name }}</a>
                                                                    </li>
                                                                @endif
                                                            </ul>
                                                            <ul class="edit_btn d-flex flex-wrap">
                                                                <li>
                                                                    <a
                                                                        href="{{ route('instructor.courses.edit-view', $course->id) }}">
                                                                        <i class="far fa-edit"></i>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a type="button" class="course-delete-request"
                                                                        href="{{ route('instructor.course.delete-request.show', $course->id) }}">
                                                                        <i class="fas fa-trash-alt"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>

                                                            <h5 class="title"><a
                                                                    href="{{ route('instructor.courses.edit-view', $course->id) }}">{{ $course->title }}</a>
                                                            </h5>
                                                            <div class="courses__item-content-bottom">
                                                                <div class="author-two">
                                                                    <a href="javascript:;"><img
                                                                            src="{{ asset($course->instructor->image) }}"
                                                                            alt="img">{{ $course->instructor->name }}</a>
                                                                </div>
                                                                <div class="avg-rating">
                                                                    <i class="fas fa-star"></i>
                                                                    {{ number_format($course->reviews()->avg('rating') ?? 0, 1) }}
                                                                </div>
                                                            </div>

                                                        </div>

                                                        @php
                                                            $courseLectureCount = App\Models\CourseChapterItem::whereHas(
                                                                'chapter',
                                                                function ($q) use ($course) {
                                                                    $q->where('course_id', $course->id);
                                                                },
                                                            )->count();

                                                        @endphp

                                                        <div class="courses__item-bottom-two">
                                                            <ul class="list-wrap">
                                                                <li><i class="flaticon-book"></i>{{ $courseLectureCount }}
                                                                </li>
                                                                <li><i
                                                                        class="flaticon-clock"></i>{{ minutesToHours($course->duration) }}
                                                                </li>
                                                                <li><i
                                                                        class="flaticon-mortarboard"></i>{{ $course->enrollments()->count() }}
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <div class="text-center">
                                            <h6>{{ __('No Course Found') }}</h6>
                                        </div>
                                    </div>
                                @endforelse
                                {{ $courses->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
