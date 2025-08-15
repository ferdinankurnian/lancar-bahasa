<div class="tab-pane fade" id="copyright_text_tab" role="tabpanel">
    <form action="{{ route('admin.update-copyright-text') }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="">{{ __('Copyright Text') }}</label>
            <textarea name="copyright_text" rows="4" class="form-control h-auto">{{ $setting->copyright_text }}</textarea>
        </div>
        <button class="btn btn-primary" type="submit">{{ __('Update') }}</button>
    </form>
</div>
