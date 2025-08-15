<section class="newsletter__area-three">
    <div class="container">
        <div class="newsletter__inner-wrap newsletter__inner-wrap-two">
            <h2 class="title">{{__('Start today and get certified in Fundamentals of Business Core')}}</h2>
            <form action="{{route('newsletter-request')}}" method="post" class="newsletter__form-two newsletter">
                @csrf
                  <input type="email" placeholder="{{ __('Type your email') }}" name="email">
                  <button type="submit" class="btn arrow-btn">{{ __('Subscribe Now') }}</button>
              </form>
            <img src="{{asset('frontend/img/others/h7_newsletter_shape01.svg')}}" alt="shape" data-aos="fade-down-right"
                data-aos-delay="400" class="shape shape-one">
            <img src="{{asset('frontend/img/others/h7_newsletter_shape02.svg')}}" alt="shape" class="shape shape-two rotateme">
        </div>
    </div>
</section>