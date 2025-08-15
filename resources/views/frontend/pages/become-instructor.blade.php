@extends('frontend.layouts.master')
@section('meta_title', 'Become Instructor'. ' || ' . $setting->app_name)
@section('contents')
    <!-- breadcrumb-area -->
    <x-frontend.breadcrumb
        :title="__('Become Instructor')"
        :links="[
            ['url' => route('home'), 'text' => __('Home')],
            ['url' => route('become-instructor'), 'text' => __('Become Instructor')],
        ]"
    />
    <!-- breadcrumb-area-end -->

    <!-- singUp-area -->
    <section class="singUp-area section-py-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-8">
                    <div class="singUp-wrap">
                        <h2 class="title">{{ __('Become Instructor') }}</h2>
                        <div class="normal-text">
                            {!! clean($instructorRequestSetting?->instructions) !!}
                        </div>
                        </p>

                        <form method="POST" action="{{ route('become-instructor.create') }}" class="account__form" enctype="multipart/form-data">
                            @csrf

                            @if ($instructorRequestSetting?->need_certificate == 1)
                            <div class="from-group mb-3">
                                <label for="">{{ __('Certificate and documents') }} <code>*</code"></label>
                                <input type="file" class="form-control" name="certificate">
                            </div>
                            @endif

                            @if ($instructorRequestSetting?->need_identity_scan == 1)
                            <div class="from-group mb-3">
                                <label for="">{{ __('Certificate and documents') }} <code>*</code"></label>
                                <input type="file" class="form-control" name="identity_scan">
                            </div>
                            @endif

                            <div class="form-grp">
                                <label for="payout_account">{{ __('Payout Account') }} <code>*</code></label>
                                <select name="payout_account" id="payout_account" class="form-select">
                                    <option value="">{{ __('Select') }}</option>
                                    @foreach ($withdrawMethods as $method)  
                                        <option  value="{{ $method->name }}">{{ $method->name }}</option>
                                    @endforeach

                                </select>
                            </div>

                            <div class=" payment_info_wrap d-none">
                                <div class="form-grp">
                                    <label for="payment_information">{{ __('Payment Information') }} <code>*</code></label>
                                    @foreach ($withdrawMethods as $method)  
                                    <div class="normal-text payment-{{ $method->name }} payment-info">
                                        {!! clean($method->description) !!}
                                    </div>
                                    @endforeach

                                    <textarea name="payout_information" placeholder="{{ __('Information') }}"></textarea>
                                </div>
                            </div>

                            <div class="form-grp">
                                <label for="extra_information">{{ __('Extra Information') }}</label>
                                <textarea name="extra_information" placeholder="{{ __('Extra Information') }}" id="extra_information"></textarea>
                            </div>

                            <!-- g-recaptcha -->
                            @if (Cache::get('setting')->recaptcha_status === 'active')
                            <div class="form-grp mt-3">
                                <div class="g-recaptcha" data-sitekey="{{ Cache::get('setting')->recaptcha_site_key }}"></div>
                            </div>
                            @endif
                            <button type="submit" class="btn btn-two arrow-btn">{{ __('Submit for Review') }}<img
                                    src="{{ asset('frontend/img/icons/right_arrow.svg') }}" alt="img"
                                    class="injectable"></button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- singUp-area-end -->
@endsection
