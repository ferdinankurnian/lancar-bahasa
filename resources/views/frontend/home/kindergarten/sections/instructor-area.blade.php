<section class="instructor__area-six section-pb-110">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-7">
                <div class="section__title text-center mb-50">
                    <span class="sub-title">{{ __('Our Teacher') }}</span>
                    <h2 class="title">{!! clean(processText($featuredInstructorSection?->translation?->title)) !!}</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            @foreach ($selectedInstructors as $index => $instructor)
                @if ($index < 4)
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <div class="instructor__item-five">
                            <div class="instructor__thumb-five">
                                <a href="{{ route('instructor-details', $instructor->id) }}"><img
                                        src="{{ asset($instructor->image) }}" alt="{{ $instructor->name }}"></a>
                                <div class="instructor__social-two">
                                    <ul class="list-wrap">
                                        @if ($instructor->facebook)
                                            <li><a href="{{ $instructor->facebook }}"><i
                                                        class="fab fa-facebook-f"></i></a></li>
                                        @endif
                                        @if ($instructor->twitter)
                                            <li><a href="{{ $instructor->twitter }}"><i class="fab fa-twitter"></i></a>
                                            </li>
                                        @endif
                                        @if ($instructor->linkedin)
                                            <li><a href="{{ $instructor->linkedin }}"><i
                                                        class="fab fa-linkedin"></i></a></li>
                                        @endif
                                        @if ($instructor->github)
                                            <li><a href="{{ $instructor->github }}"><i class="fab fa-github"></i></a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="instructor__content-five">
                                <h2 class="title"><a
                                        href="{{ route('instructor-details', $instructor->id) }}l">{{ $instructor->name }}</a>
                                </h2>
                                <span>{{ $instructor->job_title }}</span>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
    <div class="instructor__shape-two">
        <img src="{{ asset('frontend/img/instructor/h5_instructor_img_shape01.svg') }}" alt="shape"
            class="rotateme">
        <img src="{{ asset('frontend/img/instructor/h5_instructor_img_shape02.svg') }}" alt="shape"
            class="alltuchtopdown">
    </div>
</section>
