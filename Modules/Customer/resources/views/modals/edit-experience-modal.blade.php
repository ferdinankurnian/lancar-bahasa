<div class="modal-body">
    <form action="{{ route('admin.customer-experience-update', $experience->id) }}" method="POST"
        class="instructor__profile-form">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="company">{{ __('Company') }} <code>*</code></label>
                    <input id="company" name="company" type="text" value="{{ $experience->company }}" required
                        class="form-control">
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="position">{{ __('Position') }} <code>*</code></label>
                    <input id="position" name="position" type="text" value="{{ $experience->position }}" required
                        class="form-control">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="start_date">{{ __('Start Date') }} <code>*</code></label>
                    <input id="start_date" name="start_date" type="text" value="{{ $experience->start_date }}"
                        required class="form-control datepicker">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="end_date">{{ __('End Date') }} <code>*</code></label>
                    <input id="end_date" name="end_date" type="text" value="{{ $experience->end_date }}" required
                        class="form-control datepicker">
                </div>
            </div>

            <div class="col-12">
                <div class="d-flex">
                    <div class="form-group">
                        <label>{{ __('Current') }}</label>
                    </div>
                    <div class="">
                        <div class="switcher ml-3">
                            <label for="toggle-2">
                                <input @checked($experience->current == 1) type="checkbox" id="toggle-2" value="1"
                                    name="current" />
                                <span><small></small></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="p-2"></div>
        <div class="text-end">
            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
        </div>
    </form>
</div>
