@extends('frontend.layouts.master')
@section('meta_title', 'Login'. ' | ' . $setting->app_name)
@section('contents')
    <!-- breadcrumb-area -->
    <!-- <x-frontend.breadcrumb
        :title="__('Login')"
        :links="[
            ['url' => route('home'), 'text' => __('Home')],
            ['url' => route('login'), 'text' => __('Login')],
        ]"
    /> -->
    <!-- breadcrumb-area-end -->

    <!-- singUp-area -->
    <section class="singUp-area section-py-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-8">
                    <div class="singUp-wrap">
                        <h2 class="title">{{ __('Welcome back!') }}</h2>
                        <p>{{ __('Hey there! Ready to log in? Just enter your email and password below and you will be back in action in no time. Lets go!') }}
                        </p>
                        @if($setting->google_login_status == 'active')
                        <div class="account__social">
                            <a href="{{ route('auth.social', 'google') }}" class="account__social-btn">
                                <img src="{{ asset('frontend/img/icons/google.svg') }}" alt="img">
                                {{ __('Continue with google') }}
                            </a>
                        </div>
                        <div class="account__divider">
                            <span>{{ __('or') }}</span>
                        </div>
                        @endif
                        <form method="POST" action="{{ route('user-login') }}" class="account__form">
                            @csrf
                            <div class="form-grp">
                                <label for="email">{{ __('Email') }} <code>*</code></label>
                                <input id="email" type="text" placeholder="email" value="{{ old('email') }}" name="email">
                                <x-frontend.validation-error name="email" />
                            </div>
                            <div class="form-grp">
                                <label for="password">{{ __('Password') }} <code>*</code></label>
                                <input id="password" type="password" placeholder="password" name="password">
                            </div>
                            <div class="account__check">
                                <div class="account__check-remember">
                                    <input type="checkbox" class="form-check-input" name="remember" value=""
                                        id="terms-check">
                                    <label for="terms-check" class="form-check-label">{{ __('Remember me') }}</label>
                                </div>
                                <div class="account__check-forgot">
                                    <a href="{{ route('password.request') }}">{{ __('Forgot Password?') }}</a>
                                </div>
                            </div>
                            <!-- g-recaptcha -->
                            @if (Cache::get('setting')->recaptcha_status === 'active')
                            <div class="form-grp mt-3">
                                <div class="g-recaptcha" data-sitekey="{{ Cache::get('setting')->recaptcha_site_key }}"></div>
                                <x-frontend.validation-error name="g-recaptcha-response" />
                            </div>
                            @endif
                            <button type="submit" class="btn btn-two arrow-btn">{{ __('Sign In') }}<img
                                    src="{{ asset('frontend/img/icons/right_arrow.svg') }}" alt="img"
                                    class="injectable"></button>
                        </form>
                        <div class="account__switch">
                            <p>{{ __('Dont have an account?') }}<a href="{{ route('register') }}">{{ __('Sign Up') }}</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- singUp-area-end -->
@endsection
