<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Invoice') }}</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .invoice_area {
            font-family: sans-serif;
        }

        .invoice_area table {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .invoice_area table tbody {
            width: 100%;
        }

        .invoice_area table tr {
            width: 100% !important;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .invoice_area table tr td {
            text-transform: capitalize;
            font-size: 16px;
        }

        .invoice_header {
            background: #f3f2f2;
            padding: 30px;
        }

        .invoice_header table tr td {
            width: 49%;
        }

        .invoice_header table tr td.left a {
            display: block;
            width: 160px;
        }

        .invoice_header table tr td.right h2 {
            text-transform: uppercase;
            font-size: 28px;
            font-weight: 600;
            line-height: initial;
            margin-bottom: 10px;
            text-align: right;
            color: #05092B;
        }

        .invoice_header table tr td.right h5 {
            font-size: 16px;
            text-align: right;
            color: #05092B;
        }

        .invoice_billing_info {
            padding: 30px;
        }

        .invoice_billing_info table tr td h5 {
            font-size: 20px;
            font-weight: 700;
            text-transform: capitalize;
            margin-bottom: 10px;
            color: #05092B;
        }

        .invoice_billing_info table tr td p {
            color: #545353;
            font-weight: 400;
            font-size: 16px;
            margin-top: 10px;
        }

        .invoice_billing_info .right p {
            text-align: right;
        }

        .invoice_billing_info .right p span {
            display: inline-block;
            width: 70px;
            text-align: right;
        }

        .invoice_billing_info .right p:last-child,
        .invoice_billing_info .right p:last-child span {
            font-weight: 600;
        }

        .invoice_billing_order {
            padding: 30px;
        }

        .invoice_billing_order table {
            border: 1px solid rgb(238, 238, 238);
        }

        .invoice_billing_order table thead {
            width: 100%;
        }

        .invoice_billing_order table thead tr {
            background: #f3f2f2;
        }

        .invoice_billing_order table thead tr th {
            background: #f3f2f2;
        }

        .invoice_billing_order table tr th,
        .invoice_billing_order table tr td {
            padding: 10px 20px;
            border-right: 1px solid rgb(238, 238, 238);
            border-bottom: 1px solid rgb(238, 238, 238);
            width: 25%;
            color: #05092B;
            text-align: left;
        }

        .sl-no {
            width: 10% !important;
        }

        .item {
            width: 40% !important;
        }

        .by {
            width: 35% !important;
        }

        .price {
            width: 15% !important;
        }

        .invoice_billing_info .right p span {
            display: inline-block;
            width: 90px;
            text-align: right;
        }
    </style>
</head>

<body>

    <div class="invoice_area">

        <div class="invoice_header">
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        <tr>
                            <td class="left">
                                <a href="javascript:;">
                                    <img src="{{ asset($setting->logo) }}" alt="">
                                </a>
                            </td>
                            <td class="right">
                                <h2>{{ __('invoice') }}</h2>
                                <h5>{{ __('Order Id: ') }}{{ $order->invoice_id }}</h5>
                                <br>
                                <h5>{{ __('Date: ') }}{{ formatDate($order->created_at) }}</h5>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="invoice_billing_info">
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        <tr>
                            <td>
                                <h5>{{ __('Billed To') }}</h5>
                                <p>{{ $order->user->name }}</p>
                                <p>{{ $order->user->phone }}</p>
                                <p>{{ $order->user->email }}</p>
                                <p>{{ $order->user->address }}</p>

                            </td>
                            <td>
                                <h5>{{ __('Billed From') }}</h5>
                                <p>{{ $setting->app_name }}</p>
                                <p>{{ $setting->contact_message_receiver_mail }}</p>
                                <p>{{ $setting->site_address }}</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="invoice_billing_order">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="sl-no">{{ __('No') }}.</th>
                            <th class="item">{{ __('Item') }}</th>
                            <th class="by">{{ __('By') }}</th>
                            <th class="price">{{ __('Price') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderItems as $item)
                            <tr>
                                <td class="sl-no">{{ $loop->iteration }}</td>
                                <td class="item">{{ $item->course->title }}</td>
                                <td class="by">
                                    {{ $item->course->instructor->name }}
                                    <br>
                                    <small>{{ $item->course->instructor->email }}</small>
                                </td>
                                <td class="price">{{ $item->price * $order->conversion_rate }}
                                    {{ $order->payable_currency }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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

        <div class="invoice_billing_info">
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        <tr>
                            <td class="left">
                                <h5>{{ __('Payment Details') }}</h5>
                                <p><b>{{ __('Payment Method') }} :</b> {{ $order->payment_method }}</p>
                                <p><b>{{ __('Payment Status') }} :</b> {{ $order->payment_status }}</p>
                            </td>
                            <td class="right">
                                <p>{{ __('Sub Total') }}
                                    :<span>{{ number_format($subTotal * $order->conversion_rate, 2) }}
                                        {{ $order->payable_currency }}</span></p>
                                <p>{{ __('Discount') }}
                                    :<span>{{ number_format($discount * $order->conversion_rate, 2) }}
                                        {{ $order->payable_currency }}</span></p>
                                <p>{{ __('Gateway Charge') }}
                                    ({{ $gatewayCharge }}%)<span>{{ number_format($order->gateway_charge * $order->conversion_rate, 2) }}
                                        {{ $order->payable_currency }}</span> </p>
                                <p>{{ __('Total') }} :<span>{{ number_format($total, 2) }}
                                        {{ $order->payable_currency }}</span></p>

                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>


    <script>
        'use strict'
        // auto print the page
        window.addEventListener('load', window.print());
    </script>
</body>

</html>
