@extends('admin.master_layout')
@section('title')
    <title>{{ __('Translate Language') }} ({{ $language->name }})</title>
@endsection

@section('admin-content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <div class="section-header-back">
                    <a href="{{ route('admin.languages.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
                </div>
                <h1>{{ __('Translate Language') }} ({{ $language->name }})</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active">
                        <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                    </div>
                    <div class="breadcrumb-item active">
                        <a href="{{ route('admin.languages.index') }}">{{ __('Manage Language') }}</a>
                    </div>
                    <div class="breadcrumb-item">{{ __('Translate Language') }} ({{ $language->name }})</div>
                </div>
            </div>

            <div class="section-body">

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h5 class="service_card">{{ __('Language Translations') }}</h5>
                            <div>
                                <a href="{{ route('admin.languages.index') }}" class="btn btn-primary"><i
                                        class="fa fa-arrow-left"></i>{{ __('Back') }}</a>
                            </div>
                        </div>
                        <hr>
                        <div class="lang_list_top">
                            <ul class="lang_list">
                                @foreach ($languages as $lang)
                                    <li><a href="{{ route('admin.languages.edit-static-languages', $lang->code) }}"><i
                                                class="fas {{ $lang->code !== request('code') ? 'fa-edit' : 'fa-eye' }}"></i>
                                            {{ $lang->name }}</a></li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="mt-2 alert alert-danger" role="alert">
                            <p>{{ __('Your editing mode') }} : <b>{{ $language->name }}</b></p>
                        </div>
                    </div>
                </div>

                <div class="mt-4 row">
                    <div class="col">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h4>{{ __('Edit') }} {{ ucwords(str_replace(['_', '-'], ' ', request('file'))) }}
                                    {{ __('Language') }}</h4>
                                <div>
                                    <form onchange="$(this).trigger('submit')"
                                        action="{{ route('admin.languages.edit-static-languages', ['code' => request('code'), 'file' => request('file')]) }}"
                                        method="get">

                                        <div class="input-group">
                                            <input type="text" name="search" class="form-control search-input"
                                                value="{{ request('search') }}" placeholder="{{ __('Search') }}">
                                            <button type="submit"
                                                class="btn btn-lg btn-primary">{{ __('Search') }}</button>
                                        </div>
                                    </form>
                                </div>
                                <button type="button" id="translateAll" class="btn btn-primary"
                                    data-code="{{ request('code') }}"
                                    data-file="{{ request('file') }}">{{ __('Translate All To ') }}{{ $language->name }}</button>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.languages.update-static-languages', request('code')) }}"
                                    method="post">
                                    @csrf
                                    <table class="table table-bordered">
                                        @php($paginateData = [])
                                        @foreach ($data as $index => $value)
                                            <tr>
                                                <td width="50%">{{ $index }}</td>
                                                <td width="50%">
                                                    <input type="text" id="translation-{{ $loop->index + 1 }}"
                                                        class="form-control" name="values[{{ $index }}]"
                                                        value="{{ $value }}">
                                                </td>
                                                <td>
                                                    <span class="d-flex">
                                                        <button type="button"
                                                            onclick="AutoTrans('translation-{{ $loop->index + 1 }}', '{{ $index }}', '{{ request('code') }}')"
                                                            class="ml-1 text-white btn btn-sm bg-success lang-btn">
                                                            {{ __('Translate') }}
                                                        </button>
                                                    </span>
                                                </td>
                                            </tr>
                                            @php($paginateData[$index] = $value)
                                        @endforeach
                                    </table>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-lg btn-primary">{{ __('Update') }}</button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer d-flex justify-content-center">
                                {{ $data->onEachSide(0)->links() }}
                            </div>

                        </div>
                    </div>
                </div>
            </div>


        </section>
    </div>
@endsection
@push('css')
<style>
    .form-control.search-input{
        margin-bottom: 0!important
    }
</style>
@endpush

@push('js')
    <script src="{{ asset('backend/js/iziToast.min.js') }}"></script>
    <script>
        function AutoTrans(key, value, lang) {
            $('.lang-btn').prop('disabled', true);

            $.ajax({
                url: "{{ route('admin.languages.update.single') }}",
                type: "POST",
                data: {
                    lang: lang,
                    text: value,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                beforeSend: function() {
                    iziToast.show({
                        timeout: false,
                        close: false,
                        theme: 'dark',
                        icon: 'loader',
                        iconUrl: 'https://hub.izmirnic.com/Files/Images/loading.gif',
                        title: "{{ __('Translation Processing, please wait...') }}",
                        position: 'center',
                    });
                },
                success: function(result) {
                    $('input[id=' + key + ']').val(result);
                    $('.lang-btn').prop('disabled', false);
                    iziToast.destroy();
                    toastr.success('Success', 'Success');
                },
                error: function(file, response) {
                    console.log(response);
                    iziToast.destroy();
                    toastr.error('Error', 'Error');
                    setTimeout(() => {
                        $('.lang-btn').prop('disabled', false);
                    }, 1000);
                }
            });
        }
    </script>

    <script>
        $('#translateAll').on('click', function() {
            iziToast.question({
                timeout: 20000,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 999,
                title: "{{ __('This will take a while!') }}",
                message: "{{ __('Are you sure?') }}",
                position: 'center',
                buttons: [
                    ["<button><b>{{ __('YES') }}</b></button>", function(instance, toast) {
                        var isDemo = "{{ env('PROJECT_MODE') ?? 1 }}";
                        var code = $('#translateAll').data('code');
                        var file = $('#translateAll').data('file');

                        if (isDemo == 0) {
                            instance.hide({
                                transitionOut: 'fadeOut'
                            }, toast, 'button');
                            toastr.error(
                                "{{ __('This Is Demo Version. You Can Not Change Anything') }}"
                            );
                            return;
                        }

                        $.ajax({
                            type: "post",
                            data: {
                                _token: '{{ csrf_token() }}',
                                code: code,
                                file: file,
                                texts: "{{ json_encode($paginateData) }}",
                            },
                            url: "{{ route('admin.languages.translateAll') }}",
                            beforeSend: function() {
                                instance.hide({
                                    transitionOut: 'fadeOut'
                                }, toast, 'button');

                                iziToast.show({
                                    timeout: false,
                                    close: true,
                                    theme: 'dark',
                                    icon: 'loader',
                                    iconUrl: 'https://hub.izmirnic.com/Files/Images/loading.gif',
                                    title: "{{ __('This will take a while! wait....') }}",
                                    position: 'center',
                                });
                                $('.lang-btn').prop('disabled', true);
                            },
                            success: function(response) {
                                if (response.success) {
                                    $('.lang-btn').prop('disabled', false);
                                    iziToast.destroy();
                                    toastr.success(response.message);
                                    setTimeout(function() {
                                        window.location.reload();
                                    }, 2000);
                                }
                            },
                            error: function(err) {
                                $('.lang-btn').prop('disabled', false);
                                iziToast.destroy();
                                toastr.error("{{ __('Failed!') }}")
                                console.log(err);
                            },
                        })

                    }, true],
                    ["<button>{{ __('NO') }}</button>", function(instance, toast) {

                        instance.hide({
                            transitionOut: 'fadeOut'
                        }, toast, 'button');

                    }],
                ],
                onClosing: function(instance, toast, closedBy) {},
                onClosed: function(instance, toast, closedBy) {}
            });
        });
    </script>
@endpush
