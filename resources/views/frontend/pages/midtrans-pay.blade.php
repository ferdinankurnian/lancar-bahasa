@extends('frontend.layouts.master')
@section('meta_title', 'Payment' . ' | ' . ($setting->app_name ?? config('app.name')))
@section('contents')
    <div class="section-py-120 text-center">
        <div class="container">
            <h3>{{ __('Processing your payment...') }}</h3>
            <p>{{ __('Please do not refresh or close this page.') }}</p>
        </div>
    </div>
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
            var snapToken = "{{ $snap_token }}";
            if (snapToken) {
                snap.pay(snapToken, {
                    onSuccess: function(result){
                        window.location.href = "{{ route('order.completed', $order) }}";
                    },
                    onPending: function(result){
                        window.location.href = "{{ route('order.completed', $order) }}";
                    },
                    onError: function(result){
                        toastr.error('Payment failed. Please try again.');
                        window.location.href = "{{ route('student.orders.index') }}";
                    },
                    onClose: function(){
                        toastr.info('You closed the popup without finishing the payment.');
                        window.location.href = "{{ route('student.orders.index') }}";
                    }
                });
            } else {
                toastr.error('Snap Token not found. Cannot proceed with payment.');
            }
        });
    </script>
@endpush
