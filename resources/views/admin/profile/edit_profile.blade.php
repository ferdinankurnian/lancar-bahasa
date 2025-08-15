@extends('admin.master_layout')
@section('title')
    <title>{{ __('Edit Profile') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Edit Profile') }}</h1>
            </div>

            {{-- edit profile area  --}}
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card profile-widget">
                            <div class="profile-widget-header">
                                <img alt="image" id="profileImgPreview"
                                    src="{{ $admin->image ? asset($admin->image) : '' }}"
                                    class="rounded-circle profile-widget-picture">
                            </div>

                            <div class="profile-widget-description">

                                <form @adminCan('admin.profile.update') action="{{ route('admin.profile-update') }}"
                                    @endadminCan enctype="multipart/form-data" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label>{{ __('New Image') }}</label>
                                            <input id="profileImgInput" type="file" class="form-control-file"
                                                name="image">
                                        </div>

                                        <div class="form-group col-12">
                                            <label>{{ __('Name') }} <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" value="{{ $admin->name }}"
                                                name="name">
                                        </div>

                                        <div class="form-group col-12">
                                            <label>{{ __('Email') }} <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" value="{{ $admin->email }}"
                                                name="email">
                                        </div>
                                        <div class="form-group col-12">
                                            <label>{{ __('Bio') }} <span class="text-danger">*</span></label>
                                            <textarea name="bio" class="form-control">{{ $admin->bio }}</textarea>
                                        </div>
                                    </div>
                                    @adminCan('admin.profile.update')
                                        <div class="row">
                                            <div class="col-12">
                                                <button class="btn btn-primary">{{ __('Update') }}</button>
                                            </div>
                                        </div>
                                    @endadminCan
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            {{-- edit profile area  --}}

            {{-- edit password area --}}

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card ">
                            <div class="card-body">
                                <form @adminCan('admin.profile.update') action="{{ route('admin.update-password') }}"
                                    @endadminCan enctype="multipart/form-data" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">

                                        <div class="form-group col-12">
                                            <label>{{ __('Current Password') }} <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" name="current_password">
                                        </div>

                                        <div class="form-group col-12">
                                            <label>{{ __('Password') }} <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" name="password">
                                        </div>

                                        <div class="form-group col-12">
                                            <label>{{ __('Confirm Password') }} <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" name="password_confirmation">
                                        </div>

                                    </div>
                                    @adminCan('admin.profile.update')
                                        <div class="row">
                                            <div class="col-12">
                                                <button class="btn btn-primary">{{ __('Update') }}</button>
                                            </div>
                                        </div>
                                    @endadminCan
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- edit password area --}}

        </section>
    </div>
@endsection
@push('js')
    <script>
        //input image preview function
        "use strict";
        $(document).ready(function() {
            setupImagePreview('profileImgInput', 'profileImgPreview');
        });
    </script>
@endpush
