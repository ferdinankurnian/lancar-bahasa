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
                <a href="{{ route('admin.email-configuration') }}" class="btn btn-primary"><i class="fas fa-list"></i>
                    {{ __('Email Template') }}</a>
                <div class="row mt-4">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <th>{{ __('Variable') }}</th>
                                        <th>{{ __('Meaning') }}</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            @php
                                                $name = '{{name}}';
                                            @endphp
                                            <td>{{ $name }}</td>
                                            <td>{{ __('User Name') }}</td>
                                        </tr>

                                        <tr>
                                            @php
                                                $name = '{{order_id}}';
                                            @endphp
                                            <td>{{ $name }}</td>
                                            <td>{{ __('order_id') }}</td>
                                        </tr>

                                        <tr>
                                            @php
                                                $name = '{{paid_amount}}';
                                            @endphp
                                            <td>{{ $name }}</td>
                                            <td>{{ __('paid_amount') }}</td>
                                        </tr>
                                        <tr>
                                            @php
                                                $name = '{{payment_method}}';
                                            @endphp
                                            <td>{{ $name }}</td>
                                            <td>{{ __('payment_method') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
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
                                        <label for="">{{ __('Subject') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" value="{{ $template->subject }}"
                                            name="subject">
                                    </div>
                                    <div class="form-group">
                                        <label for="">{{ __('Message') }} <span
                                                class="text-danger">*</span></label>
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
