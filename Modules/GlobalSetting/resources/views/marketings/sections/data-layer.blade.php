<div class="tab-pane fade active show" id="google_data_layer_tab" role="tabpanel">
    <form action="{{ route('admin.update-data-layer') }}" method="POST">
        @csrf
        @method('PUT')
        <div class="text-right mb-3">
            <a class="btn btn-danger" data-active-tab="google_tag_tab" class="border-bottom search-menu-item" 
            href="{{ route('admin.crediential-setting') }}">{{ __('Google tag credential setup') }} <i class="fas fa-arrow-right"></i></a>
        </div>
        <label class="d-flex align-items-center">
            <input type="hidden" value="0" name="register" class="custom-switch-input">
            <input {{ $marketing_setting?->register ? 'checked' : '' }} type="checkbox" value="1"
                name="register" class="custom-switch-input">
            <span class="custom-switch-indicator"></span>
            <span class="custom-switch-description">{{ __('Register new student data layer') }}</span>
        </label>
        <label class="d-flex align-items-center">
            <input type="hidden" value="0" name="course_details" class="custom-switch-input">
            <input {{ $marketing_setting?->course_details ? 'checked' : '' }} type="checkbox" value="1"
                name="course_details" class="custom-switch-input">
            <span class="custom-switch-indicator"></span>
            <span class="custom-switch-description">{{ __('Course details page data layer') }}</span>
        </label>

        <label class="d-flex align-items-center">
            <input type="hidden" value="0" name="add_to_cart" class="custom-switch-input">
            <input {{ $marketing_setting?->add_to_cart ? 'checked' : '' }} type="checkbox" value="1"
                name="add_to_cart" class="custom-switch-input">
            <span class="custom-switch-indicator"></span>
            <span class="custom-switch-description">{{ __('Add to cart data layer') }}</span>
        </label>
        <label class="d-flex align-items-center">
            <input type="hidden" value="0" name="remove_from_cart" class="custom-switch-input">
            <input {{ $marketing_setting?->remove_from_cart ? 'checked' : '' }} type="checkbox" value="1"
                name="remove_from_cart" class="custom-switch-input">
            <span class="custom-switch-indicator"></span>
            <span class="custom-switch-description">{{ __('Cart remove data layer') }}</span>
        </label>
        <label class="d-flex align-items-center">
            <input type="hidden" value="0" name="order_success" class="custom-switch-input">
            <input {{ $marketing_setting?->order_success ? 'checked' : '' }} type="checkbox" value="1"
                name="order_success" class="custom-switch-input">
            <span class="custom-switch-indicator"></span>
            <span class="custom-switch-description">{{ __('Course Enrollment success data layer') }}</span>
        </label>
        <label class="d-flex align-items-center">
            <input type="hidden" value="0" name="order_failed" class="custom-switch-input">
            <input {{ $marketing_setting?->order_failed ? 'checked' : '' }} type="checkbox" value="1"
                name="order_failed" class="custom-switch-input">
            <span class="custom-switch-indicator"></span>
            <span class="custom-switch-description">{{ __('Course Enrollment failed data layer') }}</span>
        </label>
        <label class="d-flex align-items-center">
            <input type="hidden" value="0" name="contact_page" class="custom-switch-input">
            <input {{ $marketing_setting?->contact_page ? 'checked' : '' }} type="checkbox" value="1"
                name="contact_page" class="custom-switch-input">
            <span class="custom-switch-indicator"></span>
            <span class="custom-switch-description">{{ __('Contact us page data layer') }}</span>
        </label>
        <label class="d-flex align-items-center">
            <input type="hidden" value="0" name="instructor_contact" class="custom-switch-input">
            <input {{ $marketing_setting?->instructor_contact ? 'checked' : '' }} type="checkbox" value="1"
                name="instructor_contact" class="custom-switch-input">
            <span class="custom-switch-indicator"></span>
            <span class="custom-switch-description">{{ __('Instructor contact data layer') }}</span>
        </label>

        <button class="btn btn-primary">{{ __('Update') }}</button>

    </form>
</div>
