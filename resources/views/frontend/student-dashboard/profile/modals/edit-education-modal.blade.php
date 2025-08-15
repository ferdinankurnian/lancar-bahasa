<div class="modal-header">
  <h5 class="modal-title" id="dynamic-modalLabel">{{ __('Add Education') }}</h5>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
  <form action="{{ route('student.setting.education.update', $education->id) }}" method="POST" class="instructor__profile-form">
    @csrf
    @method('PUT')
    <div class="col-md-12">
      <div class="form-grp">
          <label for="education">{{ __('Education') }} <code>*</code></label>
          <input id="education" name="education" type="text" value="{{ $education->education }}" required>
          <small>{{ __('Hint: Discribe your education degree in one line') }}</small>
      </div>
    </div>

    <div class="p-2"></div>
    <div class="text-end">
      <button type="submit" class="btn">{{ __('Save') }}</button>
    </div>
  </form>
</div>

