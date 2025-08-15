@extends('admin.master_layout')
@section('title')
    <title>{{ __('Instructor Badges') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Instructor Badges') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                    </div>
                    <div class="breadcrumb-item">{{ __('Instructor badges') }}</div>
                </div>
            </div>
            <div class="section-body">

                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Instructor Badges') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-lg-3 col-xl-3">
                                <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active show" id="home-tab4" data-toggle="tab" href="#home4"
                                            role="tab" aria-controls="home"
                                            aria-selected="false">{{ __('Registration Age Badge') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link show" id="profile-tab4" data-toggle="tab" href="#profile4"
                                            role="tab" aria-controls="profile"
                                            aria-selected="true">{{ __('Course Count Badge') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="contact-tab4" data-toggle="tab" href="#contact4"
                                            role="tab" aria-controls="contact"
                                            aria-selected="false">{{ __('Course Rating Badge') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="contact-tab5" data-toggle="tab" href="#contact5"
                                            role="tab" aria-controls="contact"
                                            aria-selected="false">{{ __('Course Enroll Badge') }}</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-12 col-lg-9 col-xl-9">
                                <div class="tab-content no-padding" id="myTab2Content">
                                    <div class="tab-pane fade show active" id="home4" role="tabpanel"
                                        aria-labelledby="home-tab4">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-6">
                                                <div class="card border">
                                                    <div class="card-body">
                                                        <h6 class="bages_heading">{{ __('Badge One') }}</h6>
                                                        <form action="{{ route('admin.registration-badge') }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="key"
                                                                value="registration_badge_one">
                                                            <div class="form-group">
                                                                <label>{{ __('Badge Image') }}</label>
                                                                <div id="image-preview-1" class="image-preview">
                                                                    <label for="image-upload-1"
                                                                        id="image-label-1">{{ __('Image') }}</label>
                                                                    <input type="file" name="image"
                                                                        id="image-upload-1">
                                                                </div>

                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="name">{{ __('Name') }}<span
                                                                            class="text-danger">*</span></label>
                                                                        <input type="text" name="name" id="name"
                                                                            class="form-control"
                                                                            value="{{ array_key_exists('registration_badge_one', $badges) ? $badges['registration_badge_one'][0]['name'] : '' }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label for="from">{{ __('From Day') }}
                                                                            <code>*</code></label>
                                                                        <input type="text" name="from" id="from"
                                                                            class="form-control"
                                                                            value="{{ array_key_exists('registration_badge_one', $badges) ? $badges['registration_badge_one'][0]['condition_from'] : '' }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label for="to">{{ __('To Day') }}
                                                                            <code>*</code></label>
                                                                        <input type="text" name="to" id="to"
                                                                            class="form-control"
                                                                            value="{{ array_key_exists('registration_badge_one', $badges) ? $badges['registration_badge_one'][0]['condition_to'] : '' }}">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="">
                                                                <button
                                                                    class="btn btn-primary">{{ __('Save') }}</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                                <div class="card border">
                                                    <div class="card-body">
                                                        <h6 class="bages_heading">{{ __('Badge Two') }}</h6>
                                                        <form action="{{ route('admin.registration-badge') }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="key"
                                                                value="registration_badge_two">
                                                            <div class="form-group">
                                                                <label>{{ __('Badge Image') }}</label>
                                                                <div id="image-preview-2" class="image-preview">
                                                                    <label for="image-upload-2"
                                                                        id="image-label-2">{{ __('Image') }}</label>
                                                                    <input type="file" name="image"
                                                                        id="image-upload-2">
                                                                </div>

                                                            </div>
                                                            <div class="row">

                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="name">{{ __('Name') }}<span
                                                                            class="text-danger">*</span></label>
                                                                        <input type="text" name="name"
                                                                            id="name" class="form-control"
                                                                            value="{{ array_key_exists('registration_badge_two', $badges) ? $badges['registration_badge_two'][0]['name'] : '' }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label for="from_2">{{ __('From Day') }}
                                                                            <code>*</code></label>
                                                                        <input type="text" name="from"
                                                                            id="from_2" class="form-control"
                                                                            value="{{ array_key_exists('registration_badge_two', $badges) ? $badges['registration_badge_two'][0]['condition_from'] : '' }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label for="to_2">{{ __('To Day') }}
                                                                            <code>*</code></label>
                                                                        <input type="text" name="to"
                                                                            id="to_2" class="form-control"
                                                                            value="{{ array_key_exists('registration_badge_two', $badges) ? $badges['registration_badge_two'][0]['condition_to'] : '' }}">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="">
                                                                <button
                                                                    class="btn btn-primary">{{ __('Save') }}</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6">

                                                <div class="card border">
                                                    <div class="card-body">
                                                        <h6 class="bages_heading last_child">{{ __('Badge Three') }}</h6>
                                                        <form action="{{ route('admin.registration-badge') }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="key"
                                                                value="registration_badge_three">
                                                            <div class="form-group">
                                                                <label>{{ __('Badge Image') }}</label>
                                                                <div id="image-preview-3" class="image-preview">
                                                                    <label for="image-upload-3"
                                                                        id="image-label-3">{{ __('Image') }}</label>
                                                                    <input type="file" name="image"
                                                                        id="image-upload-3">
                                                                </div>

                                                            </div>
                                                            <div class="row">

                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="name">{{ __('Name') }}<span
                                                                            class="text-danger">*</span></label>
                                                                        <input type="text" name="name"
                                                                            id="name" class="form-control"
                                                                            value="{{ array_key_exists('registration_badge_three', $badges) ? $badges['registration_badge_three'][0]['name'] : '' }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label for="from">{{ __('From Day') }}
                                                                            <code>*</code></label>
                                                                        <input type="text" name="from"
                                                                            id="from" class="form-control"
                                                                            value="{{ array_key_exists('registration_badge_three', $badges) ? $badges['registration_badge_three'][0]['condition_from'] : '' }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label for="to">{{ __('To Day') }}
                                                                            <code>*</code></label>
                                                                        <input type="text" name="to"
                                                                            id="to" class="form-control"
                                                                            value="{{ array_key_exists('registration_badge_three', $badges) ? $badges['registration_badge_three'][0]['condition_to'] : '' }}">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="">
                                                                <button
                                                                    class="btn btn-primary">{{ __('Save') }}</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="profile4" role="tabpanel"
                                        aria-labelledby="profile-tab4">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-6">
                                                <div class="card border">
                                                    <div class="card-body">
                                                        <h6 class="bages_heading">{{ __('Badge One') }}</h6>
                                                        <form action="{{ route('admin.registration-badge') }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="key"
                                                                value="course_count_badge_one">
                                                            <div class="form-group">
                                                                <label>{{ __('Badge Image') }}</label>
                                                                <div id="image-preview-4" class="image-preview">
                                                                    <label for="image-upload-4"
                                                                        id="image-label-4">{{ __('Image') }}</label>
                                                                    <input type="file" name="image"
                                                                        id="image-upload-4">
                                                                </div>
                                                                @error('image')
                                                                @enderror
                                                            </div>
                                                            <div class="row">

                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="name">{{ __('Name') }}<span
                                                                            class="text-danger">*</span></label>
                                                                        <input type="text" name="name"
                                                                            id="name" class="form-control"
                                                                            value="{{ array_key_exists('course_count_badge_one', $badges) ? $badges['course_count_badge_one'][0]['name'] : '' }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="from">{{ __('From course count') }}
                                                                            <code>*</code></label>
                                                                        <input type="text" name="from"
                                                                            id="from" class="form-control"
                                                                            value="{{ array_key_exists('course_count_badge_one', $badges) ? $badges['course_count_badge_one'][0]['condition_from'] : '' }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="to">{{ __('To course count') }}
                                                                            <code>*</code></label>
                                                                        <input type="text" name="to"
                                                                            id="to" class="form-control"
                                                                            value="{{ array_key_exists('course_count_badge_one', $badges) ? $badges['course_count_badge_one'][0]['condition_to'] : '' }}">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="">
                                                                <button
                                                                    class="btn btn-primary">{{ __('Save') }}</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                                <div class="card border">
                                                    <div class="card-body">
                                                        <h6 class="bages_heading">{{ __('Badge Two') }}</h6>
                                                        <form action="{{ route('admin.registration-badge') }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="key"
                                                                value="course_count_badge_two">
                                                            <div class="form-group">
                                                                <label>{{ __('Badge Image') }}</label>
                                                                <div id="image-preview-5" class="image-preview">
                                                                    <label for="image-upload-5"
                                                                        id="image-label-5">{{ __('Image') }}</label>
                                                                    <input type="file" name="image"
                                                                        id="image-upload-5">
                                                                </div>
                                                                @error('image')
                                                                @enderror
                                                            </div>
                                                            <div class="row">

                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="name">{{ __('Name') }}<span
                                                                            class="text-danger">*</span></label>
                                                                        <input type="text" name="name"
                                                                            id="name" class="form-control"
                                                                            value="{{ array_key_exists('course_count_badge_two', $badges) ? $badges['course_count_badge_two'][0]['name'] : '' }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="from">{{ __('From course count') }}
                                                                            <code>*</code></label>
                                                                        <input type="text" name="from"
                                                                            id="from" class="form-control"
                                                                            value="{{ array_key_exists('course_count_badge_two', $badges) ? $badges['course_count_badge_two'][0]['condition_from'] : '' }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="to">{{ __('To course count') }}
                                                                            <code>*</code></label>
                                                                        <input type="text" name="to"
                                                                            id="to" class="form-control"
                                                                            value="{{ array_key_exists('course_count_badge_two', $badges) ? $badges['course_count_badge_two'][0]['condition_to'] : '' }}">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="">
                                                                <button
                                                                    class="btn btn-primary">{{ __('Save') }}</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                                <div class="card border">
                                                    <div class="card-body">
                                                        <h6 class="bages_heading">{{ __('Badge Three') }}</h6>
                                                        <form action="{{ route('admin.registration-badge') }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="key"
                                                                value="course_count_badge_three">
                                                            <div class="form-group">
                                                                <label>{{ __('Badge Image') }}</label>
                                                                <div id="image-preview-6" class="image-preview">
                                                                    <label for="image-upload-6"
                                                                        id="image-label-6">{{ __('Image') }}</label>
                                                                    <input type="file" name="image"
                                                                        id="image-upload-6">
                                                                </div>
                                                                @error('image')
                                                                @enderror
                                                            </div>
                                                            <div class="row">

                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="name">{{ __('Name') }}<span
                                                                            class="text-danger">*</span></label>
                                                                        <input type="text" name="name"
                                                                            id="name" class="form-control"
                                                                            value="{{ array_key_exists('course_count_badge_three', $badges) ? $badges['course_count_badge_three'][0]['name'] : '' }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="from">{{ __('From course count') }}
                                                                            <code>*</code></label>
                                                                        <input type="text" name="from"
                                                                            id="from" class="form-control"
                                                                            value="{{ array_key_exists('course_count_badge_three', $badges) ? $badges['course_count_badge_three'][0]['condition_from'] : '' }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="to">{{ __('To course count') }}
                                                                            <code>*</code></label>
                                                                        <input type="text" name="to"
                                                                            id="to" class="form-control"
                                                                            value="{{ array_key_exists('course_count_badge_three', $badges) ? $badges['course_count_badge_three'][0]['condition_to'] : '' }}">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="">
                                                                <button
                                                                    class="btn btn-primary">{{ __('Save') }}</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="contact4" role="tabpanel"
                                        aria-labelledby="contact-tab4">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-6">
                                                <div class="card border">
                                                    <div class="card-body">
                                                        <h6 class="bages_heading">{{ __('Badge One') }}</h6>
                                                        <form action="{{ route('admin.registration-badge') }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="key"
                                                                value="course_rating_badge_one">
                                                            <div class="form-group">
                                                                <label>{{ __('Badge Image') }}</label>
                                                                <div id="image-preview-7" class="image-preview">
                                                                    <label for="image-upload-7"
                                                                        id="image-label-7">{{ __('Image') }}</label>
                                                                    <input type="file" name="image"
                                                                        id="image-upload-7">
                                                                </div>
                                                            </div>
                                                            <div class="row">

                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="name">{{ __('Name') }}<span
                                                                            class="text-danger">*</span></label>
                                                                        <input type="text" name="name"
                                                                            id="name" class="form-control"
                                                                            value="{{ array_key_exists('course_rating_badge_one', $badges) ? $badges['course_rating_badge_one'][0]['name'] : '' }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="from">{{ __('From rating count') }}
                                                                            <code>*</code></label>
                                                                        <input type="text" name="from"
                                                                            id="from" class="form-control"
                                                                            value="{{ array_key_exists('course_rating_badge_one', $badges) ? $badges['course_rating_badge_one'][0]['condition_from'] : '' }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="to">{{ __('To rating count') }}
                                                                            <code>*</code></label>
                                                                        <input type="text" name="to"
                                                                            id="to" class="form-control"
                                                                            value="{{ array_key_exists('course_rating_badge_one', $badges) ? $badges['course_rating_badge_one'][0]['condition_to'] : '' }}">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="">
                                                                <button
                                                                    class="btn btn-primary">{{ __('Save') }}</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6">

                                                <div class="card border">
                                                    <div class="card-body">
                                                        <h6 class="bages_heading">{{ __('Badge Two') }}</h6>
                                                        <form action="{{ route('admin.registration-badge') }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="key"
                                                                value="course_rating_badge_two">
                                                            <div class="form-group">
                                                                <label>{{ __('Badge Image') }}</label>
                                                                <div id="image-preview-8" class="image-preview">
                                                                    <label for="image-upload-8"
                                                                        id="image-label-8">{{ __('Image') }}</label>
                                                                    <input type="file" name="image"
                                                                        id="image-upload-8">
                                                                </div>
                                                                @error('image')
                                                                @enderror
                                                            </div>
                                                            <div class="row">

                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="name">{{ __('Name') }}<span
                                                                            class="text-danger">*</span></label>
                                                                        <input type="text" name="name"
                                                                            id="name" class="form-control"
                                                                            value="{{ array_key_exists('course_rating_badge_two', $badges) ? $badges['course_rating_badge_two'][0]['name'] : '' }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="from">{{ __('From rating count') }}
                                                                            <code>*</code></label>
                                                                        <input type="text" name="from"
                                                                            id="from" class="form-control"
                                                                            value="{{ array_key_exists('course_rating_badge_two', $badges) ? $badges['course_rating_badge_two'][0]['condition_from'] : '' }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="to">{{ __('To rating count') }}
                                                                            <code>*</code></label>
                                                                        <input type="text" name="to"
                                                                            id="to" class="form-control"
                                                                            value="{{ array_key_exists('course_rating_badge_two', $badges) ? $badges['course_rating_badge_two'][0]['condition_to'] : '' }}">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="">
                                                                <button
                                                                    class="btn btn-primary">{{ __('Save') }}</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6">

                                                <div class="card border">
                                                    <div class="card-body">
                                                        <h6 class="bages_heading">{{ __('Badge Three') }}</h6>
                                                        <form action="{{ route('admin.registration-badge') }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="key"
                                                                value="course_rating_badge_three">
                                                            <div class="form-group">
                                                                <label>{{ __('Badge Image') }}</label>
                                                                <div id="image-preview-9" class="image-preview">
                                                                    <label for="image-upload-9"
                                                                        id="image-label-9">{{ __('Image') }}</label>
                                                                    <input type="file" name="image"
                                                                        id="image-upload-9">
                                                                </div>
                                                                @error('image')
                                                                @enderror
                                                            </div>
                                                            <div class="row">

                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="name">{{ __('Name') }}<span
                                                                            class="text-danger">*</span></label>
                                                                        <input type="text" name="name"
                                                                            id="name" class="form-control"
                                                                            value="{{ array_key_exists('course_rating_badge_three', $badges) ? $badges['course_rating_badge_three'][0]['name'] : '' }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="from">{{ __('From rating count') }}
                                                                            <code>*</code></label>
                                                                        <input type="text" name="from"
                                                                            id="from" class="form-control"
                                                                            value="{{ array_key_exists('course_rating_badge_three', $badges) ? $badges['course_rating_badge_three'][0]['condition_from'] : '' }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="to">{{ __('To rating count') }}
                                                                            <code>*</code></label>
                                                                        <input type="text" name="to"
                                                                            id="to" class="form-control"
                                                                            value="{{ array_key_exists('course_rating_badge_three', $badges) ? $badges['course_rating_badge_three'][0]['condition_to'] : '' }}">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="">
                                                                <button
                                                                    class="btn btn-primary">{{ __('Save') }}</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="contact5" role="tabpanel"
                                        aria-labelledby="contact-tab5">

                                        <div class="row">
                                            <div class="col-lg-4 col-md-6">
                                                <div class="card border">
                                                    <div class="card-body">
                                                        <h6 class="bages_heading">{{ __('Badge One') }}</h6>
                                                        <form action="{{ route('admin.registration-badge') }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="key"
                                                                value="course_enroll_badge_one">
                                                            <div class="form-group">
                                                                <label>{{ __('Badge Image') }}</label>
                                                                <div id="image-preview-10" class="image-preview">
                                                                    <label for="image-upload-10"
                                                                        id="image-label-10">{{ __('Image') }}</label>
                                                                    <input type="file" name="image"
                                                                        id="image-upload-10">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="name">{{ __('Name') }}<span
                                                                            class="text-danger">*</span></label>
                                                                        <input type="text" name="name"
                                                                            id="name" class="form-control"
                                                                            value="{{ array_key_exists('course_enroll_badge_one', $badges) ? $badges['course_enroll_badge_one'][0]['name'] : '' }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="from">{{ __('From enroll count') }}
                                                                            <code>*</code></label>
                                                                        <input type="text" name="from"
                                                                            id="from" class="form-control"
                                                                            value="{{ array_key_exists('course_enroll_badge_one', $badges) ? $badges['course_enroll_badge_one'][0]['condition_from'] : '' }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="to">{{ __('To enroll count') }}
                                                                            <code>*</code></label>
                                                                        <input type="text" name="to"
                                                                            id="to" class="form-control"
                                                                            value="{{ array_key_exists('course_enroll_badge_one', $badges) ? $badges['course_enroll_badge_one'][0]['condition_to'] : '' }}">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="">
                                                                <button
                                                                    class="btn btn-primary">{{ __('Save') }}</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                                <div class="card border">
                                                    <div class="card-body">
                                                        <h6 class="bages_heading">{{ __('Badge Two') }}</h6>
                                                        <form action="{{ route('admin.registration-badge') }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="key"
                                                                value="course_enroll_badge_two">
                                                            <div class="form-group">
                                                                <label>{{ __('Badge Image') }}</label>
                                                                <div id="image-preview-11" class="image-preview">
                                                                    <label for="image-upload-11"
                                                                        id="image-label-11">{{ __('Image') }}</label>
                                                                    <input type="file" name="image"
                                                                        id="image-upload-11">
                                                                </div>

                                                            </div>
                                                            <div class="row">

                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="name">{{ __('Name') }}<span
                                                                            class="text-danger">*</span></label>
                                                                        <input type="text" name="name"
                                                                            id="name" class="form-control"
                                                                            value="{{ array_key_exists('course_enroll_badge_two', $badges) ? $badges['course_enroll_badge_two'][0]['name'] : '' }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="from">{{ __('From enroll count') }}
                                                                            <code>*</code></label>
                                                                        <input type="text" name="from"
                                                                            id="from" class="form-control"
                                                                            value="{{ array_key_exists('course_enroll_badge_two', $badges) ? $badges['course_enroll_badge_two'][0]['condition_from'] : '' }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="to">{{ __('To enroll count') }}
                                                                            <code>*</code></label>
                                                                        <input type="text" name="to"
                                                                            id="to" class="form-control"
                                                                            value="{{ array_key_exists('course_enroll_badge_two', $badges) ? $badges['course_enroll_badge_two'][0]['condition_to'] : '' }}">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="">
                                                                <button
                                                                    class="btn btn-primary">{{ __('Save') }}</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                                <div class="card border">
                                                    <div class="card-body">
                                                        <h6 class="bages_heading">{{ __('Badge Three') }}</h6>
                                                        <form action="{{ route('admin.registration-badge') }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="key"
                                                                value="course_enroll_badge_three">
                                                            <div class="form-group">
                                                                <label>{{ __('Badge Image') }}</label>
                                                                <div id="image-preview-12" class="image-preview">
                                                                    <label for="image-upload-12"
                                                                        id="image-label-12">{{ __('Image') }}</label>
                                                                    <input type="file" name="image"
                                                                        id="image-upload-12">
                                                                </div>

                                                            </div>
                                                            <div class="row">

                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="name">{{ __('Name') }}<span
                                                                            class="text-danger">*</span></label>
                                                                        <input type="text" name="name"
                                                                            id="name" class="form-control"
                                                                            value="{{ array_key_exists('course_enroll_badge_three', $badges) ? $badges['course_enroll_badge_three'][0]['name'] : '' }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="from">{{ __('From enroll count') }}
                                                                            <code>*</code></label>
                                                                        <input type="text" name="from"
                                                                            id="from" class="form-control"
                                                                            value="{{ array_key_exists('course_enroll_badge_three', $badges) ? $badges['course_enroll_badge_three'][0]['condition_from'] : '' }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="to">{{ __('To enroll count') }}
                                                                            <code>*</code></label>
                                                                        <input type="text" name="to"
                                                                            id="to" class="form-control"
                                                                            value="{{ array_key_exists('course_enroll_badge_three', $badges) ? $badges['course_enroll_badge_three'][0]['condition_to'] : '' }}">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="">
                                                                <button
                                                                    class="btn btn-primary">{{ __('Save') }}</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('js')
    <script src="{{ asset('backend/js/jquery.uploadPreview.min.js') }}"></script>

    <script>
        "use strict";

        $.uploadPreview({
            input_field: "#image-upload-1",
            preview_box: "#image-preview-1",
            label_field: "#image-label-1",
            label_default: "{{ __('Choose Image') }}",
            label_selected: "{{ __('Change Image') }}",
            no_label: false,
            success_callback: null
        });
        @if (array_key_exists('registration_badge_one', $badges))
            $('#image-preview-1').css({
                'background-image': 'url({{ asset($badges['registration_badge_one'][0]['image']) }})',
                'background-size': 'contain',
                'background-position': 'center',
                'background-repeat': 'no-repeat'
            });
        @endif

        $.uploadPreview({
            input_field: "#image-upload-2",
            preview_box: "#image-preview-2",
            label_field: "#image-label-2",
            label_default: "{{ __('Choose Image') }}",
            label_selected: "{{ __('Change Image') }}",
            no_label: false,
            success_callback: null
        });
        @if (array_key_exists('registration_badge_two', $badges))
            $('#image-preview-2').css({
                'background-image': 'url({{ asset($badges['registration_badge_two'][0]['image']) }})',
                'background-size': 'contain',
                'background-position': 'center',
                'background-repeat': 'no-repeat'
            });
        @endif

        $.uploadPreview({
            input_field: "#image-upload-3",
            preview_box: "#image-preview-3",
            label_field: "#image-label-3",
            label_default: "{{ __('Choose Image') }}",
            label_selected: "{{ __('Change Image') }}",
            no_label: false,
            success_callback: null
        });
        @if (array_key_exists('registration_badge_three', $badges))
            $('#image-preview-3').css({
                'background-image': 'url({{ asset($badges['registration_badge_three'][0]['image']) }})',
                'background-size': 'contain',
                'background-position': 'center',
                'background-repeat': 'no-repeat'
            });
        @endif

        $.uploadPreview({
            input_field: "#image-upload-4",
            preview_box: "#image-preview-4",
            label_field: "#image-label-4",
            label_default: "{{ __('Choose Image') }}",
            label_selected: "{{ __('Change Image') }}",
            no_label: false,
            success_callback: null
        });
        @if (array_key_exists('course_count_badge_one', $badges))
            $('#image-preview-4').css({
                'background-image': 'url({{ asset($badges['course_count_badge_one'][0]['image']) }})',
                'background-size': 'contain',
                'background-position': 'center',
                'background-repeat': 'no-repeat'
            });
        @endif

        $.uploadPreview({
            input_field: "#image-upload-5",
            preview_box: "#image-preview-5",
            label_field: "#image-label-5",
            label_default: "{{ __('Choose Image') }}",
            label_selected: "{{ __('Change Image') }}",
            no_label: false,
            success_callback: null
        });
        @if (array_key_exists('course_count_badge_two', $badges))
            $('#image-preview-5').css({
                'background-image': 'url({{ asset($badges['course_count_badge_two'][0]['image']) }})',
                'background-size': 'contain',
                'background-position': 'center',
                'background-repeat': 'no-repeat'
            });
        @endif

        $.uploadPreview({
            input_field: "#image-upload-6",
            preview_box: "#image-preview-6",
            label_field: "#image-label-6",
            label_default: "{{ __('Choose Image') }}",
            label_selected: "{{ __('Change Image') }}",
            no_label: false,
            success_callback: null
        });
        @if (array_key_exists('course_count_badge_three', $badges))
            $('#image-preview-6').css({
                'background-image': 'url({{ asset($badges['course_count_badge_three'][0]['image']) }})',
                'background-size': 'contain',
                'background-position': 'center',
                'background-repeat': 'no-repeat'
            });
        @endif

        $.uploadPreview({
            input_field: "#image-upload-7",
            preview_box: "#image-preview-7",
            label_field: "#image-label-7",
            label_default: "{{ __('Choose Image') }}",
            label_selected: "{{ __('Change Image') }}",
            no_label: false,
            success_callback: null
        });
        @if (array_key_exists('course_rating_badge_one', $badges))
            $('#image-preview-7').css({
                'background-image': 'url({{ asset($badges['course_rating_badge_one'][0]['image']) }})',
                'background-size': 'contain',
                'background-position': 'center',
                'background-repeat': 'no-repeat'
            });
        @endif

        $.uploadPreview({
            input_field: "#image-upload-8",
            preview_box: "#image-preview-8",
            label_field: "#image-label-8",
            label_default: "{{ __('Choose Image') }}",
            label_selected: "{{ __('Change Image') }}",
            no_label: false,
            success_callback: null
        });
        @if (array_key_exists('course_rating_badge_two', $badges))
            $('#image-preview-8').css({
                'background-image': 'url({{ asset($badges['course_rating_badge_two'][0]['image']) }})',
                'background-size': 'contain',
                'background-position': 'center',
                'background-repeat': 'no-repeat'
            });
        @endif

        $.uploadPreview({
            input_field: "#image-upload-9",
            preview_box: "#image-preview-9",
            label_field: "#image-label-9",
            label_default: "{{ __('Choose Image') }}",
            label_selected: "{{ __('Change Image') }}",
            no_label: false,
            success_callback: null
        });
        @if (array_key_exists('course_rating_badge_three', $badges))
            $('#image-preview-9').css({
                'background-image': 'url({{ asset($badges['course_rating_badge_three'][0]['image']) }})',
                'background-size': 'contain',
                'background-position': 'center',
                'background-repeat': 'no-repeat'
            });
        @endif

        $.uploadPreview({
            input_field: "#image-upload-10",
            preview_box: "#image-preview-10",
            label_field: "#image-label-10",
            label_default: "{{ __('Choose Image') }}",
            label_selected: "{{ __('Change Image') }}",
            no_label: false,
            success_callback: null
        });
        @if (array_key_exists('course_enroll_badge_one', $badges))
            $('#image-preview-10').css({
                'background-image': 'url({{ asset($badges['course_enroll_badge_one'][0]['image']) }})',
                'background-size': 'contain',
                'background-position': 'center',
                'background-repeat': 'no-repeat'
            });
        @endif

        $.uploadPreview({
            input_field: "#image-upload-11",
            preview_box: "#image-preview-11",
            label_field: "#image-label-11",
            label_default: "{{ __('Choose Image') }}",
            label_selected: "{{ __('Change Image') }}",
            no_label: false,
            success_callback: null
        });
        @if (array_key_exists('course_enroll_badge_two', $badges))
            $('#image-preview-11').css({
                'background-image': 'url({{ asset($badges['course_enroll_badge_two'][0]['image']) }})',
                'background-size': 'contain',
                'background-position': 'center',
                'background-repeat': 'no-repeat'
            });
        @endif

        $.uploadPreview({
            input_field: "#image-upload-12",
            preview_box: "#image-preview-12",
            label_field: "#image-label-12",
            label_default: "{{ __('Choose Image') }}",
            label_selected: "{{ __('Change Image') }}",
            no_label: false,
            success_callback: null
        });
        @if (array_key_exists('course_enroll_badge_three', $badges))
            $('#image-preview-12').css({
                'background-image': 'url({{ asset($badges['course_enroll_badge_three'][0]['image']) }})',
                'background-size': 'contain',
                'background-position': 'center',
                'background-repeat': 'no-repeat'
            });
        @endif
    </script>
@endpush
