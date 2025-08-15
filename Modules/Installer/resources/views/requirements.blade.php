@extends('installer::app')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <p>Minimum Requirements</p>
            <div>
                <a class="btn btn-outline-primary" href="{{route('setup.verify')}}">&laquo; Back</a>
                <a class="btn btn-outline-primary @if (!session()->has('requirements-complete')) disabled @endif" href="{{route('setup.database')}}">Next &raquo;</a>
            </div>
        </div>
        <div class="card-body">
            <ul class="list-group">
                @foreach ($checks as $key => $check)
                    <li class="list-group-item d-flex justify-content-between align-items-left">
                        <div>
                            @if (array_key_exists($key, $failedChecks))
                                <i class="fas fa-times text-danger fa-fw"></i>
                            @else
                                <i class="fa fa-check text-success fa-fw"></i>
                            @endif
                            <span>{{ __('installer::setup.' . $key) }}</span>
                        </div>
                        @if (array_key_exists($key, $failedChecks))
                            <span class="badge bg-danger rounded-pill">{{ $failedChecks[$key]['message'] }}
                                @if (isset($failedChecks[$key]['url']))
                                    <a href="{{ $failedChecks[$key]['url'] }}" class="text-warning" target="_blank"
                                        rel="noopener noreferrer">(!)</a>
                                @endif
                            </span>
                        @endif
                    </li>
                @endforeach
            </ul>
            <div class="d-flex justify-content-end align-items-center mt-3">
                @if ($success)
                    <a href="{{ route('setup.database') }}" class="btn btn-primary">
                        Next
                    </a>
                @else
                    <span class="text-danger text-small fw-bold me-2">Enable all extension then click reload
                        button</span>
                    <a href="{{ route('setup.database') }}" class="btn btn-success">
                        Reload <i class="fa fa-sync"></i>
                    </a>
                @endif
            </div>
        </div>
        <div class="card-footer text-center">
            <p>For script support, contact us at <a href="https://websolutionus.com/page/support"
                target="_blank" rel="noopener noreferrer">@websolutionus</a>. We're here to help. Thank you!</p>
        </div>
    </div>
@endsection