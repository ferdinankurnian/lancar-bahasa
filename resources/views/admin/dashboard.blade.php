@extends('admin.master_layout')
@section('title')
    <title>{{ __('Dashboard') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        {{-- Show Credentials Setup Alert --}}
        @if (Route::is('admin.dashboard') && ($checkCrentials = checkCrentials()))
            @if ($checkCrentials->status)
                <div class="alert alert-danger alert-has-icon alert-dismissible d-none" id="missingCrentialsAlert">
                    <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                    <div class="alert-body">
                        <div class="alert-title">{{ $checkCrentials->message }}</div>
                        <button class="close" id="missingCrentialsAlertClose" data-dismiss="alert">
                            <span><i class="fas fa-times"></i></span>
                        </button>
                        {{ $checkCrentials->description }} <b><a class="btn btn-sm btn-outline-warning"
                                href="{{ !empty($checkCrentials->route) ? route($checkCrentials->route) : url($checkCrentials->url) }}">{{ __('Update') }}</a></b>
                    </div>
                </div>
            @endif
        @endif

        @if ($setting->is_queable == 'active' && Cache::get('corn_working') !== 'working')
            <div class="alert alert-danger alert-has-icon alert-dismissible show fade">
                <div class="alert-icon"><i class="fas fa-sync"></i></div>
                <div class="alert-body">
                    <div class="alert-title"><a href="{{ route('admin.general-setting') }}" target="_blank"
                            rel="noopener noreferrer">{{ __('Corn Job Is Not Running! Many features will be disabled and face errors') }}</a>
                    </div>
                    <button class="close" data-dismiss="alert">
                        <span><i class="fas fa-times"></i></span>
                    </button>
                </div>
            </div>
        @endif

        <section class="section">
            <div class="section-header">
                <h1>{{ __('Dashboard') }}</h1>
            </div>

            <div class="section-body">
                @if(checkAdminHasPermission('course.management'))
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>{{ __('Total Order') }}</h4>
                                </div>
                                <div class="card-body">
                                    {{ $data['total_orders'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>{{ __('Pending Order') }}</h4>
                                </div>
                                <div class="card-body">
                                    {{ $data['total_pending_orders'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>{{ __('Total Courses') }}</h4>
                                </div>
                                <div class="card-body">
                                    {{ $data['total_course'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>{{ __('Pending Courses') }}</h4>
                                </div>
                                <div class="card-body">
                                    {{ $data['total_pending_course'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>{{ __('Total Earnings') }}</h4>
                                </div>
                                <div class="card-body">
                                    {{ currency($data['total_earning']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>{{ __('This Years Earnings') }}</h4>
                                </div>
                                <div class="card-body">
                                    {{ currency($data['this_years_earning']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>{{ __('This Month Earnings') }}</h4>
                                </div>
                                <div class="card-body">
                                    {{ currency($data['this_months_earning']) }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>{{ __('Todays Earnings') }}</h4>
                                </div>
                                <div class="card-body">
                                    {{ currency($data['todays_earning']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <!-- Area Chart -->
                    <div class="col">
                        <div class="mb-4 shadow card">
                            <!-- Card Header - Dropdown -->
                            <div class="flex-row py-3 card-header d-flex align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary"> {{ __('Sales In') }}
                                    {{ request()->has('year') && request()->has('month')
                                        ? Carbon\Carbon::createFromFormat('Y-m', request('year') . '-' . request('month'))->format('F, Y')
                                        : date('F, Y') }}
                                </h6>
                                <div class="form-inline">
                                    <form method="get" onchange="$(this).trigger('submit');">
                                        <select name="year" id="year" class="form-control">
                                            @php
                                                $currentYear = Carbon\Carbon::now()->year;
                                                $currentMonth = Carbon\Carbon::now()->month;
                                                $selectYear = request('year') ?? $currentYear;
                                                $selectMonth = request('month') ?? $currentMonth;
                                            @endphp
                                            @for ($i = $data['oldestYear']; $i <= $data['latestYear']; $i++)
                                                <option value="{{ $i }}" @selected($selectYear == $i)>
                                                    {{ $i }}</option>
                                            @endfor
                                        </select>
                                        <select name="month" id="month" class="form-control">
                                            @php
                                                for ($month = 1; $month <= 12; $month++) {
                                                    $monthNumber = str_pad($month, 2, '0', STR_PAD_LEFT);
                                                    $monthName = Carbon\Carbon::createFromFormat('m', $month)->format('M');
                                                    echo '<option value="' .
                                                        $monthNumber .
                                                        '" ' .
                                                        ($selectMonth == $monthNumber ? ' selected' : '') .
                                                        '>' .
                                                        $monthName .
                                                        '</option>';
                                                }
                                            @endphp </select>
                                    </form>
                                </div>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body">
                                <div class="chart-area">
                                    <canvas id="myAreaChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <div class="row mt-2">
                    @if(checkAdminHasPermission('course.management'))
                    <div class="col-md-6 col-lg-4">
                        <div class="card card-hero">
                            <div class="card-header">
                                <div class="card-icon">
                                    <i class="fas fa-graduation-cap"></i>
                                </div>
                                <h5>{{ __('Recent Courses') }}</h5>
                                <div class="card-description">({{ $data['pending_courses'] }})
                                    {{ __('Courses are pending') }}</div>
                            </div>
                            <div class="card-body p-0">
                                <div class="tickets-list">
                                    @foreach ($data['recent_courses'] as $course)
                                        <a href="{{ route('admin.courses.edit-view', $course->id) }}"
                                            class="ticket-item">
                                            <div class="ticket-title">
                                                <h4>{{ truncate($course->title, 50) }}</h4>
                                            </div>
                                            <div class="ticket-info">
                                                <div>{{ $course->instructor->name }}</div>
                                                <div class="bullet"></div>
                                                <div>{{ $course->is_approved }}</div>
                                                <div class="bullet"></div>
                                                <div class="text-primary">{{ $course->created_at->diffForHumans() }}</div>
                                            </div>
                                        </a>
                                    @endforeach
                                    <a href="{{ route('admin.courses.index') }}" class="ticket-item ticket-more">
                                        {{ __('View All') }} <i class="fas fa-chevron-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if(checkAdminHasPermission('blog.view'))
                    <div class="col-md-6 col-lg-4">
                        <div class="card card-hero">
                            <div class="card-header">
                                <div class="card-icon">
                                    <i class="fas fa-blog"></i>
                                </div>
                                <h5>{{ __('Recent Blogs') }}</h5>
                                <div class="card-description">({{ $data['pending_blogs'] }})
                                    {{ __('Blogs are pending') }}</div>
                            </div>
                            <div class="card-body p-0">
                                <div class="tickets-list">
                                    @foreach ($data['recent_blogs'] as $blog)
                                        <a href="{{ route('admin.blogs.edit', ['blog' => $blog, 'code' => getSessionLanguage()]) }}"
                                            class="ticket-item">
                                            <div class="ticket-title">
                                                <h4>{{ truncate($blog->translation->title, 50) }}</h4>
                                            </div>
                                            <div class="ticket-info">
                                                <div>{{ $blog->author->name }}</div>
                                                <div class="bullet"></div>
                                                <div>{{ $blog->status == 1 ? __('Approved') : __('Pending') }}</div>
                                                <div class="bullet"></div>
                                                <div class="text-primary">{{ $blog->created_at->diffForHumans() }}</div>
                                            </div>
                                        </a>
                                    @endforeach
                                    <a href="{{ route('admin.blogs.index') }}" class="ticket-item ticket-more">
                                        {{ __('View All') }} <i class="fas fa-chevron-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if(checkAdminHasPermission('contect.message.view'))
                    <div class="col-md-6 col-lg-4">
                        <div class="card card-hero">
                            <div class="card-header">
                                <div class="card-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <h5>{{ __('Recent Contacts') }}</h5>
                                <div class="card-description">{{ __('Here is your recent contacts messages') }}</div>
                            </div>
                            <div class="card-body p-0">
                                <div class="tickets-list">
                                    @foreach ($data['recent_contacts'] as $contact)
                                        <a href="{{ route('admin.contact-message', $contact->id) }}"
                                            class="ticket-item">
                                            <div class="ticket-title">
                                                <h4>{{ truncate($contact->subject, 50) }}</h4>
                                            </div>
                                            <div class="ticket-info">
                                                <div>{{ $contact->name }}</div>
                                                <div class="bullet"></div>
                                                <div>{{ $contact->email }}</div>
                                                <div class="bullet"></div>
                                                <div class="text-primary">{{ $contact->created_at->diffForHumans() }}
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                    <a href="{{ route('admin.contact-messages') }}" class="ticket-item ticket-more">
                                        {{ __('View All') }} <i class="fas fa-chevron-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection

@push('js')
    <script src="{{ asset('backend/js/chart.umd.min.js') }}"></script>

    <script>
        (function($) {

            "use strict";

            // Area Chart Example
            $(document).ready(function() {

                var bData = @json($data['monthly_data']);
                var jData = JSON.parse(bData);

                var ctx = document.getElementById("myAreaChart");
                var myLineChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13",
                            "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25",
                            "26", "27", "28", "29", "30", "31"
                        ],
                        datasets: [{
                            label: "{{ __('Sales') }}",
                            lineTension: 0.3,
                            backgroundColor: "rgba(78, 115, 223, 0.05)",
                            borderColor: "rgba(78, 115, 223, 1)",
                            pointRadius: 3,
                            pointBackgroundColor: "rgba(78, 115, 223, 1)",
                            pointBorderColor: "rgba(78, 115, 223, 1)",
                            pointHoverRadius: 3,
                            pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                            pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                            pointHitRadius: 10,
                            pointBorderWidth: 2,
                            data: jData,
                        }],
                    },
                    options: {
                        maintainAspectRatio: false,
                        layout: {
                            padding: {
                                left: 10,
                                right: 25,
                                top: 25,
                                bottom: 0
                            }
                        },
                        scales: {
                            xAxes: [{
                                time: {
                                    unit: 'date'
                                },
                                gridLines: {
                                    display: false,
                                    drawBorder: false
                                },
                                ticks: {
                                    maxTicksLimit: 7
                                }
                            }],
                            yAxes: [{
                                ticks: {
                                    maxTicksLimit: 5,
                                    padding: 10,
                                    // Include a dollar sign in the ticks
                                    callback: function(value, index, values) {
                                        return '{{ session()->get('currency_icon') }}' +
                                            number_format(value);
                                    }
                                },
                                gridLines: {
                                    color: "rgb(234, 236, 244)",
                                    zeroLineColor: "rgb(234, 236, 244)",
                                    drawBorder: false,
                                    borderDash: [2],
                                    zeroLineBorderDash: [2]
                                }
                            }],
                        },
                        legend: {
                            display: false
                        },
                        tooltips: {
                            backgroundColor: "rgb(255,255,255)",
                            bodyFontColor: "#858796",
                            titleMarginBottom: 10,
                            titleFontColor: '#6e707e',
                            titleFontSize: 14,
                            borderColor: '#dddfeb',
                            borderWidth: 1,
                            xPadding: 15,
                            yPadding: 15,
                            displayColors: false,
                            intersect: false,
                            mode: 'index',
                            caretPadding: 10,
                            callbacks: {
                                label: function(tooltipItem, chart) {
                                    var datasetLabel = chart.datasets[tooltipItem.datasetIndex]
                                        .label || '';
                                    return datasetLabel +
                                        ': {{ session()->get('currency_icon') }}' +
                                        number_format(tooltipItem.yLabel);
                                }
                            }
                        }
                    }
                });
            });
        })(jQuery);
    </script>

    <script>
        $(document).ready(function() {
            "use strict";
            var alertKey = 'missingCrentialsAlert';
            var dismissedTimestamp = localStorage.getItem(alertKey);

            if (!dismissedTimestamp || Date.now() - dismissedTimestamp > 24 * 60 * 60 * 1000) {
                $('#missingCrentialsAlert').removeClass('d-none');
                $('#missingCrentialsAlert').show();
            } else {
                $('#missingCrentialsAlert').hide();
            }

            $('#missingCrentialsAlertClose').on('click', function() {
                $('#missingCrentialsAlert').hide();
                localStorage.setItem(alertKey, Date.now());
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            "use strict";
            var alertKey = 'updateAvailablityAlert';
            var dismissedTimestamp = localStorage.getItem(alertKey);

            if (!dismissedTimestamp || Date.now() - dismissedTimestamp > 24 * 60 * 60 * 1000) {
                $('#updateAvailablityAlert').removeClass('d-none');
                $('#updateAvailablityAlert').show();
            } else {
                $('#updateAvailablityAlert').hide();
            }

            $('#updateAvailablityAlertClose').on('click', function() {
                $('#updateAvailablityAlert').hide();
                localStorage.setItem(alertKey, Date.now());
            });
        });
    </script>
@endpush
