@extends('frontend.student-dashboard.layouts.master')

@section('dashboard-contents')
    <div class="dashboard__content-wrap">
        <div class="dashboard__content-title">
            <h4 class="title">{{ __('Order History') }}</h4>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="dashboard__review-table">
                    <div class="invoice">
                        <div class="invoice-print">
                            <div class="row">
                                <div class="col-lg-12 info-wrapper">
                                    <div class="row w-100">
                                        <div class="col-12 col-sm-6 col-md-4">
                                            <div class="invoice-title">
                                                <h2>{{ __('Invoice') }}</h2>
                                                <div class="invoice-number">{{ __('Order ') }} #{{ $order->invoice_id }}
                                                </div>
                                                <address>
                                                    <strong>{{ __('Order Date') }}:</strong><br>
                                                    {{ formatDate($order->created_at) }}<br><br>
                                                </address>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4">
                                            <address>
                                                <strong>{{ __('Billed To') }}:</strong><br>
                                                {{ $order->user->name }}<br>
                                                {{ __('Phone:') }} {{ $order->user->phone }}<br>
                                                {{ __('Email') }} {{ $order->user->email }}<br>
                                                {{ __('Address') }} {{ $order->user->address }}<br>
                                            </address>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4">
                                            <address>
                                                <strong>{{ __('Payment Method') }}:</strong><br>
                                                {{ $order->payment_method }}<br>
                                            </address>
                                            <address>
                                                <strong>{{ __('Payment Status') }}:</strong><br>
                                                {{ $order->payment_status }}<br><br>
                                            </address>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="section-title">{{ __('Order Summary') }}</div>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover table-md">
                                            <tr>
                                                <th data-width="40">#</th>
                                                <th>{{ __('Item') }}</th>
                                                <th>{{ __('by') }}</th>
                                                <th class="text-center">{{ __('Price') }}</th>
                                            </tr>
                                            @foreach ($order->orderItems as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->course->title }}</td>
                                                    <td>
                                                        {{ $item->course->instructor->name }}
                                                        <br>
                                                        {{ $item->course->instructor->email }}
                                                    </td>
                                                    <td class="text-center">{{ $item->price * $order->conversion_rate }} {{ $order->payable_currency }}</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-lg-4">
                                        </div>

                                        @php
                                            $subTotal = 0;
                                            $discount = 0;
                                            $gatewayCharge = 0;
                                            foreach ($order->orderItems as $item) {
                                                $subTotal += $item->price;
                                            }
                                            if ($order->coupon_discount_amount > 0) {
                                                $discount = $order->coupon_discount_amount;
                                            }
                                            if ($order->gateway_charge > 0) {
                                                $gatewayCharge = ($order->gateway_charge / ($subTotal - $discount)) * 100;
                                            }
                                            
                                            $total = ($subTotal - $discount + $order->gateway_charge) * $order->conversion_rate;
                                        @endphp

                                        <div class="col-lg-8 text-end">
                                            <div class="invoice-detail-item">
                                                <div class="invoice-detail-name">{{ __('Subtotal') }}</div>
                                                <div class="invoice-detail-value">
                                                    {{ number_format($subTotal * $order->conversion_rate, 2) }} {{ $order->payable_currency }}
                                                </div>

                                            </div>

                                            <div class="invoice-detail-item">
                                                <div class="invoice-detail-name">{{ __('Discount') }}</div>
                                                <div class="invoice-detail-value">
                                                    {{ number_format($discount * $order->conversion_rate, 2) }} {{ $order->payable_currency }}
                                                </div>
                                            </div>
                                            <div class="invoice-detail-item">
                                                <div class="invoice-detail-name">{{ __('Gateway Charge') }}
                                                    ({{ number_format($gatewayCharge) }}%)</div>
                                                <div class="invoice-detail-value">
                                                    {{ number_format($order->gateway_charge * $order->conversion_rate, 2) }} {{ $order->payable_currency }}
                                                </div>
                                            </div>
                                            <hr class="mt-2 mb-2">
                                            <div class="invoice-detail-item">
                                                <div class="invoice-detail-name">{{ __('Total') }}</div>
                                                <div class="invoice-detail-value invoice-detail-value-lg">
                                                    {{ number_format($total, 2) }} {{ $order->payable_currency }}
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div style="margin-bottom: 1rem;" class="text-md-right">
                            <a target="_blank" href="{{ route('student.order.print-invoice', $order->id) }}" class="btn btn-warning btn-icon icon-left print-btn"><i class="fas fa-print"></i>
                                {{ __('Print') }}</a>

                            @if ($order->payment_status == 'pending')
                                <button type="button" class="btn btn-danger btn-icon icon-left ms-2" data-bs-toggle="modal" data-bs-target="#cancelOrderModal">
                                    <i class="fas fa-times"></i> {{ __('Cancel Transaction') }}
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    </div>

    <!-- Cancel Order Modal -->
    <div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModalLabel" aria-hidden="true" style="z-index: 1051;" data-bs-backdrop="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelOrderModalLabel">{{ __('Confirm Cancellation') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{ __('Are you sure you want to cancel this transaction?') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <form id="cancel-order-form" action="{{ route('student.orders.cancel', $order->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger">{{ __('Cancel Transaction') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


