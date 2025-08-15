@extends('frontend.layouts.master')
@section('meta_title', $page->translation->name. ' || ' . $setting->app_name)
@section('contents')
    <!-- breadcrumb-area -->
    <x-frontend.breadcrumb :title="$page->translation->name" :links="[['url' => route('home'), 'text' => __('Home')], ['url' => '', 'text' => $page->translation->name]]" />
    <!-- breadcrumb-area-end -->

    <section class="about-area-three section-py-120">
        <div class="container">
            <div class="card singUp-wrap custom-page-body">
                <div class="card-body">
                    {!! clean($page->translation->content) !!}
                    <a href="{{ route('home') }}" class="btn btn-primary custom-page-button mt-4">{{ __('Go to Home') }}</a>
                </div>
            </div>

        </div>
    </section>
   
@endsection
