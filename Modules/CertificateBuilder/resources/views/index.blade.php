@extends('admin.master_layout')
@section('title')
    <title>{{ __('Certificate Builder') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Certificate Builder') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                    </div>
                    <div class="breadcrumb-item">{{ __('Certificate Builder') }}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row mt-4">
                    <div class="col-lg-4">
                        <div class="alert alert-primary d-flex align-items-center" role="alert">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16"
                                role="img" aria-label="Warning:">
                                <path
                                    d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                            </svg>
                            <div class="ml-3">
                                {{ __('There are bunch of handy tags you can use, like [student_name], [platform_name], [course], [date], [instructor_name]. Feel free to use them anywhere in your titles, subtitles or description') }}
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h4>{{ __('Certificate Details') }}</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.certificate-builder.update', 1) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group">
                                        <label for="">{{ __('Background Image') }} <code>( 930px * 600px )
                                                *</code></label>
                                        <div id="image-preview-background" class="image-preview">
                                            <label for="image-upload-background"
                                                id="image-label-background">{{ __('Image') }}</label>
                                            <input type="file" name="background" id="image-upload-background">
                                        </div>
                                        @error('image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="">{{ __('Title') }}</label>
                                        <input type="text" class="form-control" name="title"
                                            value="{{ $certificate->title }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="">{{ __('Sub Title') }}</label>
                                        <input type="text" class="form-control" name="sub_title"
                                            value="{{ $certificate->sub_title }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="">{{ __('Description') }}</label>
                                        <textarea id="" class="form-control hight-200" name="description">{!! clean($certificate->description) !!}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="">{{ __('Signature') }}
                                            <code>{{ __('Suggested: (120px * 40px)') }}</code></label>
                                                *</code></label>
                                        <div id="image-preview-signature" class="image-preview">
                                            <label for="image-upload-signature"
                                                id="image-label-signature">{{ __('Image') }}</label>
                                            <input type="file" name="signature" id="image-upload-signature">
                                        </div>
                                        @error('signature')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card">
                            
                            <div class="card-body">
                                <p class="text-center text-danger">{{ __('Background size will be ( 930px * 600px )') }}
                                </p>
                                <div class="certificate-outer">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <div class="certificate-body">
                                                @if ($certificate->title)
                                                    <div id="title" class="draggable-element">{{ $certificate->title }}
                                                    </div>
                                                @endif
                                                @if ($certificate->sub_title)
                                                    <div id="sub_title" class="draggable-element">
                                                        {{ $certificate->sub_title }}
                                                    </div>
                                                @endif

                                                @if ($certificate->description)
                                                    <div id="description" class="draggable-element">{!! nl2br(clean($certificate->description)) !!}
                                                    </div>
                                                @endif

                                                @if ($certificate->description)
                                                    <div id="signature" class="draggable-element"><img
                                                            src="{{ asset($certificate->signature) }}" alt="">
                                                    </div>
                                                @endif
                                            </div>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('js')
    <script src="{{ asset('global/js/jquery-ui.min.js') }}"></script>

    <script>
        // Make draggable items draggable
        $('.draggable-element').draggable({
            containment: '.certificate-body', // Restrict draggable within certificate-body
            stop: function(event, ui) {
                var elementId = $(this).attr('id');
                var xPosition = ui.position.left;
                var yPosition = ui.position.top;

                console.log(elementId, xPosition, yPosition);

                // Send AJAX request to update position
                $.ajax({
                    url: '{{ url("/admin/certificate-builder/item/update") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        element_id: elementId,
                        x_position: xPosition,
                        y_position: yPosition
                    },
                    success: function(response) {
                        console.log(response.message);
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function (key, value) {
                            toastr.error(value);
                        })
                    }
                });
            }
        });
    </script>
@endpush

@push('css')
    <style>
        @foreach ($certificateItems as $item)
            #{{ $item->element_id }} {
                left: {{ $item->x_position }}px;
                top: {{ $item->y_position }}px;
            }
        @endforeach

        .certificate-outer {
            display: flex;
            justify-content: center;
        }

        .certificate-body {
            width: 930px !important;
            height: 600px !important;
            background: rgb(231, 231, 231);
            position: relative;
            background-image: url({{ asset($certificate->background) }});
        }

        .draggable-element {
            position: absolute;
            cursor: move;
        }

        #title {
            font-size: 22px;
            font-weight: bold;
            color: black
        }

        #sub_title {
            font-size: 18px;
            color: black;
            text-align: inherit;
            font-weight: inherit;
        }

        #description {
            font-size: 16px;
            color: black;
            text-align: center;
            font-weight: inherit;
            margin-left: 100px;
            margin-right: 100px;

        }
    </style>
@endpush
@push('js')
    <script src="{{ asset('backend/js/jquery.uploadPreview.min.js') }}"></script>
    <script>
        $.uploadPreview({
            input_field: "#image-upload-background",
            preview_box: "#image-preview-background",
            label_field: "#image-label-background",
            label_default: "{{ __('Choose Image') }}",
            label_selected: "{{ __('Change Image') }}",
            no_label: false,
            success_callback: null
        })
        $('#image-preview-background').css({
            'background-image': 'url({{ asset($certificate->background) }})',
            'background-size': 'contain',
            'background-position': 'center',
            'background-repeat': 'no-repeat'
        });
        $.uploadPreview({
            input_field: "#image-upload-signature",
            preview_box: "#image-preview-signature",
            label_field: "#image-label-signature",
            label_default: "{{ __('Choose Image') }}",
            label_selected: "{{ __('Change Image') }}",
            no_label: false,
            success_callback: null
        })
        $('#image-preview-signature').css({
            'background-image': 'url({{ asset($certificate->signature) }})',
            'background-size': 'contain',
            'background-position': 'center',
            'background-repeat': 'no-repeat'
        });
    </script>
@endpush
