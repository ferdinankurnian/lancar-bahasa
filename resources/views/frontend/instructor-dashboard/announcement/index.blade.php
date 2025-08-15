@extends('frontend.instructor-dashboard.layouts.master')

@section('dashboard-contents')
    <div class="dashboard__content-wrap mt-3">
        <div class="dashboard__content-title d-flex flex-wrap justify-content-between">
            <h4 class="title">{{ __('Announcements') }}</h4>
            <a href="{{ route('instructor.announcements.create') }}" class="btn btn-primary btn-hight-basic">
                {{ __('Create Announcement') }}
            </a>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="dashboard__review-table table-responsive">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th>{{ __('No') }}</th>
                                <th>{{ __('Course') }}</th>
                                <th>{{ __('Title') }}</th>

                                <th>{{ __('Date') }}</th>

                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($announcements as $key => $announcement)
                                <tr>
                                    <td>
                                        <p>{{ $loop->iteration }}</p>
                                    </td>
                                    <td>
                                        <p>{{ truncate($announcement->course->title) }}</p>
                                    </td>
                                    <td>
                                        <p>{{ truncate($announcement->title) }}</p>
                                    </td>
                                    <td>
                                        <p>{{ formatDate($announcement->created_at) }}</p>
                                    </td>

                                    <td>
                                        <a href="{{ route('instructor.announcements.edit', $announcement->id) }}"
                                            class="text-primary"><i class="far fa-edit"></i></a>
                                        <a href="{{ route('instructor.announcements.destroy', $announcement->id) }}"
                                            class="text-danger delete-item"><i class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <td class="text-center" colspan="100">{{ __('No Data') }}</td>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
