@extends('admin.master_layout')
@section('title')
    <title>{{ __('Course Delete Request') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Course Delete Request') }}</h1>
            </div>

            <div class="section-body">
                <div class="row mt-4">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive table-invoice">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{ __('SN') }}</th>
                                                <th>{{ __('Course') }}</th>
                                                <th>{{ __('Message') }}</th>
                                                <th>{{ __('Status') }}</th>
                                                <th>{{ __('Course') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($messages as $index => $message)
                                                <tr>
                                                    <td>{{ ++$index }}</td>
                                                    <td>{{ $message->course->title }}</td>
                                                    <td>{{ $message->message }}</td>
                                                    <td>
                                                        @if ($message->status == 0)
                                                            <span class="badge badge-warning">{{ __('Pending') }}</span>
                                                        @elseif($message->status == 1)
                                                            <span class="badge badge-success">{{ __('Approved') }}</span>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        <form action="{{ route('admin.course-delete-request.update', $message->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="d-flex">
                                                                <select name="action" id="" class="form-control">
                                                                    <option value="">{{ __('Select') }}</option>
                                                                    <option @selected($message->status == 0) value="active">{{ __('Active') }}</option>
                                                                    <option @selected($message->status == 1) value="inactive">{{ __('Inactive') }}</option>
                                                                </select>
                                                                <button type="submit" class="btn btn-primary course-delete-btn">{{ __('Update') }}</button>
                                                            </div>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <x-empty-table :name="__('Course Language')" route="" create="no"
                                                    :message="__('No data found!')" colspan="5"></x-empty-table>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>

    <x-admin.delete-modal />
    <script>
        "use strict";

        function deleteData(id) {
            $("#deleteForm").attr("action", "{{ url('admin/course-language/') }}" + "/" + id)
        }
    </script>
@endsection
