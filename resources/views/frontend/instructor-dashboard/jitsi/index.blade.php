@extends('frontend.instructor-dashboard.layouts.master')

@section('dashboard-contents')
    <div class="dashboard__content-wrap">
        <div class="dashboard__content-title">
            <h4 class="title">{{ __('Jitsi live setting') }}</h4>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="instructor__profile-form-wrap">
                    <div class="row">
                        <form action="{{ route('instructor.jitsi-setting.update') }}" method="POST" enctype="multipart/form-data"
                            class="col-xl-6 instructor__profile-form">
                            @csrf
                            @method('PUT')
                            <div class="form-grp">
                                <label for="app_id">{{ __('App ID') }} <code>*</code></label>
                                <input id="app_id" name="app_id" type="text" value="{{ $credential?->app_id }}">
                            </div>
                            <div class="form-grp">
                                <label for="api_key">{{ __('App key') }} <code>*</code></label>
                                <input id="api_key" name="api_key" type="text"
                                    value="{{ $credential?->api_key }}">
                            </div>
                            <div class="form-grp">
                                <label for="api_key">{{ __('RSA Private key') }} <code>*</code></label>
                                <input type="file" name="private_key">
                            </div>
                            <div class="submit-btn mt-25">
                                <button type="submit" class="btn">{{ __('Update') }}</button>
                            </div>
                        </form>
                        <div class="col-xl-6">
                            <div class="alert alert-warning" role="alert">
                                <h4 class="alert-heading">How do I obtain Jitsi credentials?</h4>
                                <p>1. Log in to <a href="https://jaas.8x8.vc/" target="_blank">Jitsi as a Service</a></p>
                                <p>2. Navigate to the <a href="https://jaas.8x8.vc/#/apikeys"target="_blank">API keys section,</a>. where you'll see your App ID and a list of API keys.</p>
                                <p>3. Click the <b>"Add API Key"</b> button.</p> 
                                <p>4. Click the <b>"Generate API Key Pair"</b> button.</p> 
                                <p>5. Download the <b>RSA private key</b></p> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
