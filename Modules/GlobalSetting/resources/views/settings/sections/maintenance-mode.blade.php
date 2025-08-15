<div class="tab-pane fade" id="mmaintenance_mode_tab" role="tabpanel">
    <div class="form-group">
        <div class="alert alert-warning alert-has-icon">
            <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
            <div class="alert-body">
                <div class="alert-title">{{ __('Warning') }}</div>
                {{ __('If you enable maintenance mode, regular users wont be able to access the website. Please make sure to inform users about the temporary unavailability.') }}
            </div>
        </div>
        <input onchange="changeMaintenanceModeStatus()" {{ $setting->maintenance_mode ? 'checked' : '' }}
            id="maintenance_mode_toggle" type="checkbox" data-toggle="toggle" data-on="{{ __('Active') }}"
            data-off="{{ __('Inactive') }}" data-onstyle="success" data-offstyle="danger">
    </div>
    <form action="{{ route('admin.update-maintenance-mode') }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group ">
            <label>{{ __('Maintenance Mode Image') }}<span class="text-danger"></span></label>
            <div id="image-preview-maintenance" class="image-preview">
                <label for="image-upload-maintenance" id="image-label-maintenance">{{ __('Image') }}</label>
                <input type="file" name="maintenance_image" id="image-maintenance">
            </div>
            @error('maintenance_image')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="">{{ __('Maintenance Mode Title') }} <span class="text-danger">*</span></label>
            <input type="text" name="maintenance_title" class="form-control"
                value="{{ $setting->maintenance_title }}">
        </div>
        <div class="form-group">
            <label>{{ __('Maintenance Mode Description') }} <span class="text-danger">*</span></label>
            <textarea name="maintenance_description" id="" cols="30" rows="10" class="summernote">{!! clean($setting->maintenance_description) !!}</textarea>
        </div>
        <button class="btn btn-primary" type="submit">{{ __('Update') }}</button>

    </form>
</div>
