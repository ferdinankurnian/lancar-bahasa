<div class="modal-header">
    <h6 class="modal-title" id="">{{ __('Sort Chapters') }}</h6>
</div>

<div>
    <form action="{{ route('admin.course-chapter.sorting.store', $courseId) }}" method="POST"
        class="chapter_sorting_form">
        @csrf
        <ul class="list-group draggable-list">
            @foreach ($chapters as $chapter)
                <li class="list-group-item mb-2" data-order="{{ $chapter->order }}">
                    <input type="hidden" name="chapter_ids[]" value="{{ $chapter->id }}">
                    <div class="course_shorting d-flex flex-wrap justify-content-between align-items-center">
                        <div class="d-flex flex-wrap align-items-center">
                            <span class="icon-container"><i class="fas fa-play"></i></span>
                            <p class="mb-0 ms-2 bold-text"> {{ truncate($chapter->title, 70) }}</p>
                        </div>
                        <div class="item-action">
                            <a href="javascript:;" class="ms-2 text-dark dragger"><i class="fas fa-arrows-alt"></i></a>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-primary"
        onclick="$('.chapter_sorting_form').trigger('submit')">{{ __('Save changes') }}</button>
</div>
