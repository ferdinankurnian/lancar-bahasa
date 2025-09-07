<div class="quiz-card-wrapper">
    <h3>{{ $quiz->title }}</h3>
    <p>{{ __('Total Questions') }}: {{ $quiz->questions_count }}</p>
    <p>{{ __('Pass Mark') }}: {{ $quiz->pass_mark }}%</p>

    @if ($quizResult)
        <div class="quiz-result-summary">
            <h4>{{ __('Hasil quiz kamu') }}: {{ $quizResult->user_grade }}%</h4>
            <p>{{ __('Status') }}: <span class="badge {{ $quizResult->status == 'pass' ? 'bg-success' : 'bg-danger' }}">{{ ucfirst($quizResult->status) }}</span></p>
            <a href="{{ route('student.quiz.result', ['id' => $quiz->id, 'result_id' => $quizResult->id]) }}" class="btn btn-info mt-2">{{ __('View Details') }}</a>
        </div>
    @endif

    <a href="{{ route('student.learning.quiz', $quiz->id) }}" class="btn btn-primary mt-3">{{ __('Mulai Quiz') }}</a>
</div>
