@extends('frontend.instructor-dashboard.layouts.master')

@section('dashboard-contents')
    <div class="dashboard__content-wrap">

        <div class="dashboard__content-title d-flex justify-content-between">
            <h4 class="title">{{ __('Create Course') }}</h4>
        </div>
        <div class="row">
            <div class="col-12">
                @include('frontend.instructor-dashboard.course.navigation')
                <div class="instructor__profile-form-wrap">
                    <form action="{{ route('instructor.courses.update') }}" class="instructor__profile-form course-form">
                        @csrf
                        <input type="hidden" name="course_id" id="" value="{{ $course->id }}">
                        <input type="hidden" name="step" id="" value="4">
                        <input type="hidden" name="next_step" value="4">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-grp">
                                    <label for="">{{ __('Message for Reviewer') }} <code></code></label>
                                    <textarea name="message_for_reviewer" class="form-control">{{ $course->message_for_reviewer }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-12">
                              <div class="form-grp">
                                  <label for="">{{ __('Status') }} <code>*</code></label>
                                  <select name="status" id="" class="form-select">
                                    <option value="">{{ __('Select') }}</option>
                                    <option @selected($course->status == 'active') value="active">{{ __('Publish') }}</option>
                                    <option @selected($course->status == 'inactive') value="inactive">{{ __('UnPublish') }}</option>
                                    <option @selected($course->status == 'is_draft') value="is_draft">{{ __('Draft') }}</option>
                                  </select>
                              </div>
                          </div>

                            <div>
                                <button class="btn btn-primary" type="submit">{{ __('Save') }}</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('frontend/js/default/courses.js') }}"></script>
@endpush
