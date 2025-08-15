@forelse ($courses as $course)
    <div class="col-xxl-4 col-md-6 col-lg-6 col-xl-6">
        <div class="courses__item shine__animate-item">
            <div class="courses__item-thumb">
                <a href="{{ route('course.show', $course->slug) }}" class="shine__animate-link">
                    <img src="{{ asset($course->thumbnail) }}" alt="img">
                </a>
            </div>
            <div class="courses__item-content">
                <ul class="courses__item-meta list-wrap">
                    <li class="courses__item-tag">
                        <a
                            href="{{ route('courses', ['category' => $course->category->id]) }}">{{ $course->category->translation->name }}</a>
                    </li>
                    <li class="avg-rating"><i class="fas fa-star"></i>
                        {{ number_format($course->reviews()->avg('rating'), 1) ?? 0 }}</li>
                </ul>
                <h5 class="title"><a
                        href="{{ route('course.show', $course->slug) }}">{{ truncate($course->title, 50) }}</a></h5>
                <p class="author">{{ __('By') }} <a
                        href="{{ route('instructor-details', ['id' => $course->instructor->id, 'slug' => Str::slug($course->instructor->name)]) }}">{{ $course->instructor->name }}</a>
                </p>
                <div class="courses__item-bottom">
                    @if (in_array($course->id, session('enrollments') ?? []))
                        <div class="button">
                            <a href="{{ route('student.enrolled-courses') }}" class="already-enrolled-btn"
                                data-id="">
                                <span class="text">{{ __('Enrolled') }}</span>
                                <i class="flaticon-arrow-right"></i>
                            </a>
                        </div>
                    @elseif ($course->enrollments->count() >= $course->capacity && $course->capacity != null)
                        <div class="button">
                            <a href="javascript:;" class="" data-id="{{ $course->id }}">
                                <span class="text">{{ __('Booked') }}</span>
                                <i class="flaticon-arrow-right"></i>
                            </a>
                        </div>
                    @else
                        <div class="button">
                            <a href="javascript:;" class="add-to-cart" data-id="{{ $course->id }}">
                                <span class="text">{{ __('Add To Cart') }}</span>
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
@empty
    <div class="w-100">
        <h6 class="text-center">{{ __('No Course Found!') }}</h6>
    </div>
@endforelse
