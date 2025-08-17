@extends('frontend.layouts.master')
@section('title')
    <title>{{ __('Transaction Unfinished') }}</title>
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center py-5">
                <h2 class="text-warning">{{ __('Transaction Unfinished') }}</h2>
                <p>{{ __('Your transaction was not completed. Please try again or contact support if you have any issues.') }}</p>
                <a href="{{ route('home') }}" class="btn btn-primary mt-3">{{ __('Go to Home') }}</a>
            </div>
        </div>
    </div>
@endsection