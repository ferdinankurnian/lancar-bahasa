<div class="video_qna_list_item">
    <div class="img">
        <img src="{{ asset($question->user->image) }}" alt="img">
    </div>
    <div class="text">
        <a class="qna_title" href="javascript:;">{{ $question->question_title }}</a>
        {!! clean(replaceImageSources($question->question_description)) !!}
        <ul>
            <li><a href="javascript:;">{{ $question->user->name }}</a></li>
            <li>{{ formatDate($question->created_at, 'd M, Y : H:i') }}</li>
        </ul>
    </div>
</div>

<div class="d-flex flex-wrap justify-content-between align-items-center">
    <h4>{{ count($replies) }} {{ __('replies ') }}</h4>
    <a class="flow" href="#">{{ __('Follow replies') }}</a>
</div>
@forelse ($replies as $reply)
    <div class="qns_details_list_item video_qna_list_item">
        <div class="img">
            <img src="{{ asset($reply->user->image) }}" alt="img">
        </div>
        <div class="text">
            <a class="qna_title" href="javascript:;">{{ $reply->user->name }}</a>
            <span>{{ formatDate($reply->created_at, 'd M, Y : H:i') }}</span>
            {!! clean(replaceImageSources($reply->reply)) !!}
            @if($reply->user_id == auth()->user()->id)
            <div class="dot">
                <i class="fas fa-ellipsis-v"></i>
                <ul>
                    <li><a href="{{ route('student.destroy-reply', $reply->id) }}" class="delete-item">{{ __('Delete') }}</a></li>
                </ul>
            </div>
            @endif
        </div>
    </div>
@empty
    <p class="text-center ps-5">{{ __('No replies yet') }}</p>
@endforelse
