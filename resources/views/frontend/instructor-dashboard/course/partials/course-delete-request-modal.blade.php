<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{ __('Send Delete Request') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
       <form action="{{ route('instructor.course.send-delete-request') }}" method="POST">
        @csrf
        <input type="hidden" name="course_id" value="{{ $id }}">
        <div class="form-group">
        <label for="message">{{ __('Message') }}</label>
        <textarea name="message" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary mt-3">{{ __('Send') }}</button>
        </form> 
    </div>
</div>