@extends('frontend.instructor-dashboard.layouts.master')

@section('dashboard-contents')
    <div class="dashboard__content-wrap">
        <div class="dashboard__content-title">
            <h4 class="title">{{ __('Order History') }}</h4>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="dashboard__review-table table-responsive">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th>{{ __('No') }}</th>
                                <th>{{ __('Course') }}</th>
                                <th>{{ __('Buyer') }}</th>
                                <th>{{ __('Main Price') }}</th>
                                <th>{{ __('Your Commission') }}</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($orders as $index => $order)
                                <tr>
                                    <td>{{ ++$index }}</td>
                                    <td>{{ $order->course->title}}</td>
                                    <td>{{ $order->order->user->name}}</td>
                                    <td>{{ currency($order->price ) }}</td>
                                    @php
                                        $commissionAmount = $order->price * ($order->commission_rate / 100);
                                        $amountAfterCommission = $order->price - $commissionAmount;
                                    @endphp
                                    <td>{{ currency($amountAfterCommission) }}</td>
                                     
                                </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center">{{ __('No orders found!') }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection
