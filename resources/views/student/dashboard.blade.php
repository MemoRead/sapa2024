@extends('layouts.main')
@section('title', 'Dashboard Student')

@section('container')
<div class="pagetitle">
  <h1>Dashboard</h1>
  <nav>
      <ol class="breadcrumb">
          <li class="breadcrumb-item active"><a href="{{ route('student.dashboard') }}">Home</a></li>
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

    {{-- Left Side --}}
    <div class="col-lg-8">
      <div class="row">

        <!-- Revenue Card -->
        <div class="col-xxl-6 col-xl-12">
          <div class="card info-card revenue-card">

              <div class="card-body">
                  <h5 class="card-title">Kehadiran <span>| Records</span></h5>

                  <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                          <i class="bi bi-journal-bookmark"></i>
                      </div>
                      <div class="ps-3">
                          <h6>{{ $totalAttendanceCount }}</h6>
                          <span class="text-muted small pt-2 ps-1">Records</span>

                      </div>
                  </div>
              </div>

          </div>
        </div><!-- End Revenue Card -->

        <!-- Revenue Card -->
        <div class="col-xxl-6 col-xl-12">
          <div class="card info-card revenue-card">

              <div class="card-body">
                  <h5 class="card-title">Jurnal <span>| Records</span></h5>

                  <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                          <i class="bi bi-journal-bookmark"></i>
                      </div>
                      <div class="ps-3">
                          <h6>{{ $totalJournalCount }}</h6>
                          <span class="text-muted small pt-2 ps-1">Records</span>

                      </div>
                  </div>

              </div>
          </div>

        </div><!-- End Revenue Card -->

        <!-- Reports -->
        <div class="col-12">
          <div class="card">

            <div class="card-body">
              <h5 class="card-title">Kalender Kehadiran <span>/Bulan ini</span></h5>
              
              <div class="calendar-container">
                  @for ($day = 1; $day <= 31; $day++)
                      @php
                          $date = now()->format('Y-m') . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);
                          $attendance = $attendances->firstWhere('absence_date', $date);
                          $journal = $journals->firstWhere('attendance_id', $attendance->id ?? null);
                          $boxClass = 'no-attendance';
                          if ($attendance) {
                              $boxClass = $journal ? 'journal-filled' : 'attendance-only';
                          }
                      @endphp
                      <div class="day-box {{ $boxClass }}">
                          {{ $day }}
                      </div>
                  @endfor
              </div>
                
              <style>
                .calendar-container {
                    display: flex;
                    flex-wrap: wrap;
                    justify-content: center;
                }
                .day-box {
                    width: 50px;
                    height: 50px;
                    line-height: 50px;
                    text-align: center;
                    margin: 5px;
                    border: 1px solid #ccc;
                    display: inline-block;
                }
                .no-attendance {
                    background-color: #f8d7da;
                }
                .attendance-only {
                    background-color: #fff3cd;
                }
                .journal-filled {
                    background-color: #d4edda;
                }
                
                @media (max-width: 600px) {
                    .calendar-container {
                        flex-wrap: wrap;
                    }
                    .day-box {
                        width: 45px;
                        height: 45px;
                        line-height: 45px;
                    }
                }
              </style>

            </div>

          </div>
        </div><!-- End Reports -->


      </div>
    </div>
    {{-- End Left Side --}}

    {{-- Right Side --}}
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
    {{-- End Right Side --}}

  </div>
</section>

@endsection