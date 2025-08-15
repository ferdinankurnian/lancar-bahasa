<section class="fact__area-three fact__bg" data-background="{{asset('frontend/img/bg/fact_bg.jpg')}}">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5">
                <div class="fact__content-wrap">
                    <h2 class="title">{!! clean(processText($counter?->content?->title)) !!}</h2>
                    <p>{{$counter?->content?->description}}</p>
                    <a href="{{route('contact.index')}}" class="btn arrow-btn">{{__('Take a Tour')}} <img src="{{asset('frontend/img/icons/right_arrow.svg')}}" alt="" class="injectable"></a>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="fact__item-wrap-two">
                    <div class="row justify-content-center">
                        <div class="col-md-4 col-sm-6">
                            <div class="fact__item fact__item-two">
                                <h2 class="count"><span class="odometer" data-count="{{ $counter?->global_content?->total_student_count }}"></span>+</h2>
                                <p>{{ __('Active Students') }}</p>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="fact__item fact__item-two">
                                <h2 class="count"><span class="odometer" data-count="{{ $counter?->global_content?->total_instructor_count }}"></span>+</h2>
                                <p>{{ __('Best Professors') }}</p>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="fact__item fact__item-two">
                                <h2 class="count"><span class="odometer" data-count="{{ $counter?->global_content?->total_courses_count }}"></span>+</h2>
                                <p>{{ __('Faculty Courses') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="fact__shape-wrap">
        <img src="{{asset('frontend/img/others/h3_fact_shape01.svg')}}" alt="shape" class="alltuchtopdown">
        <img src="{{asset('frontend/img/others/h3_fact_shape02.svg')}}" alt="shape" class="rotateme">
    </div>
</section>