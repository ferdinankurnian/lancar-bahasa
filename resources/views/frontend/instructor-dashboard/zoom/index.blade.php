@extends('frontend.instructor-dashboard.layouts.master')

@section('dashboard-contents')
    <div class="dashboard__content-wrap">
        <div class="dashboard__content-title">
            <h4 class="title">{{ __('Zoom live setting') }}</h4>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="instructor__profile-form-wrap">
                    <div class="row">
                        <form action="{{ route('instructor.zoom-setting.update') }}" method="POST"
                            class="col-xl-6 instructor__profile-form">
                            @csrf
                            @method('PUT')
                            <div class="form-grp">
                                <label for="client_id">{{ __('Client ID') }} <code>*</code></label>
                                <input id="client_id" name="client_id" type="text" value="{{ $credential?->client_id }}">
                            </div>
                            <div class="form-grp">
                                <label for="client_secret">{{ __('Client secret') }} <code>*</code></label>
                                <input id="client_secret" name="client_secret" type="text"
                                    value="{{ $credential?->client_secret }}">
                            </div>
                            <div class="submit-btn mt-25">
                                <button type="submit" class="btn">{{ __('Update') }}</button>
                            </div>
                        </form>
                        <div class="col-xl-6">
                            <div class="alert alert-warning" role="alert">
                                <h4 class="alert-heading">How to build a Zoom Meeting SDK?</h4>
                                <p>1. Log in to the <a href="https://marketplace.zoom.us/" target="_blank">Zoom Marketplace</a>
                                </p>
                                <p>2. Navigate to the <a href="https://marketplace.zoom.us/develop/createLegacy"
                                        target="_blank">Build Legacy App section</a>. You'll see a list of available app types.</p>
                                <p>3. In the <b>Meeting SDK</b> section, click  <b>Create</b>.</p> 
                                <p>4. Add a name for your app and click  Enter a name for your app and click <b>Create</b>.</p>
                                <p>5. View your <b>client ID</b> and <b>client secret</b>. These credentials will be used in this section.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
