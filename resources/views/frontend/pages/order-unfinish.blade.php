@extends('frontend.layouts.master')
@section('meta_title', 'Order Unfinish'. ' || ' . $setting->app_name)

@section('contents')
    <!-- breadcrumb-area -->
    <!-- <x-frontend.breadcrumb :title="__('Order Unfinish')" :links="[
        ['url' => route('home'), 'text' => __('Home')],
        ['url' => route('checkout.index'), 'text' => __('Order Unfinish')],
    ]" /> -->
    <!-- breadcrumb-area-end -->

    <!-- checkout-area -->
    <div class="checkout__area section-py-120">
        <div class="container">
            <div class="row">
                <div class="text-center">
                    <img src="{{ asset('uploads/website-images/question.png') }}" alt="">
                    <h6 class="mt-2">{{ __('Waiting on payment') }}</h6>
                    <p>{{ __("Hey! We're still waiting for your payment!") }}</p>
                    @if ($invoice_id)
                        <a href="{{ route('midtrans.retry-payment', $invoice_id) }}" class="btn btn-primary me-2">{{ __('Pay Now') }}</a>
                    @else
                        <a href="{{ route('midtrans.retry-payment') }}" class="btn btn-primary me-2">{{ __('Pay Now') }}</a>
                    @endif
                    <a href="{{ route('student.dashboard') }}" class="btn btn-primary">{{ __('Go to Dashboard') }}</a>
                </div>     
            </div>
        </div>
    </div>
@endsection
