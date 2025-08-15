<div class="tab-pane fade" id="custom_pagination_tab" role="tabpanel">
    <form action="{{ route('admin.update-custom-pagination') }}" method="POST">
        @csrf
        @method('PUT')

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th width="50%">{{ __('Section Name') }}</th>
                    <th width="50%">{{ __('Quantity') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($custom_paginations as $custom_pagination)
                    <tr>
                        <td>{{ $custom_pagination->section_name }}</td>
                        <td>
                            <input type="number" value="{{ $custom_pagination->item_qty }}" name="quantities[]"
                                class="form-control">
                            <input type="hidden" value="{{ $custom_pagination->id }}" name="ids[]">
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
        <button class="btn btn-primary">{{ __('Update') }}</button>
    </form>
</div>
