<table class="table table-striped">


    <tr>
        <td>{{ __('Order Id') }}</td>
        <td>#<a target="_blank" href="">{{ $refund_request?->order?->order_id }}</a> </td>
    </tr>

    <tr>
        <td>{{ __('Reasone') }}</td>
        <td>{!! clean(nl2br($refund_request->reasone)) !!}</td>
    </tr>

    <tr>
        <td>{{ __('Account information for received amount') }}</td>
        <td>{!! clean(nl2br($refund_request->account_information)) !!}</td>
    </tr>

    @if ($refund_request->status == 'success')
        <tr>
            <td>{{ __('Refund amount') }}</td>
            <td>{{ currency($refund_request->refund_amount) }}</td>
        </tr>
    @endif

    <tr>
        <td>{{ __('Status') }}</td>
        <td>
            @if ($refund_request->status == 'success')
            {{ __('Success') }}
            @elseif ($refund_request->status == 'rejected')
            {{ __('Rejected') }}
            @else
            {{ __('Pending') }}
            @endif
        </td>
    </tr>

</table>
