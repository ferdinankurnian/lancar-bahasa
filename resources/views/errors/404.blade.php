@extends('frontend.layouts.master')
@section('meta_title', 'Error' . ' || ' . $setting->app_name)

@section('contents')
    <!-- breadcrumb-area -->
    <x-frontend.breadcrumb :title="__('Error')" :links="[
        ['url' => route('home'), 'text' => __('Home')],
        ['url' => route('checkout.index'), 'text' => __('Error')],
    ]" />
    <!-- breadcrumb-area-end -->

    <section class="error-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="error-wrap text-center">
                        <div class="error-img">
                            <img src="{{ asset('frontend/img/others/error_img.svg') }}" alt="img" class="injectable">
                        </div>
                        <div class="error-content">
                            <h2 class="title">{{ __('ERROR PAGE') }}! <span>{{ __('Sorry This Page is Not Available') }}!</span></h2>
                            <div class="tg-button-wrap">
                                <a href="{{ url('/') }}" class="btn arrow-btn">{{ __('Go To Home Page') }} <img
                                        src="{{ asset('frontend/img/icons/right_arrow.svg') }}" alt="img" class="injectable"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
