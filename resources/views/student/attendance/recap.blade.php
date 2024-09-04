@extends('layouts.main')
@section('title', 'Recap Absensi')

@section('container')
    <div class="pagetitle">
        <h1>Absensi Rekap</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('student.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">Attendant</li>
                <li class="breadcrumb-item active">Recap</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Riwayat Absensi Anda Saat ini</h5>

                        @if (session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle me-1"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Table with stripped rows -->
                        <div class="table-responsive">
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Berangkat</th>
                                        <th scope="col">Pulang</th>
                                        <th scope="col">Location</th>
                                        <th scope="col">Jenis Absensi</th>
                                        <th scope="col">Kehadiran</th>
                                        <th scope="col">Bukti Kehadiran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($attendances as $attendance)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $attendance->student->name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($attendance->absence_date)->format('F j, Y') }}</td>
                                            <td>{{ $attendance->attendance_in}}</td>
                                            <td>{{ $attendance->attendance_out}}</td>
                                            <td>{{ $attendance->absence_location }}</td>
                                            <td>{{ $attendance->absence_type }}</td>
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