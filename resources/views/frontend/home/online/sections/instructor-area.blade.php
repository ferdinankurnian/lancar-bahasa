<section class="instructor__area-three instructor__bg" data-background="{{ asset('frontend/img/bg/instructor_bg.jpg') }}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8">
                <div class="section__title text-center mb-40">
                    <span class="sub-title">{{ __('Skilled Introduce') }}</span>
                    <h2 class="title">{{ __('Top Class & Professional Instructors in One Place') }}</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-8">
                <div class="swiper-container instructor-active">
                    <div class="swiper-wrapper">
                        @foreach ($selectedInstructors as $instructor)
                            <div class="swiper-slide">
                                <div class="instructor__item-three">
                                    <div class="instructor__thumb-three">
                                        <img src="{{ asset($instructor->image) }}" alt="img">
                                        <div class="shape-one">
                                            <img src="{{ asset('frontend/img/instructor/h2_instructor_img_shape01.svg') }}"
                                                alt="img" class="injectable">
                                        </div>
                                    </div>
                                    <div class="instructor__content-three">
                                        @php
                                            $rating = round($instructor->courses->avg('avg_rating'));
                                        @endphp
                                        <div class="ratting-wrap">
                                            <div class="ratting">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $rating)
                                                        <i class="fas fa-star"></i>
                                                    @else
                                                        <i class="far fa-star"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <span>({{ number_format($instructor->courses->avg('avg_rating'), 1) }}
                                                {{ __('Ratings') }})</span>
                                        </div>
                                        <h2 class="title">{{ $instructor->name }}</h2>
                                        <span class="designation">{{ $instructor->job_title }}</span>
                                        <p>{{ $instructor->short_bio }}</p>
                                        <div class="instructor__social">
                                            <ul class="list-wrap">
                                                @if ($instructor->facebook)
                                                    <li><a href="{{ $instructor->facebook }}"><i
                                                                class="fab fa-facebook-f"></i></a></li>
                                                @endif
                                                @if ($instructor->twitter)
                                                    <li><a href="{{ $instructor->twitter }}"><i
                                                                class="fab fa-twitter"></i></a></li>
                                                @endif
                                                @if ($instructor->linkedin)
                                                    <li><a href="{{ $instructor->linkedin }}"><i
                                                                class="fab fa-linkedin"></i></a></li>
                                                @endif
                                                @if ($instructor->github)
                                                    <li><a href="{{ $instructor->github }}"><i
                                                                class="fab fa-github"></i></a></li>
                                                @endif
                                            </ul>
                                        </div>
                                        <div class="tg-button-wrap">
                                            <a href="{{ route('instructor-details', $instructor->id) }}"
                                                class="btn arrow-btn">{{ __('Join My Class') }} <img
                                                    src="{{ asset('frontend/img/icons/right_arrow.svg') }}"
                                                    alt="img" class="injectable"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-9">
                <div class="instructor-slider-dot">
                    <div class="swiper instructor-nav">
                        <div class="swiper-wrapper">
                            @foreach ($selectedInstructors as $instructor)
                                <div class="swiper-slide">
                                    <button><img src="{{ asset($instructor->image) }}" alt="img"></button>
                                </div>
                            @endforeach

                        </div>
                    </div>
                    <div class="instructor__nav-two">
                        <div class="instructor-button-prev"><i class="flaticon-arrow-right"></i></div>
                        <div class="instructor-button-next"><i class="flaticon-arrow-right"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="instructor__shape">
        <img src="{{ asset('frontend/img/instructor/h2_instructor_shape.png') }}" alt="img"
            class="alltuchtopdown">
    </div>
</section>
