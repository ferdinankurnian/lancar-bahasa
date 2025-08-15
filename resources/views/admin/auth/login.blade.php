@extends('admin.auth.app')
@section('title')
    <title>{{ __('Login') }}</title>
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
                        <h4>{{ __('Welcome to Admin Login') }}</h4>
                    </div>

                    <div class="card-body">
                        <form novalidate="" id="adminLoginForm" action="{{ route('admin.store-login') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="email">{{ __('Email') }}</label>

                                <input id="email exampleInputEmail" type="email" class="form-control" name="email"
                                    tabindex="1" autofocus value="{{ old('email') }}">
                            </div>

                            <div class="form-group">
                                <div class="d-block">
                                    <label for="password" class="control-label">{{ __('Password') }}</label>
                                    <div class="float-right">
                                        <a href="{{ route('admin.password.request') }}" class="text-small">
                                            {{ __('Forgot Password?') }}
                                        </a>
                                    </div>
                                </div>
                                <input id="password exampleInputPassword" type="password" class="form-control"
                                        name="password" tabindex="2">
                            </div>

                            <div class="form-group">
                                <button id="adminLoginBtn" type="submit" class="btn btn-primary btn-lg btn-block"
                                    tabindex="4">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

        </div>
    </section>
@endsection
