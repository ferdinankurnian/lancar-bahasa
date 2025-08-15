<section class="breadcrumb__area breadcrumb__bg" data-background="{{ asset(Cache::get('setting')?->breadcrumb_image) }}">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb__content">
                    <h3 class="title">{{ $title }}</h3>
                    <nav class="breadcrumb">
                        @foreach ($links as $key => $link)
                            <span property="itemListElement" typeof="ListItem">
                                <a href="{{ $loop->last ? 'javascript:;' : $link['url'] }}">{{ $link['text'] }}</a>
                            </span>
                            @if (!$loop->last)
                                <span class="breadcrumb-separator"><i class="fas fa-angle-right"></i></span>
                            @endif
                        @endforeach
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="breadcrumb__shape-wrap">
        <img src="{{ asset('frontend/img/others/breadcrumb_shape01.svg') }}" alt="img" class="alltuchtopdown">
        <img src="{{ asset('frontend/img/others/breadcrumb_shape02.svg') }}" alt="img" data-aos="fade-right"
            data-aos-delay="300">
        <img src="{{ asset('frontend/img/others/breadcrumb_shape03.svg') }}" alt="img" data-aos="fade-up"
            data-aos-delay="400">
        <img src="{{ asset('frontend/img/others/breadcrumb_shape04.svg') }}" alt="img" data-aos="fade-down-left"
            data-aos-delay="400">
        <img src="{{ asset('frontend/img/others/breadcrumb_shape05.svg') }}" alt="img" data-aos="fade-left"
            data-aos-delay="400">
    </div>
</section>
