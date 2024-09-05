@extends('layouts.main')
@section('title', 'Admin Dashboard')

@section('container')
<div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Home</a></li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card info-card sales-card text-center">
                <div class="card-body ">
                    <h5 class="card-title">Welcome <span>| {{ auth()->user()->name }}</span></h5>
                    <div>
                        <form class="d-flex align-items-center justify-content-center" action="{{ route('logout') }}" method="post">
                            @csrf
                            <button class="btn btn-warning small pt-1 fw-bold text-white" type="submit">
                                <i class="bi box-arrow-right text-white"></i> Logout
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">
            <div class="row">

                <!-- Sales Card -->
                <div class="col-xxl-3 col-md-3">
                    <div class="card info-card sales-card">

                        <div class="card-body">
                            <h5 class="card-title">Users <span>| Teacher</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $teachersCount }}</h6>
                                    <span class="text-success small pt-1 fw-bold">People</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Sales Card -->

                <!-- Sales Card -->
                <div class="col-xxl-3 col-md-3">
                    <div class="card info-card sales-card">

                        <div class="card-body">
                            <h5 class="card-title">Users <span>| Students</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-person"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $studentsCount }}</h6>
                                    <span class="text-success small pt-1 fw-bold">People</span>

                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Sales Card -->

                <!-- Revenue Card -->
                <div class="col-xxl-3 col-md-3">
                    <div class="card info-card revenue-card">

                        <div class="card-body">
                            <h5 class="card-title">Attendant <span>| Records</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-journal-bookmark"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $attendantRecordsCount }}</h6>
                                    <span class="text-muted small pt-2 ps-1">Records</span>

                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Revenue Card -->

                <!-- Revenue Card -->
                <div class="col-xxl-3 col-md-3">
                    <div class="card info-card revenue-card">

                        <div class="card-body">
                            <h5 class="card-title">Journal <span>| Records</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-journal-bookmark"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $journalRecordsCount }}</h6>
                                    <span class="text-muted small pt-2 ps-1">Records</span>

                                </div>
                            </div>

                        </div>
                    </div>

                </div><!-- End Revenue Card -->

            </div>
        </div>

        <!-- Reports -->
        <div class="col-lg-8">
            <div class="card">

                <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                        <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#" onclick="updateChart('hour')">Today</a></li>
                    <li><a class="dropdown-item" href="#" onclick="updateChart('week')">This Week</a></li>
                    <li><a class="dropdown-item" href="#" onclick="updateChart('month')">This Month</a></li>
                    </ul>
                </div>

                <div class="card-body">
                    <h5 class="card-title">Reports <span id="interval-title">/Today</span></h5>

                    <!-- Line Chart -->
                    <div id="reportsChart"></div>

                    <script>
                    document.addEventListener("DOMContentLoaded", () => {

                        const attendanceData = @json($attendanceData);

                        const categories = Object.keys(attendanceData.multimedia); // Assuming all skills have the same dates
                        const multimediaData = Object.values(attendanceData.multimedia);
                        const tataBusanaData = Object.values(attendanceData.tataBusana);
                        const pengelasanData = Object.values(attendanceData.pengelasan);

                        const chart = new ApexCharts(document.querySelector("#reportsChart"), {
                            series: [{
                                name: 'Multimedia',
                                data: multimediaData
                            }, {
                                name: 'Tata Busana',
                                data: tataBusanaData
                            }, {
                                name: 'Pengelasan',
                                data: pengelasanData
                            }],
                            chart: {
                                height: 350,
                                type: 'line',
                                toolbar: {
                                    show: false
                                },
                            },
                            xaxis: {
                                categories: categories,
                                title: {
                                    text: 'Date'
                                }
                            },
                            yaxis: {
                                title: {
                                    text: 'Percentage (%)'
                                },
                                labels: {
                                    formatter: function (val) {
                                        return val.toFixed(2) + "%";
                                    }
                                }
                            },
                            markers: {
                                size: 4
                            },
                            colors: ['#4154f1', '#2eca6a', '#ff771d'],
                            fill: {
                                type: "gradient",
                                gradient: {
                                shadeIntensity: 1,
                                opacityFrom: 0.3,
                                opacityTo: 0.4,
                                stops: [0, 90, 100]
                                }
                            },
                            dataLabels: {
                                enabled: false
                            },
                            stroke: {
                                curve: 'smooth',
                                width: 2
                            },
                            tooltip: {
                                y: {
                                    formatter: function (val) {
                                        return val.toFixed(2) + "%";
                                    }
                                }
                            }
                        })

                        chart.render();

                        window.updateChart = function(interval) {
                            // Update the interval title
                            document.getElementById('interval-title').innerText = '/' + interval.charAt(0).toUpperCase() + interval.slice(1);

                            // Fetch new data based on the interval
                            fetch(`/api/attendance-data?interval=${interval}`)
                                .then(response => response.json())
                                .then(data => {
                                    const categories = Object.keys(data.multimedia);
                                    const multimediaData = Object.values(data.multimedia);
                                    const tataBusanaData = Object.values(data.tataBusana);
                                    const pengelasanData = Object.values(data.pengelasan);

                                    chart.updateOptions({
                                        xaxis: {
                                            categories: categories,
                                            title: {
                                                text: interval.charAt(0).toUpperCase() + interval.slice(1)
                                            }
                                        },
                                        series: [{
                                            name: 'Multimedia',
                                            data: multimediaData
                                        }, {
                                            name: 'Tata Busana',
                                            data: tataBusanaData
                                        }, {
                                            name: 'Pengelasan',
                                            data: pengelasanData
                                        }]
                                    });
                                });
                        }
                    });
                    </script>
                    <!-- End Line Chart -->

                </div>

            </div>
        </div><!-- End Reports -->

        <div class="col-lg-4">

            <!-- Recent Activity -->
            <div class="card">
                <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                        <h6>Filter</h6>
                    </li>
        
                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    </ul>
                </div>
        
                <div class="card-body">
                    <h5 class="card-title">Recent Activity <span>| Today</span></h5>
        
                    <div class="activity">
        
                    @foreach ($recentActivities as $activity)
                        <div class="activity-item d-flex">
                        <div class="activite-label">{{ $activity->created_at->diffForHumans() }}</div>
                        <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                        <div class="activity-content">
                            {{ $activity->description }}
                        </div>
                        </div><!-- End activity item-->
                    @endforeach
        
                    </div>
        
                </div>
            </div><!-- End Recent Activity -->
        </div> 

    </div>
</section>

@endsection