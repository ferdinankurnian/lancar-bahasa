<section class="choose__area-three section-pb-140">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-6 col-md-10">
                <div class="choose__img-three">
                    <img src="{{ asset($aboutSection?->global_content?->image) }}" alt="img">
                    @if ($aboutSection?->global_content?->video_url)
                        <a href="{{ $aboutSection?->global_content?->video_url }}" class="play-btn popup-video"><i
                                class="fas fa-play"></i></a>
                    @endif

                </div>
            </div>
            <div class="col-lg-6">
                <div class="choose__content-three">
                    <div class="section__title mb-15">
                        <span class="sub-title">{{ $aboutSection?->content?->short_title }}</span>
                        <h2 class="title bold">{!! clean(processText($aboutSection?->content?->title)) !!}</h2>
                    </div>
                    <div class=" wsus_content-box">
                        {!! clean(processText($aboutSection?->content?->description)) !!}
                    </div>
                    @if ($aboutSection?->content?->button_text)
                        <a href="{{ $aboutSection?->global_content?->button_url }}"
                            class="btn arrow-btn btn-four">{{ $aboutSection?->content?->button_text }} <img
                                src="{{ asset('frontend/img/icons/right_arrow.svg') }}" alt=""
                                class="injectable"></a>
                    @endif

                </div>
            </div>
        </div>
    </div>
</section>