@extends('admin.master_layout')
@section('title')
<title>{{ __('Withdraw Method') }}</title>
@endsection
@section('admin-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{ __('Create Withdraw Method') }}</h1>

          </div>

          <div class="section-body">
            <a href="{{ route('admin.withdraw-method.index') }}" class="btn btn-primary"><i class="fas fa-list"></i> {{ __('Withdraw Method') }}</a>
            <div class="row mt-4">
                <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.withdraw-method.store') }}" method="POST" >
                            @csrf
                            <div class="row">

                                <div class="form-group col-12">
                                    <label>{{ __('Name') }} <span class="text-danger">*</span></label>
                                    <input type="text" id="name" class="form-control"  name="name" value="{{ old('name') }}">
                                </div>

                                <div class="form-group col-12">
                                    <label>{{ __('Minimum Amount') }} <span class="text-danger">*</span></label>
                                    <input type="text" id="minimum_amount" class="form-control"  name="minimum_amount" value="{{ old('minimum_amount') }}">
                                </div>

                                <div class="form-group col-12">
                                    <label>{{ __('Maximum Amount') }} <span class="text-danger">*</span></label>
                                    <input type="text" id="maximum_amount" class="form-control"  name="maximum_amount" value="{{ old('maximum_amount') }}">
                                </div>

                                <div class="form-group col-12">
                                    <label>{{ __('Description') }} <span class="text-danger">*</span></label>
                                    <textarea name="description" id="" cols="30" rows="10" class="summernote">{{ old('description') }}</textarea>
                                </div>

                                <div class="form-group col-12">
                                    <label>{{ __('Status') }} <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control">
                                        <option value="active">{{ __('Active') }}</option>
                                        <option value="inactive">{{ __('Inactive') }}</option>
                                    </select>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button class="btn btn-primary">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                  </div>
                </div>
          </div>
        </section>
      </div>
@endsection
