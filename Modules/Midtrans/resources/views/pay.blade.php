<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proceeding to Payment...</title>
    @php
        $snap_url = $is_production ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js';
    @endphp
    <script type="text/javascript" src="{{ $snap_url }}" data-client-key="{{ $client_key }}"></script>
    <style>
        body { font-family: Arial, sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; background-color: #f4f4f4; }
        .container { text-align: center; }
        .loader { border: 8px solid #f3f3f3; border-top: 8px solid #3498db; border-radius: 50%; width: 60px; height: 60px; animation: spin 2s linear infinite; margin: 0 auto; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    </style>
</head>
<body>

    <div class="container">
        <div class="loader"></div>
        <h2>Please wait while we redirect you to the payment page...</h2>
        <p>Do not close or refresh this page.</p>
    </div>

    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            window.snap.pay('{{ $snap_token }}', {
                onSuccess: function(result){
                    /* You may add your own implementation here */
                    window.location.href = '{{ route("midtrans.finish") }}?order_id={{ $order->invoice_id }}';
                },
                onPending: function(result){
                    /* You may add your own implementation here */
                    window.location.href = '{{ route("midtrans.unfinish") }}?order_id={{ $order->invoice_id }}';
                },
                onError: function(result){
                    /* You may add your own implementation here */
                    window.location.href = '{{ route("midtrans.error") }}?order_id={{ $order->invoice_id }}';
                },
                onClose: function(){
                    /* You may add your own implementation here */
                    alert('You closed the payment popup without finishing the transaction.');
                    window.location.href = '{{ route("student.orders.index") }}'; // Redirect to order history
                }
            });
        });
    </script>

</body>
</html>
