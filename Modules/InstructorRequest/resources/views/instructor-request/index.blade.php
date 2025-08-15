@extends('admin.master_layout')
@section('title')
    <title>{{ __('Instructor Request') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Instructor Request') }}</h1>
            </div>

            <div class="section-body">
                <div class="row mt-4">
                    {{-- Search filter --}}
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.instructor-request.index') }}" method="GET"
                                    onchange="$(this).trigger('submit')" class="form_padding">
                                    <div class="row">
                                        <div class="col-md-3 form-group">
                                            <input type="text" name="keyword" value="{{ request()->get('keyword') }}"
                                                class="form-control" placeholder="{{ __('Search') }}">
                                        </div>


                                        <div class="col-md-3 form-group">
                                            <select name="status" id="status" class="form-control">
                                                <option value="">{{ __('Select Status') }}</option>
                                                <option value="pending"
                                                    {{ request('status') == 'pending' ? 'selected' : '' }}>
                                                    {{ __('Pending') }}
                                                </option>
                                                <option value="approved"
                                                    {{ request('status') == 'approved' ? 'selected' : '' }}>
                                                    {{ __('Approved') }}
                                                </option>
                                                <option value="rejected"
                                                    {{ request('status') == 'rejected' ? 'selected' : '' }}>
                                                    {{ __('Rejected') }}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <select name="order_by" id="order_by" class="form-control">
                                                <option value="">{{ __('Order By') }}</option>
                                                <option value="1" {{ request('order_by') == '1' ? 'selected' : '' }}>
                                                    {{ __('ASC') }}
                                                </option>
                                                <option value="0" {{ request('order_by') == '0' ? 'selected' : '' }}>
                                                    {{ __('DESC') }}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <select name="par-page" id="par-page" class="form-control">
                                                <option value="">{{ __('Per Page') }}</option>
                                                <option value="10" {{ '10' == request('par-page') ? 'selected' : '' }}>
                                                    {{ __('10') }}
                                                </option>
                                                <option value="50" {{ '50' == request('par-page') ? 'selected' : '' }}>
                                                    {{ __('50') }}
                                                </option>
                                                <option value="100"
                                                    {{ '100' == request('par-page') ? 'selected' : '' }}>
                                                    {{ __('100') }}
                                                </option>
                                                <option value="all"
                                                    {{ 'all' == request('par-page') ? 'selected' : '' }}>
                                                    {{ __('All') }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive table-invoice">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{ __('SN') }}</th>
                                                <th>{{ __('Name') }}</th>
                                                <th>{{ __('Email') }}</th>
                                                <th>{{ __('Status') }}</th>
                                                <th>{{ __('Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($instructorRequests as $index => $request)
                                                <tr>
                                                    <td>{{ ++$index }}</td>
                                                    <td>{{ $request->user->name }}</td>
                                                    <td>{{ $request->user->email }}</td>

                                                    <td>
                                                        @if ($request->status == 'pending')
                                                            <span class="badge badge-warning">{{ __('Pending') }}</span>
                                                        @elseif ($request->status == 'approved')
                                                            <span class="badge badge-success">{{ __('Approved') }}</span>
                                                        @else
                                                            <span class="badge badge-danger">{{ __('Rejected') }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.instructor-request.edit', $request->id) }}"
                                                            class="btn btn-primary btn-sm"><i class="fa fa-eye"
                                                                aria-hidden="true"></i></a>
                                                        @if ($request->status != 'approved')
                                                        <a href="javascript:;" data-toggle="modal"
                                                            data-target="#deleteModal" class="btn btn-danger btn-sm"
                                                            onclick="deleteData({{ $request->id }})"><i
                                                                class="fa fa-trash" aria-hidden="true"></i></a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <x-empty-table :name="__('Instructor Request')" route="" create="no"
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
            $("#deleteForm").attr("action", "{{ url('admin/instructor-request') }}" + "/" + id)
        }
    </script>
@endsection
