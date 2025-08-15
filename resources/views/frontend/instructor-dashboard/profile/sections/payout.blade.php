<div class="tab-pane fade show {{ session('profile_tab') == 'payout' ? 'active' : '' }}" id="itemSeven-tab-pane"
    role="tabpanel" aria-labelledby="itemSeven-tab" tabindex="0">
    <div class="instructor__profile-form-wrap">
        <form action="{{ route('instructor.setting.payout.update') }}" method="POST" class="instructor__profile-form">
            @csrf
            @method('PUT')
            <div class="row">

                <div class="form-grp">
                    <label for="payout_account">{{ __('Payout Account') }} <code>*</code></label>
                    <select name="payout_account" id="payout_account" class="form-select">
                        <option value="">{{ __('Select') }}</option>
                        @foreach ($withdrawMethods as $method)  
                            <option  @selected($instructorRequest->payout_account == $method->name)  value="{{ $method->name }}">{{ $method->name }}</option>
                        @endforeach

                    </select>
                </div>

                <div class=" payment_info_wrap">
                    <div class="form-grp">
                        <label for="payment_information">{{ __('Payment Information') }} <code>*</code></label>
                        @foreach ($withdrawMethods as $method)  
                        <div class="normal-text payment-{{ $method->name }} payment-info {{ $instructorRequest->payout_account == $method->name ? '' : 'd-none' }}">
                            {!! clean($method->description) !!}
                        </div>
                        @endforeach

                        <textarea name="payout_information" placeholder="{{ __('Information') }}">{!! clean($instructorRequest->payout_information) !!}</textarea>
                    </div>
                </div>
            </div>
            <div class="submit-btn mt-25">
                <button type="submit" class="btn">{{ __('Update Payout') }}</button>
            </div>
        </form>
    </div>
</div>
