@extends('admin.auth.app')
@section('title')
    <title>{{ __('Forgot Password') }}</title>
@endsection
@section('content')
    <section class="section">
        <div class="container login-wrapper">
                <div class="col-md-12 col-lg-4">
                    <div class="login-brand">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset($setting?->logo) }}" alt="{{ $setting?->app_name }}" width="220">
                        </a>
                    </div>
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>{{ __('Forgot Password') }}</h4>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('admin.forget-password') }}" method="POST">
                                @csrf

                                <div class="form-group">
                                    <label for="email">{{ __('Email') }}</label>
                                    <input id="email exampleInputEmail" type="email" class="form-control" name="email"
                                        tabindex="1" autofocus placeholder="{{ old('email') }}">
                                </div>
                                <div class="form-group">
                                    <button id="adminLoginBtn" type="submit" class="btn btn-primary btn-lg btn-block"
                                        tabindex="4">
                                        {{ __('Send Reset Link') }}
                                    </button>
                                </div>
                                <div class="form-group">
                                    <div class="d-block">
                                        <a href="{{ route('admin.login') }}">
                                            {{ __('Go to login page') }} -> </a>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
        </div>
    </section>
@endsection
