<!DOCTYPE html>
<html>
<head>
    <title>Retrying Payment...</title>
    <script type="text/javascript"
            src="{{ $midtrans_credentials->is_production ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
            data-client-key="{{ $midtrans_credentials->client_key }}"></script>
</head>
<body>

<script type="text/javascript">
  document.addEventListener("DOMContentLoaded", function() {
    snap.pay('{{ $snap_token }}', {
      onSuccess: function(result){
        window.location.href = "{{ route('midtrans.finalize') }}?order_id=" + result.order_id;
      },
      onPending: function(result){
        window.location.href = "{{ route('midtrans.finalize') }}?order_id=" + result.order_id;
      },
      onError: function(result){
        window.location.href = "{{ url('order-unfinish') }}/" + "{{ $invoice_id }}";
      },
      onClose: function() {
        window.location.href = "{{ url('order-unfinish') }}/" + "{{ $invoice_id }}";
      }
    });
  });
</script>

</body>
</html>
