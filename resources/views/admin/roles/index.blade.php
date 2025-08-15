@extends('admin.master_layout')
@section('title')
    <title>{{ __('Manage Roles') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <div class="section-header-back">
                    <a href="{{ route('admin.settings') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
                </div>
                <h1>{{ __('Manage Roles') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                    </div>
                    <div class="breadcrumb-item active"><a href="{{ route('admin.settings') }}">{{ __('Settings') }}</a>
                    </div>
                    <div class="breadcrumb-item">{{ __('Manage Roles') }}</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h4>{{ __('Manage Roles') }}</h4>
                                <div>
                                    @adminCan('role.create')
                                        <a href="{{ route('admin.role.create') }}" class="btn btn-primary"><i
                                                class="fa fa-plus"></i> {{ __('Add New') }}</a>
                                    @endadminCan
                                    @adminCan('role.assign')
                                        <a href="{{ route('admin.role.assign') }}" class="btn btn-success"><i
                                                class="fa fa-sync"></i> {{ __('Assign Role') }}</a>
                                    @endadminCan
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive max-h-400">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th width="5%">#</th>
                                                <th>{{ __('Name') }}</th>
                                                <th>{{ __('Permission') }}</th>
                                                @adminCan(['role.edit', 'role.delete'])
                                                    <th>{{ __('Action') }}</th>
                                                @endadminCan
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($roles as $role)
                                                <tr>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td>{{ ucwords($role->name) }}</td>
                                                    <td>
                                                        {{ $role?->permissions?->count() ?? 0 }}
                                                    </td>
                                                    @adminCan(['role.edit', 'role.delete'])
                                                        <td>
                                                            @if($role->id != 1)
                                                            @adminCan('role.edit')
                                                                <a href="{{ route('admin.role.edit', $role->id) }}"
                                                                    class="btn btn-warning btn-sm"><i class="fa fa-edit"
                                                                        aria-hidden="true"></i></a>
                                                            @endadminCan
                                                            @adminCan('role.delete')
                                                                <a href="javascript:;" data-toggle="modal"
                                                                    data-target="#deleteModal" class="btn btn-danger btn-sm"
                                                                    onclick="deleteData({{ $role->id }})"><i
                                                                        class="fa fa-trash" aria-hidden="true"></i></a>
                                                            @endadminCan
                                                            @else
                                                                <span class="text-muted">{{ __('( default role )') }}</span>
                                                            @endif
                                                        </td>
                                                    @endadminCan
                                                </tr>
                                            @empty
                                                <x-admin.update-button :text="__('Update')"></x-admin.update-button>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    <div class="float-right">
                                        {{ $roles->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <x-admin.delete-modal />
@endsection

@push('js')
    <script>
        "use strict"

        function deleteData(id) {
            $("#deleteForm").attr("action", "{{ url('/admin/role/') }}" + "/" + id)
        }
    </script>
@endpush

@push('css')
    <style>
        .dd-custom-css {
            position: absolute;
            will-change: transform;
            top: 0px;
            left: 0px;
            transform: translate3d(0px, -131px, 0px);
        }

        .max-h-400 {
            min-height: 400px;
        }
    </style>
@endpush
