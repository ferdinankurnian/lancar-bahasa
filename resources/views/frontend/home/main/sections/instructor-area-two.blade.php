<section class="instructor__area-two">
  <div class="container">
      <div class="instructor__item-wrap-two">
          <div class="row">
              <div class="col-xl-6">
                  <div class="instructor__item-two tg-svg">
                      <div class="instructor__thumb-two">
                          <img src="{{ asset($bannerSection?->global_content?->instructor_image) }}" alt="img">
                          <div class="shape-one">
                              <img src="{{ asset('frontend/img/instructor/instructor_shape01.svg') }}" alt="img"
                                  class="injectable">
                          </div>
                          <div class="shape-two">
                              <span class="svg-icon" id="instructor-svg"
                                  data-svg-icon="{{ asset('frontend/img/instructor/instructor_shape02.svg') }}"></span>
                          </div>
                      </div>
                      <div class="instructor__content-two">
                          <h3 class="title"><a href="{{ route('register') }}">{{ __('Become a Instructor') }}</a></h3>
                          <p>{{ __('Join our team to inspire students, share your knowledge, and shape the future') }}.</p>
                          <div class="tg-button-wrap">
                              <a href="{{ route('register') }}" class="btn arrow-btn">{{ __('Join Now') }} <img
                                      src="{{ asset('frontend/img/icons/right_arrow.svg') }}" alt="img"
                                      class="injectable"></a>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-xl-6">
                  <div class="instructor__item-two tg-svg">
                      <div class="instructor__thumb-two">
                          <img src="{{ asset($bannerSection?->global_content?->student_image) }}" alt="img">
                          <div class="shape-one">
                              <img src="{{ asset('frontend/img/instructor/instructor_shape01.svg') }}" alt="img"
                                  class="injectable">
                          </div>
                          <div class="shape-two">
                              <span class="svg-icon" id="instructor-svg-two"
                                  data-svg-icon="{{ asset('frontend/img/instructor/instructor_shape02.svg') }}"></span>
                          </div>
                      </div>
                      <div class="instructor__content-two">
                          <h3 class="title"><a href="{{ route('register') }}">{{ __('Become a Student') }}</a></h3>
                          <p>{{ __('Unlock your potential by joining our vibrant learning community') }}.</p>
                          </p>
                          <div class="tg-button-wrap">
                              <a href="{{ route('register') }}" class="btn arrow-btn">{{ __('Join Now') }} <img
                                      src="{{ asset('frontend/img/icons/right_arrow.svg') }}" alt="img"
                                      class="injectable"></a>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</section>