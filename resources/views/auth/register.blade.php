@extends('frontend.layouts.master')
@section('meta_title', 'Register'. ' | ' . $setting->app_name)

@section('contents')
    <!-- breadcrumb-area -->
    <!-- <x-frontend.breadcrumb :title="__('Register')" :links="[['url' => route('home'), 'text' => __('Home')], ['url' => route('register'), 'text' => __('Register')]]" /> -->
    <!-- breadcrumb-area-end -->

    <!-- singUp-area -->
    <section class="singUp-area section-py-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-8">
                    <div class="singUp-wrap">
                        <h2 class="title">{{ __('Create Your Account') }}</h2>
                        <p>{{ __('Hey there! Ready to join the party? We just need a few details from you to get') }}<br>{{ __('started Lets do this!') }}
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
                        <form method="POST" action="{{ route('register') }}" class="account__form">
                            @csrf
                            
                            <div class="row gutter-20">
                                <div class="col-md-12">
                                    <div class="form-grp">
                                        <label for="fast-name">{{ __('Full Name') }}</label>
                                        <input type="text" id="fast-name" placeholder="{{ __('full name') }}"
                                            name="name">
                                        <x-frontend.validation-error name="name" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-grp">
                                <label for="email">{{ __('Email') }}</label>
                                <input type="email" id="email" placeholder="{{ __('email') }}" name="email">
                                <x-frontend.validation-error name="email" />
                            </div>
                            <div class="form-grp">
                                <label for="password">{{ __('Password') }}</label>
                                <input type="password" id="password" placeholder="{{ __('password') }}" name="password">
                                <x-frontend.validation-error name="password" />
                            </div>
                            <div class="form-grp">
                                <label for="confirm-password">{{ __('Confirm Password') }}</label>
                                <input type="password" id="confirm-password" placeholder="{{ __('Confirm Password') }}"
                                    name="password_confirmation">
                                <x-frontend.validation-error name="password_confirmation" />
                            </div>

                            <!-- g-recaptcha -->
                            @if (Cache::get('setting')->recaptcha_status === 'active')
                                <div class="form-grp mt-3">
                                    <div class="g-recaptcha"
                                        data-sitekey="{{ Cache::get('setting')->recaptcha_site_key }}"></div>
                                    <x-frontend.validation-error name="g-recaptcha-response" />
                                </div>
                            @endif

                            <button type="submit" class="btn btn-two arrow-btn">{{ __('Sign Up') }}<img
                                    src="{{ asset('frontend/img/icons/right_arrow.svg') }}" alt="img"
                                    class="injectable"></button>
                        </form>
                        <div class="account__switch">
                            <p>{{ __('Already have an account?') }}<a href="{{ route('login') }}">{{ __('Login') }}</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- singUp-area-end -->
@endsection
