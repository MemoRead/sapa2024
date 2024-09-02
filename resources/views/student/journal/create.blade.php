@extends('layouts.main')
@section('title', 'Jurnal Buat')

@section('container')
<div class="pagetitle">
  <h1>Tambahkan Jurnal</h1>
  <nav>
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('student.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item">Journal</li>
          <li class="breadcrumb-item active">Add</li>
      </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          
          <div class="container">
          
            <form action="{{ route('student.journal.store') }}" method="POST">
                @csrf
                <input type="hidden" name="attendance_id" value="{{ $attendance->id }}">
          
                <div class="mb-3">
                    <label for="journal_content" class="col-sm-2 col-form-label">Journal Content</label>
                    <textarea class="form-control" id="journal_content" name="journal_content" rows="10" required></textarea>
                </div>
          
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
          </div>
        
        </div>
      </div>

    </div>
  </div>
</section>
@endsection