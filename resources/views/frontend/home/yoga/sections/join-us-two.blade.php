<section class="cta__area-two cta__bg-two" data-background="{{ asset('frontend/img/bg/h4_cta_bg.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="cta__img">
                    <img src="{{ asset($bannerSection?->global_content?->student_image) }}" alt="img">
                    <div class="shape">
                        <img src="{{ asset('frontend/img/others/h4_cta_shape.svg') }}" alt="shape" class="rotateme">
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="cta__content-two">
                    <h2 class="title">{{__('My course helps to become Balance in life')}}</h2>
                    <div class="cta__btn">
                        <a href="{{ route('register') }}" class="btn">{{__('Check Available Seat')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="cta__shape">
        <img src="{{ asset('frontend/img/others/h4_cta_shape02.svg') }}" alt="shape" data-aos="fade-left" data-aos-delay="400">
    </div>
</section>