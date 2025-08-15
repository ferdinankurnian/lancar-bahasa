<section class="choose__area-two yoga_why_choose section-py-140 choose__bg"
    data-background="{{ asset('frontend/img/bg/h4_choose_bg.jpg') }}">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-6 col-md-10">
                <div class="choose__img-two">
                    <img src="{{ asset($aboutSection?->global_content?->image) }}" alt="img">
                    <div class="circle__text-wrap">
                        <div class="icon">
                            <img src="{{ asset('frontend/img/icons/circle_icon.svg') }}" alt=""
                                class="injectable">
                        </div>
                        <div class="content">
                            <h6 class="circle rotateme">{{ __('YoGa') }} . {{ __('Expert') }} . {{ __('Coach') }} . {{ __('Since 1996') }} .</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="choose__content-two">
                    <div class="section__title mb-20">
                        <span class="sub-title">{{ $aboutSection?->content?->short_title }}</span>
                        <h2 class="title-two">{!! clean(processText($aboutSection?->content?->title)) !!}</h2>
                    </div>
                    {!! clean(processText($aboutSection?->content?->description)) !!}
                    <div class="choose__content-inner">
                        <div class="row align-items-center gutter-20">
                            <div class="col-sm-5 order-0 order-sm-2">
                                <div class="choose__content-inner-img">
                                    <img src="{{ asset($aboutSection?->global_content?->image_two) }}" alt="img">
                                </div>
                            </div>
                            <a href="{{ $aboutSection?->global_content?->button_url }}"
                                class="btn arrow-btn btn-four">{{ $aboutSection?->content?->button_text }} <img
                                    src="{{ asset('frontend/img/icons/right_arrow.svg') }}" alt=""
                                    class="injectable"></a>
                        </div>
                    </div>
                </div>
                <div class="shape">
                    <img src="{{ asset('frontend/img/others/h4_choose_shape.svg') }}" alt="shape" class="rotateme">
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
