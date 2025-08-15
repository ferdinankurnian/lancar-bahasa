@extends('frontend.layouts.master')
@section('meta_title', 'Forget Password'. ' | ' . $setting->app_name)

@section('contents')
    <!-- breadcrumb-area -->
    <x-frontend.breadcrumb
        :title="__('Forgot Password')"
        :links="[
            ['url' => route('home'), 'text' => __('Home')],
            ['url' => route('password.request'), 'text' => __('Forgot Password')],
        ]"
    />
    <!-- breadcrumb-area-end -->

    <!-- singUp-area -->
    <section class="singUp-area section-py-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-8">
                    <div class="singUp-wrap">
                        <h2 class="title">{{ __('Forgot your password?') }}</h2>
                        <p>{{ __('Enter your email address and we will send you a link to reset your password') }}
                        </p>

                        <form method="POST" action="{{ route('forget-password') }}" class="account__form">
                            @csrf
                            <div class="form-grp">
                                <label for="email">{{ __('Email') }} <code>*</code></label>
                                <input id="email" type="text" placeholder="email" name="email">
                                <x-frontend.validation-error name="email" />
                            </div>

                            <!-- g-recaptcha -->
                            @if (Cache::get('setting')->recaptcha_status === 'active')
                            <div class="form-grp mt-3">
                                <div class="g-recaptcha" data-sitekey="{{ Cache::get('setting')->recaptcha_site_key }}"></div>
                                <x-frontend.validation-error name="g-recaptcha-response" />
                            </div>
                            @endif

                            <button type="submit" class="btn btn-two arrow-btn">{{ __('Send Reset Link') }}<img
                                    src="{{ asset('frontend/img/icons/right_arrow.svg') }}" alt="img"
                                    class="injectable"></button>
                        </form>
                        <div class="account__switch">
                            <p>{{ __('Already have an account?') }}<a href="{{ route('login') }}">{{ __('Sign in') }}</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- singUp-area-end -->
@endsection
