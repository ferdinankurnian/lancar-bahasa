@extends('frontend.layouts.master')
@section('meta_title', 'Order Completed' . ' || ' . $setting->app_name)

@section('contents')
    <!-- breadcrumb-area -->
    <x-frontend.breadcrumb :title="__('Order Completed')" :links="[
        ['url' => route('home'), 'text' => __('Home')],
        ['url' => route('checkout.index'), 'text' => __('Order Completed')],
    ]" />
    <!-- breadcrumb-area-end -->

    <!-- checkout-area -->
    <div class="checkout__area section-py-120">
        <div class="container">
            <div class="row">
                <div class="text-center">
                    <img src="{{ asset('uploads/website-images/success.png') }}" alt="">
                    <h6 class="mt-2">{{ __('Your order has been placed') }}</h6>
                    <p>{{ __('For check more details you can go to your dashboard') }}</p>
                    <a href="{{ route('student.dashboard') }}" class="btn btn-primary">{{ __('Go to Dashboard') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@if (session('enrollSuccess') && $setting->google_tagmanager_status == 'active' && $marketing_setting?->order_success)
    @php
        $enrollSuccess = session('enrollSuccess');
        session()->forget('enrollSuccess');
    @endphp
    @push('scripts')
        <script>
            $(function() {
                dataLayer.push({
                    'event': 'enrollSuccess',
                    'order_details': @json($enrollSuccess)
                });
            });
        </script>
    @endpush
@endif
