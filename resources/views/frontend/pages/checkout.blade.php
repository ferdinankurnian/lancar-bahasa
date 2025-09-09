@extends('frontend.layouts.empty')
@section('meta_title', 'Checkout' . ' | ' . $setting->app_name)
@section('contents')
    {{-- This page is intentionally blank and initiates payment on load --}}
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
                    url: "{{ route('midtrans.create-transaction') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        if (response.success) {
                            window.location.href = response.redirect;
                        } else if (response.snap_token) {
                            snap.pay(response.snap_token, {
                                onSuccess: function(result) {
                                    // Redirect to our new finalize route to process the transaction securely
                                    window.location.href = "{{ url('/midtrans/finalize') }}?order_id=" + result.order_id;
                                },
                                onPending: function(result) {
                                    // On pending, redirect to the generic unfinish page
                                    window.location.href = "{{ route('order-unfinish') }}";
                                },
                                onError: function(result) {
                                    // On error, redirect to the generic fail page
                                    window.location.href = "{{ route('order-fail') }}";
                                },
                                onClose: function() {
                                    // If user closes the popup, consider it an unfinished payment
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
@endpush