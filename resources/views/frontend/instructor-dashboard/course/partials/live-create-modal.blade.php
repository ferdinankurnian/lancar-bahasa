<div class="modal-header">
    <h1 class="modal-title fs-5" id="">{{ __('Add live lesson') }}</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="p-3">
    <form action="{{ route('instructor.course-chapter.lesson.store') }}" method="POST"
        class="add_lesson_form instructor__profile-form">
        @csrf
        <input type="hidden" name="course_id" value="{{ $courseId }}">
        <input type="hidden" name="chapter_id" value="{{ $chapterId }}">
        <input type="hidden" name="type" value="{{ $type }}">

        <div class="col-md-12">
            <div class="form-grp">
                <label for="chapter">{{ __('Chapter') }} <code>*</code></label>
                <select name="chapter" id="chapter" class="chapter from-select">
                    <option value="">{{ __('Select') }}</option>
                    @foreach ($chapters as $chapter)
                        <option @selected($chapterId == $chapter->id) value="{{ $chapter->id }}">{{ $chapter->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-grp">
                <label for="title">{{ __('Title') }} <code>*</code></label>
                <input id="title" name="title" type="text" value="">
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-grp">
                    <label for="live_type">{{ __('Live Platform') }} <code>*</code></label>
                    <select name="live_type" id="live_type" class="form-select">
                        @foreach (config('course.live_types') as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-grp">
                    <label for="start_time">{{ __('Start Time') }} <code>*</code></label>
                    <input id="start_time" name="start_time" type="datetime-local">
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-grp">
                    <label for="duration">{{ __('Duration') }} <code>* ({{ __('in minutes') }})</code></label>
                    <input id="duration" name="duration" type="text" value="">
                </div>
            </div>
        </div>
        <div class="col-12 zoom-alert-box">
            <div class="alert alert-warning" role="alert">
                {{__('The meeting ID, password, and Zoom settings must be configured using the same Zoom account. The course creator needs to set up the')}} <a
                    href="{{ route('instructor.zoom-setting.index') }}">{{ __('Zoom live setting') }}</a>.
            </div>
        </div>
        <div class="col-12 jitsi-alert-box d-none">
            <div class="alert alert-warning" role="alert">
                {{__('The meeting ID and Jitsi settings must be configured. The course creator needs to set up the')}} <a
                    href="{{ route('instructor.jitsi-setting.index') }}">{{ __('Jitsi setting') }}</a>.
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 meeting-id-box">
                <div class="form-grp">
                    <label for="meeting_id">{{ __('Meeting ID') }} <code>*</code></label>
                    <input id="meeting_id" name="meeting_id" type="text" value="">
                </div>
            </div>
            <div class="col-md-6 zoom-box">
                <div class="form-grp">
                    <label for="password">{{ __('Password') }} <code>*</code></label>
                    <input id="password" name="password" type="text" value="">
                </div>
            </div>
            <div class="col-md-12 zoom-box">
                <div class="form-grp">
                    <label for="join_url">{{ __('Join URL') }}</label>
                    <input id="join_url" name="join_url" type="url">
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-grp">
                <label for="description">{{ __('Description') }} <code></code></label>
                <textarea name="description" class="form-control"></textarea>
            </div>
        </div>
        <div class="col-md-12 mb-3">
            <div class="account__check-remember">
                <input id="student_mail_sent" type="checkbox" class="form-check-input" name="student_mail_sent">
                <label for="student_mail_sent" class="form-check-label">{{ __('Email to all students.') }}</label>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary submit-btn">{{ __('Create') }}</button>
        </div>
    </form>
</div>
