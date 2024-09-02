@extends('layouts.main')
@section('title', 'Jurnal Absensi')

@section('container')
    <div class="pagetitle">
        <h1>Jurnal Absensi</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('student.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">Journal</li>
                <li class="breadcrumb-item active">Recap</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Jurnal Anda Saat ini</h5>

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
                                        <th scope="col">Tanggal Absensi</th>
                                        <th scope="col">Waktu Absen Masuk</th>
                                        <th scope="col">Waktu Absen Keluar</th>
                                        <th scope="col">Jurnal</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($attendances as $attendance)
                                      @php
                                          $journal = $journals->firstWhere('attendance_id', $attendance->id);
                                      @endphp
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $attendance->absence_date }}</td>
                                            <td>{{ $attendance->attendance_in }}</td>
                                            <td>{{ $attendance->attendance_out }}</td>
                                            <td>
                                                @if ($journal)
                                                    <div class="journal-content">
                                                        <span class="short-content">{{ Str::limit($journal->journal_content, 20) }}</span>
                                                        <span class="full-content" style="display: none;">{{ $journal->journal_content }}</span>
                                                        <a href="javascript:void(0);" class="read-more">Read More</a>
                                                    </div>
                                                @else
                                                    No journal content.
                                                    @if ($attendance->attendance_in && $attendance->attendance_out)
                                                        <a href="{{ route('student.journal.create', ['date' => $attendance->absence_date]) }}" class="btn btn-primary btn-sm">Create Journal</a>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                              @if ($journal)
                                                  <a href="{{ route('student.journal.edit', $journal->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                  <form action="{{ route('student.journal.destroy', $journal->id) }}" method="POST" style="display:inline;">
                                                      @csrf
                                                      @method('DELETE')
                                                      <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                  </form>
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


    <script>
      document.addEventListener('DOMContentLoaded', function () {
          document.querySelectorAll('.read-more').forEach(function (element) {
              element.addEventListener('click', function () {
                  var shortContent = this.previousElementSibling.previousElementSibling;
                  var fullContent = this.previousElementSibling;
                  if (fullContent.style.display === 'none') {
                      fullContent.style.display = 'inline';
                      shortContent.style.display = 'none';
                      this.textContent = 'Read Less';
                  } else {
                      fullContent.style.display = 'none';
                      shortContent.style.display = 'inline';
                      this.textContent = 'Read More';
                  }
              });
          });
      });
    </script>
@endsection