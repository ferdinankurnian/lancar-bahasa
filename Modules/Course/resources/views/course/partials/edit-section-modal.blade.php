<!-- Modal -->
<div class="modal-header">
  <h6 class="modal-title" id="exampleModalLabel">{{ __('Chapter Title') }}</h6>
</div>

<div class="">
  <form action="{{ route('admin.course-chapter.update', $chapter->id) }}" class="instructor__profile-form" method="post">
    @csrf
    @method('PUT')
    <div >
      <div class="form-group">
          <label for="title">{{ __('Title') }} <code>*</code></label>
          <input id="title" name="title" type="text" value="{{ $chapter->title }}" class="form-control">
      </div>
    </div>
    <div class="text-end">
      <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
    </div>

  </form>
</div>
