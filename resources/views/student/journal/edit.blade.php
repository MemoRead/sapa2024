@extends('layouts.main')
@section('title', 'Jurnal Edit')

@section('container')
<div class="pagetitle">
  <h1>Edit Jurnal</h1>
  <nav>
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('student.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item">Journal</li>
          <li class="breadcrumb-item active">Edit</li>
      </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          
          <div class="container">
          
            <form action="{{ route('student.journal.update', $journal->id) }}" method="POST">
                @csrf
                @method('PUT')
          
                <div class="mb-3">
                    <label for="journal_content" class="col-sm-2 col-form-label">Journal Content</label>
                    <textarea class="form-control" id="journal_content" name="journal_content" rows="10" required>{{ old('journal_content', $journal->journal_content) }}</textarea>
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