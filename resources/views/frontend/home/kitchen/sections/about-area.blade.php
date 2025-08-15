<section class="about-area-six about__bg" data-background="{{ asset('frontend/img/bg/h8_about_bg.jpg') }}">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-6 col-md-10">
                <div class="about__images-six">
                    <img src="{{ asset($aboutSection?->global_content?->image) }}" alt="img">
                    <img src="{{ asset($aboutSection?->global_content?->image_two) }}" alt="img" data-aos="fade-left"
                        data-aos-delay="400">
                    <div class="about__success" data-aos="fade-up" data-aos-delay="400">
                        <div class="icon">
                            <img src="{{ asset($aboutSection?->global_content?->image_three) }}" alt="shape">
                        </div>
                        <div class="content">
                            <h2 class="title">{{$aboutSection?->global_content?->course_success}}%</h2>
                            <span>{{__("Course Success")}}</span>
                        </div>
                    </div>
                    <div class="shape">
                        <img src="{{ asset('frontend/img/others/h8_about_img_shape.svg') }}" alt="shape" class="alltuchtopdown">
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about__content-six">
                    <div class="section__title mb-15">
                        <span class="sub-title">{{ $aboutSection?->content?->short_title }}</span>
                        <h2 class="title">{!! clean(processText($aboutSection?->content?->title)) !!}</h2>
                    </div>
                    {!! clean(processText($aboutSection?->content?->description)) !!}
                    <a href="{{ $aboutSection?->global_content?->button_url }}" class="btn arrow-btn btn-four">{{ $aboutSection?->content?->button_text }} <img
                            src="{{ asset('frontend/img/icons/right_arrow.svg') }}" alt="" class="injectable"></a>
                </div>
            </div>
        </div>
    </div>
    <div class="about__shape-wrap">
        <img src="{{ asset('frontend/img/others/h8_about_shape01.svg') }}" alt="shape" data-aos="fade-down-right"
            data-aos-delay="400">
        <img src="{{ asset('frontend/img/others/h8_about_shape02.svg') }}" alt="shape" data-aos="fade-up-left"
            data-aos-delay="400">
    </div>
</section>