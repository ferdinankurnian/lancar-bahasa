@extends('admin.master_layout')
@section('title')
    <title>{{ $title }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ $title }}</h1>
            </div>

            <div class="section-body">
                <div class="row">

                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tr>
                                            <th>{{ __('SN') }}</th>
                                            <th>{{ __('User') }}</th>
                                            <th>{{ __('Order Id') }}</th>
                                            <th>{{ __('Paid Amount') }}</th>
                                            <th>{{ __('Gateway') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Payment') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>

                                        @forelse ($orders as $index => $order)
                                            <tr>
                                                <td>{{ ++$index }}</td>
                                                <td><a
                                                        href="{{ route('admin.customer-show', $order->buyer_id) }}">{{ $order?->user?->name }}</a>
                                                </td>
                                                <td>#{{ $order->invoice_id }}</td>
                                                <td>{{ $order->paid_amount }} {{ $order->payable_currency }}</td>
                                                <td>
                                                    {{ $order->payment_method }}
                                                </td>
                                                <td>
                                                    @if ($order->status == 'completed')
                                                        <div class="badge badge-success">{{ __('Completed') }}</div>
                                                    @elseif($order->status == 'processing')
                                                        <div class="badge badge-warning">{{ __('Processing') }}</div>
                                                    @elseif($order->status == 'declined')
                                                        <div class="badge badge-danger">{{ __('Declined') }}</div>
                                                    @else
                                                        <div class="badge badge-warning">{{ __('Pending') }}</div>
                                                    @endif
                                                </td>

                                                <td>
                                                    @if ($order->payment_status == 'paid')
                                                        <div class="badge badge-success">{{ __('Paid') }}</div>
                                                    @elseif ($order->payment_status == 'cancelled')
                                                        <div class="badge badge-danger">{{ __('Cancelled') }}</div>
                                                    @else
                                                        <div class="badge badge-danger">{{ __('Pending') }}</div>
                                                    @endif
                                                </td>

                                                <td>
                                                    <a href="{{ route('admin.order', $order->id) }}"
                                                        class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>

                                                    <a href=""
                                                        data-url="{{ route('admin.order.destroy', $order->id) }}"
                                                        class="btn btn-danger btn-sm delete"><i class="fa fa-trash"></i></a>

                                                </td>
                                            </tr>
                                        @empty
                                            <x-empty-table :name="__('Orders')" route="" create="no" :message="__('No data found!')"
                                                colspan="9"></x-empty-table>
                                        @endforelse
                                    </table>
                                </div>
                                {{ $orders->links() }}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="delete">
        <div class="modal-dialog" role="document">
            <form action="" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Delete Plan') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="text-danger">{{ __('Are You Sure to Delete this Plan ?') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-danger">{{ __('Yes, Delete') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    @push('js')
        <script>
            $(function() {
                'use strict'

                $('.delete').on('click', function(e) {
                    e.preventDefault();
                    const modal = $('#delete');
                    modal.find('form').attr('action', $(this).data('url'));
                    modal.modal('show');
                })
            })
        </script>
    @endpush
@endsection
