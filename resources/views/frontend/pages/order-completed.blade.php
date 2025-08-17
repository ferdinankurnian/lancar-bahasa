@extends('frontend.layouts.master')
@section('meta_title', 'Order Completed' . ' | ' . $setting->app_name)
@section('contents')
    <!-- breadcrumb-area -->
    <x-frontend.breadcrumb :title="__('Order Completed')" :links="[
        ['url' => route('home'), 'text' => __('Home')],
        ['url' => '#', 'text' => __('Order Completed')],
    ]" />
    <!-- breadcrumb-area-end -->

    <div class="checkout__area section-py-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor" class="bi bi-check-circle-fill text-success" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                </svg>
                            </div>
                            <h2 class="card-title">{{ __('Thank You For Your Order!') }}</h2>
                            <p>{{ __('Your payment has been successfully processed.') }}</p>
                            <p>{{ __('Your order number is:') }} <strong>{{ $order->order_number }}</strong></p>
                            <p>{{ __('You will receive an email confirmation shortly.') }}</p>
                            <div class="mt-4">
                                <a href="{{ route('student.dashboard') }}" class="btn btn-primary">{{ __('Go to Dashboard') }}</a>
                                <a href="{{ route('student.orders.index') }}" class="btn btn-secondary">{{ __('View My Orders') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
