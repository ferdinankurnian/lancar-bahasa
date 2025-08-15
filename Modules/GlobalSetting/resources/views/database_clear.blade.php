@extends('admin.master_layout')
@section('title')
    <title>{{ __('Database clear') }}</title>
@endsection
@section('admin-content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <div class="section-header-back">
                    <a href="{{ route('admin.settings') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
                </div>
                <h1>{{ __('Database clear') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                    </div>
                    <div class="breadcrumb-item active"><a href="{{ route('admin.settings') }}">{{ __('Settings') }}</a>
                    </div>
                    <div class="breadcrumb-item">{{ __('Database clear') }}</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="alert alert-warning alert-has-icon">
                                    <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                                    <div class="alert-body">
                                        <div class="alert-title">{{ __('Warning') }}</div>
                                        {{ __('If you want to use the software from scratch, you have to clear database. You do not need to remove the existing data one by one') }}
                                    </div>
                                </div>

                                <button class="btn btn-danger" data-toggle="modal"
                                    data-target="#clearDatabaseModal">{{ __('Clear Database') }}</button>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="clearDatabaseModal">
        <div class="modal-dialog" role="document">
            <form class="modal-content" action="{{ route('admin.database-clear-success') }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Clear Database Confirmation') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{ __('Are you really want to clear this database?') }}</p>
                    <label>{{ __('Password') }} <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" name="password"
                        tabindex="2">
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Yes, Delete') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
