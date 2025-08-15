@extends('admin.master_layout')
@section('title')
    <title>{{ __('Non verified Users') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Non verified Users') }}</h1>
            </div>

            <div class="section-body">
                <div class="row">
                    {{-- Search filter --}}
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.non-verified-customers') }}" method="GET"
                                    onchange="$(this).trigger('submit')" class="form_padding">
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <input type="text" name="keyword" value="{{ request()->get('keyword') }}"
                                                class="form-control" placeholder="{{ __('Search') }}">
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <select name="banned" id="banned" class="form-control">
                                                <option value="">{{ __('Select Banned') }}</option>
                                                <option value="1" {{ request('banned') == '1' ? 'selected' : '' }}>
                                                    {{ __('Banned') }}
                                                </option>
                                                <option value="0" {{ request('banned') == '0' ? 'selected' : '' }}>
                                                    {{ __('Non-banned') }}
                                                </option>
                                            </select>
                                        </div>
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
                       @if(count($users) > 0)
                       <div class="text-right">
                        <a href="javascript:;" data-toggle="modal" data-target="#verifyModal"
                            class="btn btn-primary mb-3">{{ __('Send Verify Link to All') }}</a>
                        </div> 
                        @endif
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive table-invoice">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{ __('SN') }}</th>
                                                <th>{{ __('Name') }}</th>
                                                <th>{{ __('Email') }}</th>
                                                <th>{{ __('Joined at') }}</th>
                                                <th>{{ __('Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($users as $index => $user)
                                                <tr>
                                                    <td>{{ ++$index }}</td>
                                                    <td>{{ html_decode($user->name) }}</td>
                                                    <td>{{ html_decode($user->email) }}</td>
                                                    <td>{{ $user->created_at->format('h:iA, d M Y') }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.customer-show', $user->id) }}"
                                                            class="btn btn-success btn-sm"><i class="fas fa-eye"></i></a>

                                                        <a onclick="deleteData({{ $user->id }})" href="javascript:;"
                                                            data-toggle="modal" data-target="#deleteModal"
                                                            class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <x-empty-table :name="__('Customer')" route="" create="no"
                                                    :message="__('No data found!')" colspan="5"></x-empty-table>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                @if (request()->get('par-page') !== 'all')
                                    <div class="float-right">
                                        {{ $users->onEachSide(0)->links() }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>

    <!-- Start Verify modal -->
    <div class="modal fade" id="verifyModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Send verify link to customer mail') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <p>{{ __('Are you sure want to send verify link to customer mail?') }}</p>

                        <form action="{{ route('admin.send-verify-request-to-all') }}" method="POST">
                            @csrf

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Send Request') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Verify modal -->

    <x-admin.delete-modal />
    @push('js')
        <script>
            function deleteData(id) {
                $("#deleteForm").attr("action", '{{ url('/admin/customer-delete/') }}' + "/" + id)
            }
        </script>
    @endpush
@endsection
