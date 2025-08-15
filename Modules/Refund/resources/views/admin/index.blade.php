@extends('admin.master_layout')
@section('title')
    <title>{{ $title }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ $title }}</h1>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <th>{{ __('SN') }}</th>
                                            <th>{{ __('User') }}</th>
                                            <th>{{ __('Order Id') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </thead>

                                        @forelse ($refund_requests as $index => $refund_request)
                                            <tr>
                                                <td>{{ ++$index }}</td>
                                                <td><a
                                                        href="{{ route('admin.customer-show', $refund_request->user_id) }}">{{ $refund_request?->user?->name }}</a>
                                                </td>
                                                <td>#<a target="_blank"
                                                        href="{{ route('admin.order', $refund_request?->order?->order_id) }}">{{ $refund_request?->order?->order_id }}</a>
                                                </td>


                                                <td>
                                                    @if ($refund_request->status == 'success')
                                                        <div class="badge badge-success">{{ __('Success') }}</div>
                                                    @elseif ($refund_request->status == 'rejected')
                                                        <div class="badge badge-danger">{{ __('Rejected') }}</div>
                                                    @else
                                                        <div class="badge badge-danger">{{ __('Pending') }}</div>
                                                    @endif
                                                </td>

                                                <td>
                                                    <a href="{{ route('admin.show-refund-request', $refund_request->id) }}"
                                                        class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>

                                                    <a href=""
                                                        data-url="{{ route('admin.delete-refund-request', $refund_request->id) }}"
                                                        class="btn btn-danger btn-sm delete"><i class="fa fa-trash"></i></a>

                                                </td>
                                            </tr>
                                        @empty
                                            <x-empty-table :name="__('Customer')" route="" create="no" :message="__('No data found!')"
                                                colspan="5"></x-empty-table>
                                        @endforelse
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="delete">
        <div class="modal-dialog" role="document">
            <form action="" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Delete refund request') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="text-danger">{{ __('Are You Sure to Delete this refund ?') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-danger">{{ __('Yes, Delete') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    @push('js')
        <script>
            $(function() {
                'use strict'

                $('.delete').on('click', function(e) {
                    e.preventDefault();
                    const modal = $('#delete');
                    modal.find('form').attr('action', $(this).data('url'));
                    modal.modal('show');
                })
            })
        </script>
    @endpush
@endsection
