@extends('admin.master_layout')
@section('title')
    <title>{{ __('Category List') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Category List') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                    </div>
                    <div class="breadcrumb-item">{{ __('Category List') }}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="mt-4 row">
                    {{-- Search filter --}}
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.course-category.index') }}" method="GET"
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

                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h4>{{ __('Category List') }}</h4>
                                <div>
                                    <a href="{{ route('admin.course-category.create') }}" class="btn btn-primary"><i
                                            class="fa fa-plus"></i>{{ __('Add New') }}</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive max-h-400">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{ __('SN') }}</th>
                                                <th>{{ __('Icon') }}</th>
                                                <th>{{ __('Name') }}</th>
                                                <th>{{ __('Slug') }}</th>
                                                <th >{{ __('Show at Trading') }}</th>

                                                <th>{{ __('Status') }}</th>
                                                <th class="text-center">{{ __('Actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($categories as $category)
                                                <tr>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td><img class="thumb p-2" src="{{ asset($category->icon) }}"
                                                            alt=""></td>
                                                    <td>{{ $category->translation?->name }}</td>
                                                    <td>{{ $category->slug }}</td>
                                                    <td class="min-150">
                                                        @if ($category->show_at_trending == 1)
                                                            <span class="badge badge-success">{{ __('Yes') }}</span>
                                                        @else
                                                            <span class="badge badge-danger">{{ __('No') }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <input onchange="changeStatus({{ $category->id }})"
                                                            id="status_toggle" type="checkbox"
                                                            {{ $category->status ? 'checked' : '' }} data-toggle="toggle"
                                                            data-on="{{ __('Active') }}" data-off="{{ __('Inactive') }}"
                                                            data-onstyle="success" data-offstyle="danger">
                                                    </td>
                                                    <td class="text-center min-200">
                                                        <div>
                                                            <a href="{{ route('admin.course-category.edit', [
                                                                'course_category' => $category->id,
                                                                'code' => getSessionLanguage(),
                                                            ]) }}"
                                                                class="m-1 text-white btn btn-sm btn-warning"
                                                                title="Edit">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            <a href="{{ route('admin.course-sub-category.index', $category->id) }}"
                                                                class="m-1 text-white btn btn-sm btn-primary"
                                                                title="sub category">
                                                                <i class="fas fa-list"></i>
                                                            </a>
                                                            <a href="javascript:;" data-toggle="modal"
                                                                data-target="#deleteModal" class="btn btn-danger btn-sm"
                                                                onclick="deleteData({{ $category->id }})"><i
                                                                    class="fa fa-trash" aria-hidden="true"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <x-empty-table :name="__('Category')" route="admin.course-category.create"
                                                    create="yes" :message="__('No data found!')" colspan="7"></x-empty-table>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $categories->links() }}
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
        function deleteData(id) {
            $("#deleteForm").attr("action", "{{ url('/admin/course-category/') }}" + "/" + id)
        }

        function changeStatus(id) {
            var isDemo = "{{ env('PROJECT_MODE') ?? 1 }}"
            if (isDemo == 0) {
                toastr.error("{{ __('This Is Demo Version. You Can Not Change Anything') }}");
                return;
            }
            $.ajax({
                type: "put",
                data: {
                    _token: '{{ csrf_token() }}',
                },
                url: "{{ url('/admin/course-category/status-update') }}" + "/" + id,
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                    } else {
                        toastr.warning(response.message);
                    }
                },
                error: function(xhr, status, err) {
                    console.log(err);
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function (key, value) {
                        toastr.error(value);
                    })
                }
            })
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
