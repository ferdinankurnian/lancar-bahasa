<!-- Modal -->
<div class="modal-header">
  <h1 class="modal-title fs-5" id="exampleModalLabel">{{ __('Chapter Title') }}</h1>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="p-3">
  <form action="{{ route('instructor.course-chapter.update', $chapter->id) }}" class="instructor__profile-form" method="post">
    @csrf
    @method('PUT')
    <div class="col-md-12">
      <div class="form-grp">
          <label for="title">{{ __('Title') }} <code>*</code></label>
          <input id="title" name="title" type="text" value="{{ $chapter->title }}">
      </div>
    </div>
    <div class="text-end">
      <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
    </div>

  </form>
</div>
