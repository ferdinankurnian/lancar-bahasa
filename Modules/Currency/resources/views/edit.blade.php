@extends('admin.master_layout')
@section('title')
    <title>{{ __('Edit Currency') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <div class="section-header-back">
                    <a href="{{ route('admin.currency.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
                </div>
                <h1>{{ __('Edit Currency') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                    </div>
                    <div class="breadcrumb-item active"><a
                            href="{{ route('admin.currency.index') }}">{{ __('Currency List') }}</a>
                    </div>
                    <div class="breadcrumb-item">{{ __('Edit Currency') }}</div>
                </div>
            </div>
            <div class="section-body">
                <a href="{{ route('admin.currency.index') }}" class="btn btn-primary"><i class="fas fa-list"></i>
                    {{ __('Currency List') }}</a>
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.currency.update', $currency->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label>{{ __('Currency Name') }} <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="currency_name"
                                                value="{{ $currency->currency_name }}">
                                        </div>

                                        <div class="form-group col-12">
                                            <label>{{ __('Country Code') }} <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="country_code"
                                                value="{{ $currency->country_code }}">
                                        </div>

                                        <div class="form-group col-12">
                                            <label>{{ __('Currency Code') }} <span class="text-danger">*</span></label>
                                            <select name="currency_code" class="form-control select2">
                                                <option value="">{{ __('Select') }}</option>
                                                @foreach($all_currency as $key => $value)
                                                <option @selected($key == $currency->currency_code) value="{{ $key }}">{{ $key }} - {{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-12">
                                            <label>{{ __('Currency Icon') }} <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="currency_icon"
                                                value="{{ $currency->currency_icon }}">
                                        </div>

                                        <div class="form-group col-12">
                                            <label>{{ __('Currency Rate') }} <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="currency_rate"
                                                value="{{ $currency->currency_rate }}">
                                        </div>

                                        <div class="form-group col-12">
                                            <label>{{ __('Default') }} <span class="text-danger">*</span></label>
                                            <select name="is_default" class="form-control">
                                                <option value="no" {{ $currency->is_default == 'no' ? 'selected' : '' }}>
                                                    {{ __('No') }}</option>
                                                <option value="yes"
                                                    {{ $currency->is_default == 'yes' ? 'selected' : '' }}>
                                                    {{ __('Yes') }}</option>
                                            </select>
                                        </div>


                                        <div class="form-group col-12">
                                            <label>{{ __('Currency Position') }} <span class="text-danger">*</span></label>
                                            <select name="currency_position" class="form-control">
                                                <option
                                                    {{ $currency->currency_position == 'before_price' ? 'selected' : '' }}
                                                    value="before_price">{{ __('Before Price') }}</option>
                                                <option
                                                    {{ $currency->currency_position == 'before_price_with_space' ? 'selected' : '' }}
                                                    value="before_price_with_space">{{ __('Before Price With Space') }}
                                                </option>
                                                <option {{ $currency->currency_position == 'after_price' ? 'selected' : '' }}
                                                    value="after_price">{{ __('After Price') }}</option>
                                                <option
                                                    {{ $currency->currency_position == 'after_price_with_space' ? 'selected' : '' }}
                                                    value="after_price_with_space">{{ __('After Price With Space') }}
                                                </option>
                                            </select>
                                        </div>

                                        <div class="form-group col-12">
                                            <label>{{ __('Status') }} <span class="text-danger">*</span></label>
                                            <select name="status" class="form-control">
                                                <option value="active" {{ $currency->status == 'active' ? 'selected' : '' }}>
                                                    {{ __('Active') }}</option>
                                                <option value="inactive"
                                                    {{ $currency->status == 'inactive' ? 'selected' : '' }}>
                                                    {{ __('Inactive') }}</option>
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
            </div>
        </section>
    </div>
@endsection
