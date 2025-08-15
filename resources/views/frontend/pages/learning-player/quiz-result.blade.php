@extends('frontend.pages.learning-player.master')

@section('contents')
    <section class="wsus__course_video">
        <div class="col-12">
            <div class="wsus__course_header">
                @if (Session::has('course_slug'))
                    <a href="{{ route('student.learning.index', Session::get('course_slug')) }}"><i
                            class="fas fa-angle-left"></i>{{ truncate(Session::get('course_title')) }}</a>
                @endif
            </div>
        </div>

        <div class="container">
            <div class="question-container">
                <div class="row">
                    <div class="col-12 mb-5">
                        <div class="card">
                            <div class="card-body text-center">
                                @if ($quizResult->status == 'pass')
                                    <div class="info-col text-center">
                                        <img src="{{ asset('uploads/website-images/good-score.png') }}">
                                    </div>
                                    <h5 class="card-title count">{{ __('You have passed the quiz!') }}</h5>
                                @else
                                    <div class="info-col text-center">
                                        <img src="{{ asset('uploads/website-images/bad-score.png') }}">
                                    </div>
                                    <h5 class="card-title count">{{ __('You have failed the quiz!') }}</h5>
                                    <span>{{ __('Sorry you have failed the quiz better luck next time.') }}</span>
                                @endif

                                <div class="mt-3 mb-3">
                                    @if (Session::has('course_slug'))
                                        <a href="{{ route('student.learning.index', Session::get('course_slug')) }}"
                                            class="btn">{{ __('Go back to course page') }}</a>
                                    @else
                                        <a href="{{ route('student.enrolled-courses') }}"
                                            class="btn">{{ __('Go back to Dashboard') }}</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <div class="card text-center">
                            <div class="info-col text-center">
                                <img src="{{ asset('uploads/website-images/student-grades.png') }}">
                            </div>
                            <div class="card-body">
                                <h6 class="card-title count">{{ $quiz->pass_mark }}/{{ $quiz->total_mark }}</h6>
                                <p class="card-text">{{ __('Minimum Marks') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card text-center">
                            <div class="info-col text-center">
                                <img src="{{ asset('uploads/website-images/test.png') }}">
                            </div>
                            <div class="card-body">
                                <h6 class="card-title count">{{ $attempt }}/{{ $quiz->attempt }}</h6>
                                <p class="card-text">{{ __('Attempts') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card text-center">
                            <div class="info-col text-center">
                                <img src="{{ asset('uploads/website-images/mark.png') }}">
                            </div>
                            <div class="card-body">
                                <h6 class="card-title count">{{ $quizResult->user_grade }}</h6>
                                <p class="card-text">{{ __('Your Marks') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card text-center">
                            <div class="info-col text-center">
                                <img src="{{ asset('uploads/website-images/trophy.png') }}">
                            </div>
                            <div class="card-body">
                                <h6
                                    class="card-title count text-capitalize {{ $quizResult->status == 'pass' ? 'text-success' : 'text-danger' }}">
                                    {{ $quizResult->status == 'pass' ? __('Passed') : __('Failed') }}</h6>
                                <p class="card-text">{{ __('Result') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <form action="{{ route('student.quiz.store', request('id')) }}" method="POST">
                    @csrf
                    <div class="card-body">
                        @php
                            $result = json_decode($quizResult->result);
                        @endphp
                        @foreach ($quiz->questions as $question)
                            <div class="question-box mt-4">
                                <h6>{{ $loop->iteration }}. {{ $question->title }}</h6>
                                <div class="row">
                                    @foreach ($question->answers as $answer)
                                        <div class="col-md-6">
                                            <div
                                                class="card ans-body m-2 {{ $answer->correct == 1 ? 'correct-ans' : 'wrong-ans' }}">
                                                <label for="ans-{{ $answer->id }}" class="box first">
                                                    <div class="course">
                                                        <span class="circle">
                                                            <input disabled type="radio" @checked(@$result?->{$question->id}?->answer == $answer->id)
                                                                name="question[{{ $question->id }}]"
                                                                id="ans-{{ $answer->id }}" value="{{ $answer->id }}">
                                                        </span>
                                                        <span class="subject">{{ $answer->title }}</span>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        @endforeach

                    </div>
                </form>
            </div>
        </div>

    </section>
@endsection

@push('scripts')
    <script src="{{ asset('frontend/js/default/quiz-page.js') }}"></script>
    <script>
        $(document).ready(function() {
            // reset quiz timer
            resetCountdown();
        })
    </script>
@endpush
