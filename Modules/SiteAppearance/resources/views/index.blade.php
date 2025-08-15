@extends('admin.master_layout')
@section('title')
    <title>{{ __('Themes') }}</title>
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('backend/css/colorpicker.css') }}">
@endpush
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Themes') }}</h1>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-md-12 col-lg-4">
                        <div class="card appearance_card_margin">
                            <div class="card-body">
                                <form action="{{ route('admin.site-appearance.update', 1) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label>{{ __('Select Theme') }}</label>
                                        @use(App\Enums\ThemeList)
                                        <select class="form-control" name="theme">
                                            @foreach (ThemeList::cases() as $theme)
                                                <option @selected(Cache::get('setting')?->site_theme == $theme->value) value="{{ $theme->value }}">
                                                    {{ __($theme->value) }}</option>
                                            @endforeach
                                        </select>
                                        <div class="form-group">
                                            <label class="custom-switch p-0 mt-1">
                                                <input type="checkbox" name="show_all_homepage" value="1"
                                                    class="custom-switch-input" @checked($setting?->show_all_homepage == 1)>
                                                <span class="custom-switch-indicator"></span>
                                                <span
                                                    class="custom-switch-description">{{ __('Show all home pages') }}</span>
                                            </label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <h6 class="text-center">{{ __(ThemeList::MAIN->value) }}</h6>
                        <div class="screen">
                            <img src="{{ asset('uploads/website-images/theme-one.png') }}">
                        </div>

                    </div>
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <h6 class="text-center">{{ __(ThemeList::ONLINE->value) }}</h6>
                        <div class="screen">
                            <img src="{{ asset('uploads/website-images/theme-two.png') }}">
                        </div>

                    </div>
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <h6 class="text-center">{{ __(ThemeList::UNIVERSITY->value) }}</h6>
                        <div class="screen">
                            <img src="{{ asset('uploads/website-images/theme-three.webp') }}">
                        </div>

                    </div>
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <h6 class="text-center">{{ __(ThemeList::BUSINESS->value) }}</h6>
                        <div class="screen">
                            <img src="{{ asset('uploads/website-images/theme-four.webp') }}">
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <h6 class="text-center">{{ __(ThemeList::YOGA->value) }}</h6>
                        <div class="screen">
                            <img src="{{ asset('uploads/website-images/theme-five.webp') }}">
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <h6 class="text-center">{{ __(ThemeList::KITCHEN->value) }}</h6>
                        <div class="screen">
                            <img src="{{ asset('uploads/website-images/theme-six.webp') }}">
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <h6 class="text-center">{{ __(ThemeList::LANGUAGE->value) }}</h6>
                        <div class="screen">
                            <img src="{{ asset('uploads/website-images/theme-seven.webp') }}">
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <h6 class="text-center">{{ __(ThemeList::KINDERGARTEN->value) }}</h6>
                        <div class="screen">
                            <img src="{{ asset('uploads/website-images/theme-eight.webp') }}">
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('js')
    <script src="{{ asset('backend/js/colorpicker.js') }}"></script>
    <script>
        $(".colorpickerinput").colorpicker({
            format: 'hex',
            component: '.input-group-append',
        });
    </script>
@endpush
