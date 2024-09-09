@extends('layouts.main')
@section('title', 'Admin Dashboard - Report')

@section('container')
<div class="pagetitle">
    <h1>Laporan AJournal</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Reports</li>
            <li class="breadcrumb-item active">Jurnal</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Jurnal Siswa</h5>

                    <!-- Table with stripped rows -->
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Tanggal Absensi</th>
                                    <th scope="col">Jurnal</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($journalReports as $attendance)
                                @php
                                    $journal = $journals->firstWhere('attendance_id', $attendance->id);
                                @endphp
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $attendance->student->name }}</td>
                                    <td>{{ $attendance->created_at->format('d M Y') }}</td>
                                    <td>
                                        @if ($journal)
                                            <div class="journal-content">
                                                <span class="short-content">{{ Str::limit($journal->journal_content, 20) }}</span>
                                                <span class="full-content" style="display: none;">{{ $journal->journal_content }}</span>
                                                <a href="javascript:void(0);" class="read-more">Read More</a>
                                            </div>
                                        @else
                                            Tidak ada jurnal
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {{ $journalReports->links('pagination::bootstrap-5') }}
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