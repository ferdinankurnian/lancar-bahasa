@props(['id' =>"deleteModal" ])
<div tabindex="-1" role="dialog" id="{{$id}}" {{ $attributes->merge(['class' => 'modal fade']) }}>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Item Delete Confirmation') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{ __('Are You sure want to delete this item ?') }}</p>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <form id="deleteForm" action="" method="POST">
                    @csrf
                    @method('DELETE')

                    <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Yes, Delete') }}</button>

                </form>
            </div>
        </div>
    </div>
</div>