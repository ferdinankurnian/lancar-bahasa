@forelse($questions as $question)
<div class="video_qna_list_item">

    <div class="img">
        <img src="{{ asset($question->user->image) }}" alt="img">
    </div>
    <div class="text">
        <div class="d-flex justify-content-between">
            <a class="qna_title question-item " data-question-id="{{ $question->id }}" href="javascript:;">{{ $question->question_title }}</a>
            @if($question->user_id == auth()->user()->id)
            <a href="{{ route('student.destroy-question', $question->id) }}" class="text-danger delete-item"><i class="fas fa-trash-alt"></i></a>
            @endif
        </div>
        {!! clean(replaceImageSources($question->question_description)) !!}
        <ul>
            <li><a href="#">{{ $question->user->name }}</a></li>
            <li>{{ formatDate($question->created_at, 'd M, Y : H:i') }}</li>
        </ul>
        <span>{{ $question->replies_count }} <i class="fas fa-comment"></i></span>
    </div>
</div>
@empty
<p class="text-center p-4">{{ __('No questions yet!') }}</p>
@endforelse