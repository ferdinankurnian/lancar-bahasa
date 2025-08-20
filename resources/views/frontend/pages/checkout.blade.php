@extends('frontend.layouts.empty')
@section('meta_title', 'Checkout' . ' | ' . $setting->app_name)
@section('contents')
    {{-- Midtrans Snap start --}}
@endsection

@push('scripts')
    @if ($midtrans_credentials->status == '1')
        <script type="text/javascript"
            src="{{ $midtrans_credentials->is_production ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
            data-client-key="{{ $midtrans_credentials->client_key }}"></script>

        <script type="text/javascript">
            "use strict";

            function midtransPayment() {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('midtrans.create-transaction') }}", // This route needs to be created
                    data: {
                        _token: "{{ csrf_token() }}",
                        payable_amount: "{{ Session::get('payable_amount') }}",
                        // You might need to pass more order details here (e.g., order_id, user_id, item_details)
                        // For now, just passing payable_amount
                        user_name: "{{ $user->name ?? '' }}",
                        user_email: "{{ $user->email ?? '' }}",
                    },
                    success: function(response) {
                        if (response.snap_token) {
                            snap.pay(response.snap_token, {
                                onSuccess: function(result) {
                                    /* You may add your own implementation here */
                                    // alert("payment success!");
                                    window.location.href = "{{ route('payment-addon-success') }}"; // Redirect to payment addon success to finalize order
                                },
                                onPending: function(result) {
                                    /* You may add your own implementation here */
                                    // alert("wating your payment!");
                                    window.location.href = "{{ route('order-unfinish') }}"; // Redirect to unfinish page
                                },
                                onError: function(result) {
                                    /* You may add your own implementation here */
                                    // alert("payment failed!");
                                    window.location.href = "{{ route('order-fail') }}"; // Redirect to error page
                                },
                                onClose: function() {
                                    /* You may add your own implementation here */
                                    // alert('customer closed the popup without finishing the payment');
                                    window.location.href = "{{ route('order-unfinish') }}";
                                }
                            });
                        } else {
                            toastr.error("{{ __('Failed to get Snap Token. Please try again.') }}");
                        }
                    },
                    error: function(xhr, status, error) {
                        toastr.error("{{ __('An error occurred while preparing payment. Please try again.') }}");
                        console.error(xhr.responseText);
                    }
                });
            }
            $(function() {
                // Trigger the midtransPayment function when the page loads
                midtransPayment();
            });
        </script>
    @endif
    {{-- Midtrans Snap end --}}
@endpush
