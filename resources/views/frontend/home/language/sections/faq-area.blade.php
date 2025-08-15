<section class="faq__area-three tg-motion-effects section-py-140">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-7 col-md-10 order-0 order-lg-2">
                <div class="faq__img-four">
                    <div class="main-img">
                        <img src="{{ asset($faqSection?->global_content?->image) }}" alt="img" data-aos="fade-down"
                            data-aos-delay="400">
                        <img src="{{ asset($faqSection?->global_content?->image_two) }}" alt="img" data-aos="fade-up"
                            data-aos-delay="400">
                    </div>
                    @if($faqSection?->content?->total_languages)
                    <div class="faq__language-wrap" data-aos="fade-right" data-aos-delay="600">
                        <h2 class="title">{{$faqSection?->content?->total_languages}}</h2>
                        <span>{{__('Course Language')}}</span>
                    </div>
                    @endif
                    <div class="shape">
                        <img src="{{ asset('frontend/img/others/h6_faq_shape01.svg') }}" alt="shape"
                            class="alltuchtopdown">
                        <img src="{{ asset('frontend/img/others/h6_faq_shape02.svg') }}" alt="shape"
                            class="tg-motion-effects4">
                        <img src="{{ asset('frontend/img/others/h6_faq_shape03.svg') }}" alt="shape"
                            class="tg-motion-effects3">
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="faq__content-two faq__content-three">
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
</section>