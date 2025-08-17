@extends('frontend.layouts.master')
@section('meta_title', 'Checkout' . ' | ' . $setting->app_name)
@section('contents')
    <!-- breadcrumb-area -->
    <x-frontend.breadcrumb :title="__('Make Payment')" :links="[
        ['url' => route('home'), 'text' => __('Home')],
        ['url' => '#', 'text' => __('Make Payment')],
    ]" />
    <!-- breadcrumb-area-end -->

    <!-- checkout-area -->
    <div class="checkout__area section-py-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="wsus__payment_area">
                        <h4 class="mb-4">{{ __('Select Payment Method') }}</h4>
                        <div class="row">
                            <div class="col-lg-4 col-6 col-sm-4">
                                <button id="pay-button" class="wsus__single_payment border-0" style="padding: 20px; text-align: center;">
                                    <img src="{{ asset('uploads/website-images/midtrans.png') }}" alt="Pay with Midtrans" class="img-fluid w-100">
                                    <h5 class="mt-2">{{ __('Pay with Midtrans') }}</h5>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="cart__collaterals-wrap payment_slidebar">
                        <h2 class="title">{{ __('Order Summary') }}</h2>
                        <ul class="list-wrap pb-0">
                            <li>{{ __('Total Items') }}<span>{{ $order->orderItems->count() }}</span></li>
                            <li>
                                @if ($order->has_coupon)
                                    <p class="coupon-discount m-0">
                                        <span>{{ __('Discount') }}</span>
                                        <br>
                                        <small>{{ $order->coupon_code }} ({{ $order->coupon_discount_percent }} %)</small>
                                    </p>
                                    <span class="discount-amount">{{ currency($order->coupon_discount_amount) }}</span>
                                @else
                                    <p class="coupon-discount m-0">
                                        <span>{{ __('Discount') }}</span>
                                    </p>
                                    <span class="discount-amount">{{ currency(0) }}</span>
                                @endif
                            </li>
                            <li>{{ __('Total') }} <span class="amount">{{ currency($order->payable_amount) }}</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- checkout-area-end -->
@endsection

@push('scripts')
    @php
        $midtrans_info = \Modules\Midtrans\app\Models\MidtransSetting::get();
        $midtrans_payment_settings = [];
        foreach ($midtrans_info as $item) {
            $midtrans_payment_settings[$item->key] = $item->value;
        }
        $is_production = (bool) ($midtrans_payment_settings['is_production'] ?? false);
    @endphp

    <script type="text/javascript"
            src="{{ $is_production ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
            data-client-key="{{ $midtrans_payment_settings['client_key'] ?? '' }}"></script>

    <script type="text/javascript">
        "use strict";
        document.addEventListener("DOMContentLoaded", function() {
            var payButton = document.getElementById('pay-button');
            payButton.addEventListener('click', function () {
                window.location.href = "{{ route('checkout.pay', $order) }}";
            });
                // SnapToken acquired from controller
                window.location.href = "{{ route('checkout.pay', $order) }}";

                
                    
                        onSuccess: function(result){
                            window.location.href = "{{ route('order.completed', $order) }}";
                        },
                        onPending: function(result){
                            window.location.href = "{{ route('order.completed', $order) }}";
                        },
                        onError: function(result){
                            toastr.error('Payment failed. Please try again.');
                            window.location.href = "{{ route('student.orders.index') }}"; // Redirect to order list
                        },
                        onClose: function(){
                            toastr.info('You closed the popup without finishing the payment.');
                            window.location.href = "{{ route('student.orders.index') }}"; // Redirect to order list
                        }
                    });
                
                    
                }
            });
        });
    </script>
@endpush
