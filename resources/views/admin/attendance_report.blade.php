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

          <!-- Revenue Cards for Each Skill -->
          @foreach($attendanceData as $skill => $count)
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
                <h5 class="card-title">Absensi Berhasil <span>| {{ $skill }}</span></h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-person-check"></i>
                  </div>
                  <div class="ps-3">
                    <h6>{{ $count }}</h6>
                    <!-- Adjust the number of students dynamically if needed -->
                    <span class="text-success small pt-1 fw-bold">Dari {{ $totalStudentsBySkill[$skill] ?? 'N/A' }}</span> <span class="text-muted small pt-2 ps-1">Siswa</span>
                  </div>
                </div>
              </div>
            </div>
          </div><!-- End Revenue Card -->
          @endforeach

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
        
        <!-- Table for Students Not Attended -->
        <div class="card">
          <div class="card-body">
              <h5 class="card-title mb-0">Siswa Belum Melakukan Absensi Hari ini {{ $currentDate }}</h5>
              <div id="students-not-attended-container">
                  @include('admin.partials.students_not_attended_table', ['students' => $studentsNotAttended])
              </div>
          </div>
        </div>

        <!-- Table for Attendance History -->
        <div class="card">
          <div class="card-body">
              <h5 class="card-title">Riwayat Absensi Siswa</h5>
              <div id="attendance-history-container">
                  @include('admin.partials.attendance_history_table', ['attendanceReports' => $attendanceReports])
              </div>
          </div>
        </div>

      </div>
  </div>
</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
  $(document).on('click', '#attendanceHistoryTable .pagination a', function (e) {
      e.preventDefault();
      var url = $(this).attr('href');
      $.get(url, function (data) {
          $('#attendance-history-container').html($(data).find('#attendance-history-container').html());
          // Update the URL in the browser address bar
          window.history.pushState({}, '', url);
      });
  });

  $(document).on('click', '#studentsNotAttendedTable .pagination a', function (e) {
      e.preventDefault();
      var url = $(this).attr('href');
      $.get(url, function (data) {
          $('#students-not-attended-container').html($(data).find('#students-not-attended-container').html());
          // Update the URL in the browser address bar
          window.history.pushState({}, '', url);
      });
  });
</script>
@endsection