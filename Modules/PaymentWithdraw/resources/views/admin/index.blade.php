@extends('admin.master_layout')
@section('title')
    <title>{{ $title }}</title>
@endsection
@section('admin-content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ $title }}</h1>

            </div>

            <div class="section-body">
                <div class="row mt-4">
                    {{-- Search filter --}}
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ url()->current() }}" method="GET" onchange="$(this).trigger('submit')"
                                    class="form_padding">
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <input type="text" name="keyword" value="{{ request()->get('keyword') }}"
                                                class="form-control" placeholder="{{ __('Search') }}">
                                        </div>
                                        @if (Route::is('admin.withdraw-list'))
                                            <div class="col-md-2 form-group">
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
                                        @endif

                                        <div class="col-md-2 form-group">
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
                                        <div class="col-md-2 form-group">
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

                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive table-invoice">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{ __('SN') }}</th>
                                                <th>{{ __('User') }}</th>
                                                <th>{{ __('Method') }}</th>
                                                <th>{{ __('Current Balance') }}</th>
                                                <th>{{ __('Withdraw Amount') }}</th>
                                                <th>{{ __('Status') }}</th>
                                                <th>{{ __('Date') }}</th>
                                                <th>{{ __('Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($withdraws as $index => $withdraw)
                                                <tr>
                                                    <td>{{ ++$index }}</td>
                                                    <td><a
                                                            href="{{ route('admin.customer-show', $withdraw->user_id) }}">{{ $withdraw?->user?->name }}</a>
                                                    </td>

                                                    <td>{{ $withdraw->method }}</td>
                                                    <td>
                                                        {{ currency($withdraw->current_amount) }}
                                                    </td>
                                                    <td>
                                                        {{ currency($withdraw->withdraw_amount) }}
                                                    </td>
                                                    <td>
                                                        @if ($withdraw->status == 'approved')
                                                            <span class="badge badge-success">{{ __('Success') }}</span>
                                                        @elseif ($withdraw->status == 'rejected')
                                                            <span class="badge badge-danger">{{ __('Rejected') }}</span>
                                                        @else
                                                            <span class="badge badge-warning">{{ __('Pending') }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ formatDate($withdraw->created_at) }}
                                                    </td>
                                                    <td>

                                                        <a href="{{ route('admin.show-withdraw', $withdraw->id) }}"
                                                            class="btn btn-primary btn-sm"><i class="fa fa-eye"
                                                                aria-hidden="true"></i></a>

                                                    </td>


                                                </tr>
                                            @empty
                                                <x-empty-table :name="__('')" route="" create="no"
                                                    :message="__('No data found!')" colspan="8"></x-empty-table>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                @if (request()->get('par-page') !== 'all')
                                    <div class="float-right">
                                        {{ $withdraws->onEachSide(0)->links() }}
                                    </div>
                                @endif
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
            $("#deleteForm").attr("action", '{{ url('admin/delete-withdraw/') }}' + "/" + id)
        }
    </script>
@endsection
