@extends('admin.master_layout')
@section('title')
<title>{{ __('Send bulk mail to all') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Send bulk mail to all') }}</h1>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.send-bulk-mail-to-all') }}" method="POST">
                                    @csrf

                                    <div class="form-group">
                                        <label for="">{{ __('Subject') }} <code>*</code></label>
                                        <input type="text" class="form-control" name="subject">
                                    </div>

                                    <div class="form-group">
                                        <label for="">{{ __('Description') }} <code>*</code></label>
                                        <textarea name="description" class="summernote" id="" cols="30" rows="10"></textarea>
                                    </div>

                                    <button type="submit" class="btn btn-primary">{{ __('Send Mail') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
