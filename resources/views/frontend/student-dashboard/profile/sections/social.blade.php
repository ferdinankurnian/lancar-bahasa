<div class="tab-pane fade show {{ session('profile_tab') == 'social' ? 'active': '' }}" id="itemThree-tab-pane" role="tabpanel" aria-labelledby="itemThree-tab"
tabindex="0">
<div class="instructor__profile-form-wrap">
    <form action="{{ route('student.setting.socials.update') }}" method="POST" class="instructor__profile-form">
      @csrf
      @method('PUT')
        <div class="form-grp">
            <label for="facebook">{{ __('Facebook') }}</label>
            <input id="facebook" name="facebook" type="url" value="{{ $user->facebook }}">
        </div>
        <div class="form-grp">
            <label for="twitter">{{ __('Twitter') }}</label>
            <input id="twitter" name="twitter" type="url" value="{{ $user->twitter }}">
        </div>
        <div class="form-grp">
            <label for="linkedin">{{ __('Linkedin') }}</label>
            <input id="linkedin" name="linkedin" type="url" value="{{ $user->linkedin }}">
        </div>
        <div class="form-grp">
            <label for="website">{{ __('Website') }}</label>
            <input id="website" name="website" type="url" value="{{ $user->website }}">
        </div>
        <div class="form-grp">
            <label for="github">{{ __('Github') }}</label>
            <input id="github" name="github" type="url" value="{{ $user->github }}">
        </div>
        <div class="submit-btn mt-25">
            <button type="submit" class="btn">{{ __('Update Social') }}</button>
        </div>
    </form>
</div>
</div>

