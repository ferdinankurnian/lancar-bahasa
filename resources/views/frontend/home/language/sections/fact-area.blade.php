<section class="fact__area-two section-pb-140">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="fact__inner-wrap-two">
                    <div class="section__title white-title mb-30">
                        <h2 class="title">{!! clean(processText($counter?->content?->title)) !!}</h2>
                    </div>
                    <div class="fact__item-wrap">
                        <div class="fact__item">
                            <h2 class="count"><span class="odometer" data-count="{{ $counter?->global_content?->total_student_count }}"></span>+</h2>
                            <p>{{ __('Active Students') }}</p>
                        </div>
                        <div class="fact__item">
                            <h2 class="count"><span class="odometer" data-count="{{ $counter?->global_content?->total_instructor_count }}"></span>+</h2>
                            <p>{{ __('Best Professors') }}</p>
                        </div>
                    </div>
                    <div class="fact__img-wrap tg-svg">
                        <img src="{{ asset($counter?->global_content?->image) }}" alt="img">
                        <div class="shape-one">
                            <img src="{{ asset('frontend/img/others/fact_shape01.svg') }}" alt="img" class="injectable">
                        </div>
                        <div class="shape-two">
                            <span class="svg-icon" id="fact-btn" data-svg-icon="{{ asset('frontend/img/others/fact_shape02.svg') }}"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>