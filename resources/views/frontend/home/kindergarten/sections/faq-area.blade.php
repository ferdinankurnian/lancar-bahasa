<section class="faq__area-two tg-motion-effects section-py-140">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-6 col-md-8 order-0 order-lg-2">
                <div class="faq__img-three">
                    <div class="faq__mask-img">
                        <img src="{{ asset($faqSection?->global_content?->image) }}" alt="img">
                    </div>
                    <div class="faq__img-shape">
                        <img src="{{ asset('frontend/img/others/h5_faq_img_shape.svg') }}" class="injectable">
                    </div>
                    <div class="shape shape-one" data-aos="fade-down-left" data-aos-delay="400">
                        <img src="{{ asset('frontend/img/others/h5_faq_shape02.svg') }}" alt="shape"
                            class="tg-motion-effects3">
                    </div>
                    <div class="shape shape-two" data-aos="fade-up-left" data-aos-delay="400">
                        <img src="{{ asset('frontend/img/others/h5_faq_shape03.svg') }}" alt="shape"
                            class="tg-motion-effects4">
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="faq__content-two">
                    <div class="section__title mb-15">
                        <span class="sub-title">{{ $faqSection?->content?->short_title }}</span>
                        <h2 class="title bold">{!! clean(processText($faqSection?->content?->title)) !!}</h2>
                    </div>
                    <p>{!! clean(processText($faqSection?->content?->description)) !!}</p>
                    <div class="faq__wrap faq__wrap-two">
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
    <div class="faq__shape">
        <img src="{{ asset('frontend/img/others/h5_faq_shape01.svg') }}" alt="shape" class="tg-motion-effects3">
    </div>
</section>
