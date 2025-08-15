<div class="tab-pane fade" id="default_avatar_tab" role="tabpanel">
    <form action="{{ route('admin.update-default-avatar') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="">{{ __('Existing avatar') }}</label>
            <div>
                <img class="w_120" src="{{ !empty($setting->default_avatar) ? asset($setting->default_avatar) : '' }}"
                    alt="" id="defaultAvatarPreview">
            </div>
        </div>

        <div class="form-group">
            <label for="">{{ __('New avatar') }}</label>
            <input id="defaultAvatarInput" type="file" name="default_avatar" class="form-control-file">
        </div>


        <button class="btn btn-primary">{{ __('Update') }}</button>
    </form>
</div>
