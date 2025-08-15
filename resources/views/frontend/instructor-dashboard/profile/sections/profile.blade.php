<div class="tab-pane fade show {{ session('profile_tab') == 'profile' ? 'active': '' }}" id="itemOne-tab-pane" role="tabpanel" aria-labelledby="itemOne-tab" tabindex="0">
    <div class="instructor__cover-bg preview-cover-img" data-background="{{ asset($user->cover) }}">
        <div class="instructor__cover-info">
            <div class="instructor__cover-info-left">
                <div class="thumb">
                    <img class="preview-avatar" src="{{ asset($user->image) }}"
                        alt="img">
                </div>
                <button title="Upload Photo" onclick="$('#avatar').trigger('click')"><i
                        class="fas fa-camera"></i></button>

            </div>
            <div class="instructor__cover-info-right">
                <a href="javascript:;" onclick="$('#cover-img').trigger('click')"
                    class="btn btn-two arrow-btn">{{ __('Edit Cover Photo') }}</a>
            </div>
        </div>
    </div>
    <div class="instructor__profile-form-wrap">
        <form action="{{ route('instructor.setting.profile.update') }}" method="POST" enctype="multipart/form-data" class="instructor__profile-form">
            @csrf
            @method('PUT')
            <input type="file" name="avatar" id="avatar" hidden>
            <input type="file" name="cover" id="cover-img" hidden>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-grp">
                        <label for="name">{{ __('Full Name') }} <code>*</code></label>
                        <input id="name" name="name" type="text" value="{{ $user->name }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-grp">
                        <label for="email">{{ __('Email') }} <code>*</code></label>
                        <input id="email" name="email" type="email" value="{{ $user->email }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-grp">
                        <label for="phone">{{ __('phone') }}</label>
                        <input id="phone" name="phone" type="text" value="{{ $user->phone }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-grp">
                        <label for="gender">{{ __('Gender') }}</label>
                        <select name="gender" id="gender" class="form-select">
                            <option value="">{{ __('Select') }}</option>
                            <option @selected($user->gender == 'male') value="male">{{ __('Male') }}</option>
                            <option @selected($user->gender == 'female') value="female">{{ __('Female') }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-grp">
                        <label for="age">{{ __('Age') }}</label>
                        <input id="age" name="age" type="text" value="{{ $user->age }}">
                    </div>
                </div>

            </div>

            <div class="submit-btn mt-25">
                <button type="submit" class="btn">{{ __('Update Info') }}</button>
            </div>
        </form>
    </div>
</div>
