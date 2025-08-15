@extends('frontend.instructor-dashboard.layouts.master')

@section('dashboard-contents')
    <div class="dashboard__content-wrap">
        <div class="dashboard__content-title">
            <h4 class="title">{{ __('Lesson Questions') }}</h4>
        </div>
        <form class="row mb-3 justify-content-end instructor__profile-form"
            action="{{ route('instructor.lesson-questions.index') }}" method="GET" onchange="$(this).trigger('submit')">
            <div class="col-lg-2 col-sm-5 col-md-4">
                <div class="form-grp">
                    <select name="seen" id="seen" class="form-select">
                        <option value="">{{ __('All') }}</option>
                        <option value="1" {{ request('seen') == '1' ? 'selected' : '' }}>{{ __('Read') }}
                        </option>
                        <option value="0"{{ request('seen') == '0' ? 'selected' : '' }}>{{ __('Unread') }}
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-lg-2 col-sm-5 col-md-4">
                <div class="form-grp">
                    <select name="sort_by" id="sort_by" class="form-select">
                        <option value="0" {{ request('sort_by') == '0' ? 'selected' : '' }}>{{ __('Newest ') }}
                        </option>
                        <option value="1" {{ request('sort_by') == '1' ? 'selected' : '' }}>{{ __('Oldest ') }}
                        </option>
                    </select>
                </div>
            </div>
        </form>
        <div class="row">
            @forelse ($lesson_questions as $index => $question)
                <div class="col-12 mb-5">
                    <div class="d-flex gap-2 align-items-start">
                        <input class="question-view form-check-input" {{ $question?->seen == '0' ? 'checked' : '' }}
                            type="checkbox" title="{{ $question?->seen == '0' ? __('Mark as unread') : __('Mark read') }}"
                            onchange="markAsReadUnread(this,{{ $question->id }})">

                        <div class="card wsus_lesson_qna_list w-100">
                            <div class="card-header d-flex justify-content-between gap-3">
                                <div class="d-flex align-items-center gap-2">
                                    <img class="wsus_thumbnail" src="{{ asset($question?->course?->thumbnail) }}"
                                        alt="{{ $question?->course?->title }}">
                                    <div class="wsus_qna_question_title">
                                        <p>{{ __('Student Question In') }} <a target="_blank"
                                                href="{{ route('student.learning.index', $question?->course?->slug) }}">{{ ' ' . $question?->course?->title }}</a>
                                        </p>
                                        <p>{{ __('Lesson') }} <a target="_blank"
                                                href="{{ route('student.learning.index', ['slug' => $question?->course?->slug, 'lesson' => $question?->lesson_id, 'type' => $question?->lesson?->chapterItem?->type]) }}">{{ ' ' . $question?->lesson?->title }}</a>
                                        </p>
                                    </div>
                                </div>
                                <a href="javascript:;" class="delete-item"><i class="fas fa-trash-alt text-danger"></i>
                                    <form action="{{ route('instructor.lesson-question.destroy', $question->id) }}"
                                        method="POST" class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="wsus_qna_question">
                                    <div class="d-flex align-items-center gap-2">
                                        <img class="wsus_thumbnail" src="{{ asset($question?->user?->image) }}"
                                            alt="{{ $question?->user?->name }}">
                                        <div class="d-flex flex-column">
                                            <a href="javascript:;">{{ $question?->user?->name }}</a>
                                            <span>{{ formatDate($question?->created_at, 'd M, Y : H:i') }}</span>
                                        </div>
                                    </div>
                                    <div class="mt-3 wsus_qna_reply">
                                        <a href="javascript:;">{{ $question?->question_title }}</a>
                                        {!! clean(replaceImageSources($question?->question_description)) !!}
                                    </div>
                                </div>
                                <h6 class="text-center wsus_qna_reply_count">( {{ $question->replies_count }}
                                    {{ __('answers') }} )</h6>
                                @forelse ($question?->replies as $reply)
                                    <div class="wsus_qna_reply_item">
                                        <div
                                            class="wsus_reply_header  d-flex justify-content-between gap-3 align-items-start">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="wsus_thumbnail rounded-circle">
                                                    <img src="{{ asset($reply?->user?->image) }}" alt="img">
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <a href="javascript:;">{{ $reply?->user?->name }}</a>
                                                    <span>{{ formatDate($reply?->created_at, 'd M, Y : H:i') }}</span>
                                                </div>
                                            </div>
                                            <a href="javascript:;" class="delete-item"><i
                                                    class="fas fa-trash-alt text-danger"></i>
                                                <form action="{{ route('instructor.lesson-reply.destroy', $reply?->id) }}"
                                                    method="POST" class="d-none">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </a>
                                        </div>
                                        <div class="wsus_reply_content">
                                            {!! clean(replaceImageSources($reply?->reply)) !!}
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-center ps-5">{{ __('No replies yet') }}</p>
                                @endforelse
                            </div>
                            <div class="card-footer footer_input p-0">
                                <form action="{{ route('instructor.lesson-question.reply', $question->id) }}"
                                    class="replay-form" method="POST">
                                    @csrf
                                    <textarea onclick="toggleEditor('{{$question->id}}')" placeholder="Add reply" class="form-control default-textarea-{{ $question->id }}"></textarea>
                                    <div class="text-editor-{{ $question->id }} d-none">
                                        <textarea name="reply" placeholder="Add reply" class="text-editor-img"></textarea>
                                        <button type="submit" class="btn mt-3 mb-3 ms-3">{{ __('submit') }}</button>
                                        <button type="button" class="btn btn-two mt-3 mb-3 ms-3" onclick="toggleEditor('{{$question->id}}')">{{ __('Close') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center">{{ __('No questions found!') }}</p>
            @endforelse
            {{ $lesson_questions?->links() }}
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('frontend/js/custom-tinymce.js') }}"></script>
    <script src="{{ asset('frontend/js/default/instructor-qna.js') }}?v={{$setting?->version}}"></script>
    <script>
        var isDemo = "{{ env('PROJECT_MODE') ?? 'LIVE' }}";
    </script>
@endpush
