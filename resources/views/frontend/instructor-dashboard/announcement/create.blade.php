@extends('frontend.instructor-dashboard.layouts.master')

@section('dashboard-contents')

    <div class="dashboard__content-wrap dashboard__content-wrap-two mt-3">
        <div class="dashboard__content-title">
            <h4 class="title">{{ __('Create an Announcement') }}</h4>
        </div>
        <form action="{{ route('instructor.announcements.store') }}" method="POST" class="instructor__profile-form">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="form-grp">
                        <label for="">{{ __('Course') }}</label>
                        <select name="course" class="form-select">
                            <option value="">{{ __('Select') }}</option>
                            @foreach ($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-grp">
                        <label for="">{{ __('Title') }}</label>
                        <input type="text" name="title" value="">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-grp">
                        <label for="phone">{{ __('Announcement') }}</label>
                        <textarea name="announcement" class="text-editor"></textarea>
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <button type="submit" class="btn">{{ __('Create') }}</button>
            </div>
        </form>

    </div>
@endsection
