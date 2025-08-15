<section class="newsletter__area">
  <div class="container">
      <div class="row align-items-center">
          <div class="col-lg-4">
              <div class="newsletter__img-wrap">
                  <img src="{{ asset($newsletterSection?->global_content?->image) }}" alt="img">
                  <img src="{{ asset('frontend/img/others/newsletter_shape01.png') }}" alt="img" data-aos="fade-up"
                      data-aos-delay="400">
                  <img src="{{ asset('frontend/img/others/newsletter_shape02.png') }}" alt="img" class="alltuchtopdown">
              </div>
          </div>
          <div class="col-lg-8">
              <div class="newsletter__content">
                  <h2 class="title"><b>{{ __('Want to stay informed about') }}</b> <br> <b>{{ __('new courses and study') }}?</b></h2>
                  <div class="newsletter__form">
                      <form action="{{route('newsletter-request')}}" method="post" class="newsletter">
                        @csrf
                          <input type="email" placeholder="{{ __('Type your email') }}" name="email">
                          <button type="submit" class="btn">{{ __('Subscribe Now') }}</button>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <div class="newsletter__shape">
      <img src="{{ asset('frontend/img/others/newsletter_shape03.png') }}" alt="img" data-aos="fade-left"
          data-aos-delay="400">
  </div>
</section>