@extends('frontend.pages.learning-player.master')
@section('meta_title', $course->title . ' || ' . $setting->app_name)

@section('contents')

    <section class="wsus__course_video">
        <div class="col-12">
            <div class="wsus__course_header">
                <a href="{{ route('student.dashboard') }}"><i class="fas fa-angle-left"></i>
                    {{ __('Go back to dashboard') }}</a>
                <p>{{ __('Your Progress') }}: {{ $courseLectureCompletedByUser }} {{ __('of') }}
                    {{ $courseLectureCount }} ({{ number_format($courseCompletedPercent) }}%)</p>

                <div class="wsus__course_header_btn">
                    <i class="fas fa-stream"></i>
                </div>
            </div>
        </div>

        <div class="wsus__course_video_player">

            {{-- Player --}}
            <div class="video-payer">
                <div class="player-placeholder">
                    <div class="preloader-two player">
                        <div class="loader-icon-two player"><img src="{{ asset(Cache::get('setting')->preloader) }}"
                                alt="Preloader">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bottom Panel --}}
            @include('frontend.pages.learning-player.bottom-panel')

        </div>


        <div class="wsus__course_sidebar">
            <div class="wsus__course_sidebar_btn">
                <i class="fas fa-times"></i>
            </div>
            <h2 class="video_heading">{{ __('Course Content') }}</h2>
            <div class="accordion" id="accordionExample">
                @foreach ($course->chapters as $chapter)
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse-{{ $chapter->id }}" aria-expanded="false"
                                aria-controls="collapse-{{ $chapter->id }}">
                                <b>{{ $chapter->title }}</b>
                                <span></span>
                            </button>
                        </h2>
                        <div id="collapse-{{ $chapter->id }}"
                            class="accordion-collapse collapse {{ $currentProgress?->chapter_id == $chapter->id ? 'show' : '' }}"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body course-content">
                                @foreach ($chapter->chapterItems as $chapterItem)
                                    @if ($chapterItem->type == 'lesson'  || $chapterItem->type == 'live')
                                        <div
                                            class="form-check {{ $chapterItem->lesson->id == $currentProgress?->lesson_id ? 'item-active' : '' }}">
                                            <input @checked(in_array($chapterItem->lesson->id, $alreadyWatchedLectures))
                                                class="form-check-input lesson-completed-checkbox" type="checkbox"
                                                data-lesson-id="{{ $chapterItem->lesson->id }}" value="1"
                                                data-type="lesson">
                                            <label class="form-check-label lesson-item"
                                                data-lesson-id="{{ $chapterItem->lesson->id }}"
                                                data-chapter-id="{{ $chapter->id }}" data-course-id="{{ $course->id }}"
                                                data-type="{{$chapterItem->type}}">
                                                {{ $chapterItem->lesson->title }}
                                                <span>
                                                    <img src="{{ $chapterItem->type == 'live' ? asset('frontend/img/live.png') : asset('frontend/img/video_icon_black_2.png') }}"
                                                        alt="video" class="img-fluid">
                                                    {{ $chapterItem->lesson->duration ? minutesToHours($chapterItem->lesson->duration) : '--.--' }}
                                                </span>
                                            </label>
                                        </div>
                                    @elseif ($chapterItem->type == 'document')
                                        <div
                                            class="form-check {{ $chapterItem->lesson->id == $currentProgress?->lesson_id ? 'item-active' : '' }}">
                                            <input @checked(in_array($chapterItem->lesson->id, $alreadyWatchedLectures))
                                                class="form-check-input lesson-completed-checkbox" type="checkbox"
                                                data-lesson-id="{{ $chapterItem->lesson->id }}" value="1"
                                                data-type="document">
                                            <label class="form-check-label lesson-item"
                                                data-lesson-id="{{ $chapterItem->lesson->id }}"
                                                data-chapter-id="{{ $chapter->id }}" data-course-id="{{ $course->id }}"
                                                data-type="document">
                                                {{ $chapterItem->lesson->title }}
                                                <span>
                                                    <img src="{{ asset('frontend/img/' . $chapterItem->lesson->file_type . '.png') }}"
                                                        alt="video" class="img-fluid">
                                                    --.--
                                                </span>
                                            </label>
                                        </div>
                                    @else
                                        <div class="form-check">
                                            <input @checked(in_array($chapterItem->quiz->id, $alreadyCompletedQuiz))
                                                class="form-check-input lesson-completed-checkbox" type="checkbox"
                                                data-lesson-id="{{ $chapterItem->quiz->id }}" value="1"
                                                data-type="quiz">
                                            <label class="form-check-label lesson-item"
                                                data-chapter-id="{{ $chapter->id }}" data-course-id="{{ $course->id }}"
                                                data-lesson-id="{{ $chapterItem->quiz->id }}" data-type="quiz">
                                                {{ $chapterItem->quiz->title }}
                                                <span>
                                                    <img src="{{ asset('frontend/img/video_icon_black_2.png') }}"
                                                        alt="video" class="img-fluid">
                                                    --.--
                                                </span>
                                            </label>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        var preloader_path = "{{ asset(Cache::get('setting')->preloader) }}";
    </script>
    <script src="{{ asset('frontend/js/default/learning-player.js') }}?v={{$setting?->version}}"></script>
    <script src="{{ asset('frontend/js/default/quiz-page.js') }}?v={{$setting?->version}}"></script>
    <script src="{{ asset('frontend/js/default/qna.js') }}?v={{$setting?->version}}"></script>
    <script src="{{ asset('frontend/js/default/qna.js') }}?v={{$setting?->version}}"></script>
    <script src="{{ asset('frontend/js/pdf.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jszip.min.js') }}"></script>
    <script src="{{ asset('frontend/js/docx-preview.min.js') }}"></script>
    <script>
        "use strict";
        $(document).ready(function() {
            // reset quiz timer
            resetCountdown();
            // auto click on current lesson
            var lessonId = "{{ request('lesson') }}";
            var type = "{{ request('type') }}";
            var currentLessonSelector = $('.lesson-item[data-lesson-id="{{ $currentProgress?->lesson_id }}"][data-type="{{ $currentProgress?->type }}"]');
            var targetLessonSelector = $(`.lesson-item[data-lesson-id="${lessonId}"][data-type="${type}"]`);

            if (targetLessonSelector.length) {
                targetLessonSelector.trigger('click');
            } else if (currentLessonSelector.length) {
                currentLessonSelector.trigger('click');
            } else {
                $('.lesson-item:first').trigger('click');
            }

        })
    </script>
    <script src="{{ asset('frontend/js/custom-tinymce.js') }}"></script>
@endpush
