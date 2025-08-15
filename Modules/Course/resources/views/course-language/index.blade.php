@extends('admin.master_layout')
@section('title')
    <title>{{ __('Course lnaguage') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Course Language') }}</h1>
            </div>

            <div class="section-body">
                <div class="text-right">
                    <a href="{{ route('admin.course-language.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i>
                        {{ __('Add New') }}</a>
                </div>
                <div class="row mt-4">
                    {{-- Search filter --}}
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.course-language.index') }}" method="GET"
                                    onchange="$(this).trigger('submit')" class="form_padding">
                                    <div class="row">
                                        <div class="col-md-3 form-group">
                                            <input type="text" name="keyword" value="{{ request()->get('keyword') }}"
                                                class="form-control" placeholder="{{ __('Search') }}">
                                        </div>


                                        <div class="col-md-3 form-group">
                                            <select name="status" id="status" class="form-control">
                                                <option value="">{{ __('Select Status') }}</option>
                                                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>
                                                    {{ __('Active') }}
                                                </option>
                                                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>
                                                    {{ __('In-Active') }}
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
                                                <th>{{ __('Flag') }}</th>
                                                <th>{{ __('Status') }}</th>
                                                <th>{{ __('Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($courseLanguages as $index => $language)
                                                <tr>
                                                    <td>{{ ++$index }}</td>
                                                    <td>{{ $language->name }}</td>
                                                    <td>
                                                        @if ($language->image)
                                                            <img src="{{ asset($language->image) }}" alt="flag" width="50">
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <input class="change-status"
                                                            data-url="{{ route('admin.course-language.status-update', $language->id) }}"
                                                            id="status_toggle" type="checkbox"
                                                            {{ $language->status ? 'checked' : '' }} data-toggle="toggle"
                                                            data-on="{{ __('Active') }}" data-off="{{ __('Inactive') }}"
                                                            data-onstyle="success" data-offstyle="danger">
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.course-language.edit', $language->id) }}"
                                                            class="btn btn-primary btn-sm"><i class="fa fa-edit"
                                                                aria-hidden="true"></i></a>
                                                        <a href="javascript:;" data-toggle="modal"
                                                            data-target="#deleteModal" class="btn btn-danger btn-sm"
                                                            onclick="deleteData({{ $language->id }})"><i
                                                                class="fa fa-trash" aria-hidden="true"></i></a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <x-empty-table :name="__('Course Language')" route="admin.course-language.create"
                                                    create="yes" :message="__('No data found!')" colspan="5"></x-empty-table>
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
