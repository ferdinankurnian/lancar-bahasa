@extends('admin.master_layout')
@section('title')
    <title>{{ __('Payment Gateway') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <div class="section-header-back">
                    <a href="{{ route('admin.settings') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
                </div>
                <h1>{{ __('Payment Gateway') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                    </div>
                    <div class="breadcrumb-item active"><a href="{{ route('admin.settings') }}">{{ __('Settings') }}</a>
                    </div>
                    <div class="breadcrumb-item">{{ __('Payment Gateway') }}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <ul class="nav nav-pills flex-column" id="basicPaymentTab" role="tablist">
                                    @include('basicpayment::tabs.navbar')
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="tab-content" id="myTabContent4">
                                    @include('basicpayment::sections.stripe')
                                    @include('basicpayment::sections.paypal')
                                    @include('basicpayment::sections.direct-bank')
                                    @include('basicpayment::sections.razorpay')
                                    @include('basicpayment::sections.flutterwave')
                                    @include('basicpayment::sections.paystack')
                                    @include('basicpayment::sections.mollie')
                                    @include('basicpayment::sections.instamojo')
                                    @include('basicpayment::sections.midtrans')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('js')
    <script src="{{ asset('backend/js/jquery.uploadPreview.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            "use strict";
            var activeTab = localStorage.getItem("activeTab");
            if (activeTab) {
                $('#basicPaymentTab a[href="#' + activeTab + '"]').tab("show");
            } else {
                $("#basicPaymentTab a:first").tab("show");
            }

            $('a[data-toggle="tab"]').on("shown.bs.tab", function(e) {
                var newTab = $(e.target).attr("href").substring(1);
                localStorage.setItem("activeTab", newTab);
            });
            


            $.uploadPreview({
                input_field: "#image-upload-paypal",
                preview_box: "#image-preview-paypal",
                label_field: "#image-label-paypal",
                label_default: "{{ __('Choose Image') }}",
                label_selected: "{{ __('Change Image') }}",
                no_label: false,
                success_callback: null
            });

            $('#image-preview-paypal').css({
                'background-image': 'url({{ asset($basic_payment->paypal_image) }})',
                'background-size': 'contain',
                'background-position': 'center',
                'background-repeat': 'no-repeat'
            });

            $.uploadPreview({
                input_field: "#image-upload-stripe",
                preview_box: "#image-preview-stripe",
                label_field: "#image-label-stripe",
                label_default: "{{ __('Choose Image') }}",
                label_selected: "{{ __('Change Image') }}",
                no_label: false,
                success_callback: null
            });

            $('#image-preview-stripe').css({
                'background-image': 'url({{ asset($basic_payment->stripe_image) }})',
                'background-size': 'contain',
                'background-position': 'center',
                'background-repeat': 'no-repeat'
            });

            $.uploadPreview({
                input_field: "#image-upload-bank",
                preview_box: "#image-preview-bank",
                label_field: "#image-label-bank",
                label_default: "{{ __('Choose Image') }}",
                label_selected: "{{ __('Change Image') }}",
                no_label: false,
                success_callback: null
            });

            $('#image-preview-bank').css({
                'background-image': 'url({{ asset($basic_payment->bank_image) }})',
                'background-size': 'contain',
                'background-position': 'center',
                'background-repeat': 'no-repeat'
            });
            $.uploadPreview({
                input_field: "#image-upload-razorpay",
                preview_box: "#image-preview-razorpay",
                label_field: "#image-label-razorpay",
                label_default: "{{ __('Choose Image') }}",
                label_selected: "{{ __('Change Image') }}",
                no_label: false,
                success_callback: null
            });

            $('#image-preview-razorpay').css({
                'background-image': 'url({{ asset($payment_setting->razorpay_image) }})',
                'background-size': 'contain',
                'background-position': 'center',
                'background-repeat': 'no-repeat'
            });

            $.uploadPreview({
                input_field: "#image-upload-flutterwave",
                preview_box: "#image-preview-flutterwave",
                label_field: "#image-label-flutterwave",
                label_default: "{{ __('Choose Image') }}",
                label_selected: "{{ __('Change Image') }}",
                no_label: false,
                success_callback: null
            });

            $('#image-preview-flutterwave').css({
                'background-image': 'url({{ asset($payment_setting->flutterwave_image) }})',
                'background-size': 'contain',
                'background-position': 'center',
                'background-repeat': 'no-repeat'
            });

            $.uploadPreview({
                input_field: "#image-upload-paystack",
                preview_box: "#image-preview-paystack",
                label_field: "#image-label-paystack",
                label_default: "{{ __('Choose Image') }}",
                label_selected: "{{ __('Change Image') }}",
                no_label: false,
                success_callback: null
            });

            $('#image-preview-paystack').css({
                'background-image': 'url({{ asset($payment_setting->paystack_image) }})',
                'background-size': 'contain',
                'background-position': 'center',
                'background-repeat': 'no-repeat'
            });

            $.uploadPreview({
                input_field: "#image-upload-mollie",
                preview_box: "#image-preview-mollie",
                label_field: "#image-label-mollie",
                label_default: "{{ __('Choose Image') }}",
                label_selected: "{{ __('Change Image') }}",
                no_label: false,
                success_callback: null
            });

            $('#image-preview-mollie').css({
                'background-image': 'url({{ asset($payment_setting->mollie_image) }})',
                'background-size': 'contain',
                'background-position': 'center',
                'background-repeat': 'no-repeat'
            });

            $.uploadPreview({
                input_field: "#image-upload-instamojo",
                preview_box: "#image-preview-instamojo",
                label_field: "#image-label-instamojo",
                label_default: "{{ __('Choose Image') }}",
                label_selected: "{{ __('Change Image') }}",
                no_label: false,
                success_callback: null
            });

            $('#image-preview-instamojo').css({
                'background-image': 'url({{ asset($payment_setting->instamojo_image) }})',
                'background-size': 'contain',
                'background-position': 'center',
                'background-repeat': 'no-repeat'
            });

            $.uploadPreview({
                input_field: "#image-upload-midtrans",
                preview_box: "#image-preview-midtrans",
                label_field: "#image-label-midtrans",
                label_default: "{{ __('Choose Image') }}",
                label_selected: "{{ __('Change Image') }}",
                no_label: false,
                success_callback: null
            });

            $('#image-preview-midtrans').css({
                'background-image': 'url({{ asset($midtrans_payment->image ?? '') }})',
                'background-size': 'contain',
                'background-position': 'center',
                'background-repeat': 'no-repeat'
            });
        });
    </script>
@endpush