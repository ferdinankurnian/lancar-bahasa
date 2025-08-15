<div class="modal-header">
    <h5 class="modal-title" id="dynamic-modalLabel">{{ __('Update Experience') }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form action="{{ route('student.setting.experience.update', $experience->id) }}" method="POST" class="instructor__profile-form">
      @csrf
      @method('PUT')
      <div class="col-md-12">
        <div class="form-grp">
            <label for="company">{{ __('Company') }} <code>*</code></label>
            <input id="company" name="company" type="text" value="{{ $experience->company }}" required>
        </div>
      </div>

      <div class="col-md-12">
        <div class="form-grp">
            <label for="position">{{ __('Position') }} <code>*</code></label>
            <input id="position" name="position" type="text" value="{{ $experience->position }}" required>
        </div>
      </div>

      <div class="row">
        <div class="col-md-4">
          <div class="form-grp">
              <label for="start_date">{{ __('Start Date') }} <code>*</code></label>
              <input id="start_date" name="start_date" type="text" value="{{ $experience->start_date }}" required class="datepicker">
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-grp">
              <label for="end_date">{{ __('Start Date') }} <code>*</code></label>
              <input id="end_date" name="end_date" type="text" value="{{ $experience->end_date }}" required class="datepicker">
          </div>
        </div>
      </div>
      <div class="p-2"></div>
      <div class="text-end">
        <button type="submit" class="btn">{{ __('Save') }}</button>
      </div>
    </form>
</div>

