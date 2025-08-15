@extends('frontend.student-dashboard.layouts.master')

@section('dashboard-contents')
    <div class="dashboard__content-wrap">
        <div class="dashboard__content-title">
            <h4 class="title">{{ __('My Quiz Attempts') }}</h4>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="dashboard__review-table table-responsive">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th>{{ __('No') }}</th>
                                <th>{{ __('Course') }}</th>
                                <th>{{ __('Quiz') }}</th>
                                <th>{{ __('Quiz Grade') }}</th>
                                <th>{{ __('My Grade') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Date') }}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($quizAttempts as $index => $attempt)
                                <tr>
                                    <td>{{ ++$index }}</td>
                                    <td>{{ $attempt->quiz->course?->title }}</td>
                                    <td>{{ $attempt->quiz->title }}</td>
                                   

                                    <td>{{ $attempt->quiz->total_mark }}</td>
                                    <td>{{ $attempt->user_grade }}</td>
                                    <td>
                                        @if($attempt->status == 'pass')
                                            <span class="badge bg-success">{{ $attempt->status }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ $attempt->status }}</span>
                                        @endif 
                                    </td>

                                    <td>
                                        {{ formatDate($attempt->created_at) }}
                                    </td>
                                    <td>
                                        <a href="{{ route('student.quiz.result', ['id' => $attempt->quiz->id, 'result_id' => $attempt->id]) }}"><i class="fas fa-eye"></i></a>
                                    </td>
                                </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center">{{ __('No data found!') }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $quizAttempts->links() }}
            </div>
        </div>
    </div>
@endsection
