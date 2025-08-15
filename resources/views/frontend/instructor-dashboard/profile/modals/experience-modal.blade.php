<div class="modal-header">
    <h5 class="modal-title" id="dynamic-modalLabel">{{ __('Add Experience') }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form action="{{ route('instructor.setting.experience.store') }}" method="POST" class="instructor__profile-form">
        @csrf
        <div class="col-md-12">
            <div class="form-grp">
                <label for="company">{{ __('Company') }} <code>*</code></label>
                <input id="company" name="company" type="text" value="" required>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-grp">
                <label for="position">{{ __('Position') }} <code>*</code></label>
                <input id="position" name="position" type="text" value="" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-grp">
                    <label for="start_date">{{ __('Start Date') }} <code>*</code></label>
                    <input id="start_date" name="start_date" type="text" value="{{ date('Y-m-d') }}" required class="datepicker">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-grp">
                    <label for="end_date">{{ __('End Date') }} <code>*</code></label>
                    <input id="end_date" name="end_date" type="text" value="{{ date('Y-m-d') }}" required class="datepicker">
                </div>
            </div>


            <div class="d-flex">
                <div class="form-grp">
                    <label>{{ __('Current') }}</label>
                </div>
                <div class="">
                    <div class="switcher ms-3">
                        <label for="toggle-2">
                            <input type="checkbox" id="toggle-2" value="1" name="current" />
                            <span><small></small></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-2"></div>
        <div class="text-end">
            <button type="submit" class="btn">{{ __('Save') }}</button>
        </div>
    </form>
</div>
