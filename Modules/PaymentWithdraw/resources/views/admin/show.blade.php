@extends('admin.master_layout')
@section('title')
    <title>{{ __('Withdraw Details') }}</title>
@endsection
@section('admin-content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Withdraw Details') }}</h1>

            </div>

            <div class="section-body">
                <a href="{{ route('admin.withdraw-list') }}" class="btn btn-primary"><i class="fas fa-list"></i>
                    {{ __('withdraw') }}</a>
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-bordered table-striped table-hover">
                                    <tr>
                                        <td width="50%">{{ __('Name') }}</td>
                                        <td width="50%">
                                            <a
                                                href="{{ route('admin.customer-show', $withdraw->user_id) }}">{{ $withdraw?->user?->name }}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="50%">{{ __('Withdraw Method') }}</td>
                                        <td width="50%">{{ $withdraw->method }}</td>
                                    </tr>

                                    <tr>
                                        <td width="50%">{{ __('Current Balance') }}</td>
                                        <td width="50%">
                                            {{ currency($withdraw->current_amount) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="50%">{{ __('Withdraw Amount') }}</td>
                                        <td width="50%">
                                            {{ currency($withdraw->withdraw_amount) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="50%">{{ __('Status') }}</td>
                                        <td width="50%">
                                            @if ($withdraw->status == 'approved')
                                                <span class="badge badge-success">{{ __('Approved') }}</span>
                                            @elseif ($withdraw->status == 'rejected')
                                                <span class="badge badge-danger">{{ __('Rejected') }}</span>
                                            @else
                                                <span class="badge badge-warning">{{ __('Pending') }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="50%">{{ __('Requested Date') }}</td>
                                        <td width="50%">{{ $withdraw->created_at->format('Y-m-d') }}</td>
                                    </tr>
                                    @if ($withdraw->status == 1)
                                        <tr>
                                            <td width="50%">{{ __('Approved Date') }}</td>
                                            <td width="50%">{{ $withdraw->approved_date }}</td>
                                        </tr>
                                    @endif

                                    <tr>
                                        <td width="50%">{{ __('Account Information') }}</td>
                                        <td width="50%">
                                            {!! clean(nl2br($withdraw->account_info)) !!}
                                        </td>
                                    </tr>

                                </table>


                                <div class="row">
                                    @if ($withdraw->status == 'pending')
                                        <div class="col-4">
                                            <form action="{{ route('admin.update-withdraw-status', $withdraw->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <select name="status" id="status" class="form-control">
                                                    <option value="">{{ __('Update Status') }}</option>
                                                    <option value="approved"
                                                        {{ $withdraw->status == 'approved' ? 'selected' : '' }}>
                                                        {{ __('Approve') }}</option>
                                                    <option value="rejected"
                                                        {{ $withdraw->status == 'rejected' ? 'selected' : '' }}>
                                                        {{ __('Rejected') }}</option>
                                                </select>
                                                <button type="submit"
                                                    class="btn btn-primary mt-2">{{ __('Update Status') }}</button>
                                            </form>
                                        </div>
                                    @endif

                                   <div class="col-md-4">
                                    <a href="javascript:;" data-toggle="modal" data-target="#deleteModal"
                                    class="btn btn-danger"
                                    onclick="deleteData({{ $withdraw->id }})">{{ __('Delete withdraw request') }}</a>
                                   </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>

    <x-admin.delete-modal />
    <script>
        "use strict"

        function deleteData(id) {
            $("#deleteForm").attr("action", "{{ url('admin/delete-withdraw/') }}" + "/" + id)
        }
    </script>
@endsection
