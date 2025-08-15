@extends('admin.master_layout')
@section('title')
    <title>{{ __('Email Template') }}</title>
@endsection
@section('admin-content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Email Template') }}</h1>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.update-email-template', $template->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="">{{ __('Subject') }} <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" value="{{ $template->subject }}"
                                            name="subject">
                                    </div>
                                    <div class="form-group">
                                        <label for="">{{ __('Message') }} <span class="text-danger">*</span></label>
                                        <textarea name="message" cols="30" rows="10" class="form-control summernote">{{ $template->message }}</textarea>
                                    </div>
                                    <button class="btn btn-success" type="submit">{{ __('Update') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>
@endsection
