@extends('admin.master_layout')
@section('title')
    <title>{{ __('Subscriber List') }}</title>
@endsection
@section('admin-content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Subscriber List') }}</h1>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive table-invoice">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{ __('SN') }}</th>
                                                <th>{{ __('Email') }}</th>
                                                <th>{{ __('Subscribed at') }}</th>
                                                <th>{{ __('Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($newsletters as $index => $item)
                                                <tr>
                                                    <td>{{ ++$index }}</td>
                                                    <td>{{ html_decode($item->email) }}</td>
                                                    <td>{{ $item->created_at->format('h:iA, d M Y') }}</td>
                                                    <td>
                                                        <a onclick="deleteData({{ $item->id }})" href="javascript:;"
                                                            data-toggle="modal" data-target="#deleteModal"
                                                            class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <x-empty-table :name="__('')" route="" create="no"
                                                    :message="__('No data found!')" colspan="4"></x-empty-table>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>

    <x-admin.delete-modal />
    @push('js')
        <script>
            function deleteData(id) {
                $("#deleteForm").attr("action", '{{ url('/admin/subscriber-delete/') }}' + "/" + id)
            }
        </script>
    @endpush
@endsection
