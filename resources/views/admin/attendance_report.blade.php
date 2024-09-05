@extends('layouts.main')
@section('title', 'Admin Dashboard - Report')

@section('container')
<div class="pagetitle">
    <h1>Laporan Absensi</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Reports</li>
            <li class="breadcrumb-item active">Absensi</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
  <div class="row">
      <div class="col-lg-12">
        <div class="row">
          <!-- Revenue Card -->
          <div class="col-xxl-3 col-md-6">
            <div class="card info-card revenue-card">

              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>Filter</h6>
                  </li>

                  <li><a class="dropdown-item" href="#">Today</a></li>
                </ul>
              </div>

              <div class="card-body">
                <h5 class="card-title">Absensi Berhasil <span>| Multimedia</span></h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-person-check"></i>
                  </div>
                  <div class="ps-3">
                    <h6>{{ $attendanceData['multimedia'] }}</h6>
                    <span class="text-success small pt-1 fw-bold">Dari 44</span> <span class="text-muted small pt-2 ps-1">Siswa</span>

                  </div>
                </div>
              </div>
            </div>
          </div><!-- End Revenue Card -->
          <!-- Revenue Card -->
          <div class="col-xxl-3 col-md-6">
            <div class="card info-card revenue-card">

              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>Filter</h6>
                  </li>

                  <li><a class="dropdown-item" href="#">Today</a></li>
                </ul>
              </div>

              <div class="card-body">
                <h5 class="card-title">Absensi Berhasil <span>| Tata Busana</span></h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-person-check"></i>
                  </div>
                  <div class="ps-3">
                    <h6>{{ $attendanceData['tataBusana'] }}</h6>
                    <span class="text-success small pt-1 fw-bold">Dari 26</span> <span class="text-muted small pt-2 ps-1">Siswa</span>

                  </div>
                </div>
              </div>
            </div>
          </div><!-- End Revenue Card -->
          <!-- Revenue Card -->
          <div class="col-xxl-3 col-md-6">
            <div class="card info-card revenue-card">

              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>Filter</h6>
                  </li>

                  <li><a class="dropdown-item" href="#">Today</a></li>
                </ul>
              </div>

              <div class="card-body">
                <h5 class="card-title">Absensi Berhasil <span>| Pengelasan</span></h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-person-check"></i>
                  </div>
                  <div class="ps-3">
                    <h6>{{ $attendanceData['pengelasan'] }}</h6>
                    <span class="text-success small pt-1 fw-bold">Dari 7</span> <span class="text-muted small pt-2 ps-1">Siswa</span>

                  </div>
                </div>
              </div>
            </div>
          </div><!-- End Revenue Card -->
          <!-- Customers Card -->
          <div class="col-xxl-3 col-md-6">

            <div class="card info-card customers-card">

              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>Filter</h6>
                  </li>

                  <li><a class="dropdown-item" href="#">Today</a></li>
                </ul>
              </div>

              <div class="card-body">
                <h5 class="card-title">Total Absensi <span>| Hari ini</span></h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-people"></i>
                  </div>
                  <div class="ps-3">
                    <h6>{{ $totalAttendance }}</h6>
                    <span class="text-danger small pt-1 fw-bold">Dari 77</span> <span class="text-muted small pt-2 ps-1">Siswa</span>

                  </div>
                </div>

              </div>
            </div>

          </div><!-- End Customers Card -->

        </div>
        <div class="card">
          <div class="card-body">
              <h5 class="card-title mb-0">Siswa Belum Melakukan Absensi Hari ini {{ $currentDate }}</h5>

              <!-- Table with stripped rows -->
              <div class="table-responsive">
                  <table class="table datatable">
                      <thead>
                          <tr>
                              <th scope="col">No</th>
                              <th scope="col">Name</th>
                              <th scope="col">Keterampilan</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($studentsNotAttended as $student)
                              <tr>
                                  <th scope="row">{{ $loop->iteration }}</th>
                                  <td>{{ $student->name }}</td>
                                  <td>{{ $student->skill->name }}</td>
                              </tr>
                          @endforeach
                      </tbody>
                  </table>
              </div>
              <!-- End Table with stripped rows -->

          </div>
      </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Riwayat Absensi Siswa</h5>


                <!-- Table with stripped rows -->
                <div class="table-responsive">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Name</th>
                                <th scope="col">Keterampilan</th>
                                <th scope="col">Date</th>
                                <th scope="col">Berangkat</th>
                                <th scope="col">Pulang</th>
                                <th scope="col">Location</th>
                                <th scope="col">Kehadiran</th>
                                <th scope="col">Bukti Kehadiran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attendanceReports as $attendance)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $attendance->student->name }}</td>
                                    <td>{{ $attendance->student->skill->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($attendance->absence_date)->format('F j, Y') }}</td>
                                    <td>{{ $attendance->attendance_in}}</td>
                                    <td>{{ $attendance->attendance_out}}</td>
                                    <td>{{ $attendance->absence_location }}</td>
                                    <td>{{ $attendance->attendance }}</td>
                                    <td>
                                    @if ($attendance->proof_of_attendance)
                                        <img src="{{ $attendance->proof_of_attendance }}" alt="Proof of Attendance" style="max-width: 100px; max-height: 100px;">
                                    @else
                                        No proof provided
                                    @endif
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- End Table with stripped rows -->

            </div>
        </div>

      </div>
  </div>
</section>

@endsection