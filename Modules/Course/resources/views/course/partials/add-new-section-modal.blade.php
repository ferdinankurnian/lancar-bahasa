<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalTitle" aria-hidden="true" data-bs-backdrop='static'>
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form action="{{ route('admin.course-chapter.store', request('id')) }}" class="instructor__profile-form" method="post">
          @csrf
          <div class="">
            <div class="form-group">
                <label for="title">{{ __('Title') }} <code>*</code></label>
                <input id="title" name="title" type="text" value="" class="form-control">
            </div>
          </div>
          <div class="text-end">
            <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
