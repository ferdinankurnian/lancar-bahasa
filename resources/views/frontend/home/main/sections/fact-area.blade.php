<section class="fact__area">
  <div class="container">
      <div class="fact__inner-wrap">
          <div class="row">
              <div class="col-lg-3 col-sm-6">
                  <div class="fact__item">
                      <h2 class="count"><span class="odometer" data-count="{{ $counter?->global_content?->total_student_count }}"></span>+</h2>
                      <p>{{ __('Active Students') }}</p>
                  </div>
              </div>
              <div class="col-lg-3 col-sm-6">
                  <div class="fact__item">
                      <h2 class="count"><span class="odometer" data-count="{{ $counter?->global_content?->total_courses_count }}"></span>+</h2>
                      <p>{{ __('Faculty Courses') }}</p>
                  </div>
              </div>
              <div class="col-lg-3 col-sm-6">
                  <div class="fact__item">
                      <h2 class="count"><span class="odometer" data-count="{{ $counter?->global_content?->total_instructor_count }}"></span>+</h2>
                      <p>{{ __('Best Professors') }}</p>
                  </div>
              </div>
              <div class="col-lg-3 col-sm-6">
                  <div class="fact__item">
                      <h2 class="count"><span class="odometer" data-count="{{ $counter?->global_content?->total_awards_count }}"></span>+</h2>
                      <p>{{ __('Award Achieved') }}</p>
                  </div>
              </div>
          </div>
      </div>
  </div>
</section>