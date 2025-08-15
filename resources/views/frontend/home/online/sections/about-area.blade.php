<section class="about-area-two tg-motion-effects section-pb-120">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-6">
                <div class="faq__img-wrap tg-svg">
                    <div class="faq__round-text">
                        <div class="curved-circle {{ getSessionLanguage() == 'en' ? '' : 'd-none' }}">
                            * {{ __('Education') }} * {{ __('System') }} * {{ __('can') }} * {{ __('Make ') }} * {{ __('Change ') }} *
                        </div>
                    </div>
                    <div class="faq__img faq__img-two">
                        <img src="{{ asset($faqSection?->global_content?->image) }}" alt="img">
                        <div class="shape-one">
                            <img src="{{ asset('frontend/img/others/faq_shape01.svg') }}" class="injectable tg-motion-effects4"
                                alt="img">
                        </div>
                        <div class="shape-two">
                            <span class="svg-icon" id="faq-svg"
                              data-svg-icon="{{ asset('frontend/img/others/faq_shape02.svg') }}"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about__content">
                    <div class="section__title">
                        <span class="sub-title">{{ $faqSection?->content?->short_title }}</span>
                        <h2 class="title">
                            {!! clean(processText($faqSection?->content?->title)) !!}
                        </h2>
                    </div>
                    <p class="desc">
                        {!! clean(processText($faqSection?->content?->description)) !!}
                    </p>
                    <div class="faq__wrap">
                        <div class="accordion" id="accordionExample">
                            @foreach ($faqs as $faq)
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}"
                                            type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{ $faq->id }}" aria-expanded="true"
                                            aria-controls="collapse{{ $faq->id }}">
                                            {{ $faq?->question }}
                                        </button>
                                    </h2>
                                    <div id="collapse{{ $faq->id }}"
                                        class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>
                                                {{ $faq?->answer }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
