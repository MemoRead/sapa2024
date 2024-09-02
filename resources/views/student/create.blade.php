@extends('layouts.main')
@section('title', 'Add Student')

@section('container')
<div class="pagetitle">
    <h1>Student</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Users</li>
            <li class="breadcrumb-item">Student</li>
            <li class="breadcrumb-item active">Add</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Add Student</h5>

                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#uploadModalStudent">Upload Users Data</button>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Table with stripped rows -->
                    <div class="table-responsive">
                        <form action="{{ route('admin.student.store') }}" method="post">
                        @csrf
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">class</th>
                                    <th scope="col">Skill</th>
                                    <th scope="col">Group</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="userTable">

                                    @for($i = 0; $i < 1; $i++)
                                    <tr>
                                        <td>
                                            <input
                                                type="text"
                                                name="students[{{ $i }}][name]"
                                                class="form-control @error('students.' . $i . '.name') is-invalid @enderror"
                                                value="{{ old('students.' . $i . '.name') }}"
                                                required>
                                            @error("students[{{ $i }}][name]")
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </td>
                                        <td>
                                            <input type="text" name="students[{{ $i }}][class]" class="form-control @error('students.' . $i . '.class') is-invalid @enderror" value="{{ old('students.' . $i . '.class') }}" required>
                                            @error("students[{{ $i }}][class]")
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                          </td>
                                          <td>
                                              <select name="students[{{ $i }}][skill_id]" class="form-control @error('students.' . $i . '.skill_id') is-invalid @enderror" required>
                                                  <option value="">Select Skill</option>
                                                  @foreach ($skills as $skill)
                                                      <option value="{{ $skill->id }}">{{ $skill->name }}</option>
                                                  @endforeach
                                              </select>
                                              @error("students[{{ $i }}][skill_id]")
                                                  <div class="invalid-feedback">
                                                      {{ $message }}
                                                  </div>
                                              @enderror
                                          </td>
                                        <td>
                                            <input type="text" name="students[{{ $i }}][group]" class="form-control @error('students.' . $i . '.group') is-invalid @enderror" value="{{ old('students.' . $i . '.group') }}" required>
                                            @error("students[{{ $i }}][group]")
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </td>



                                        <td><button type="button" class="btn btn-danger removeRow">Remove</button></td>
                                    </tr>
                                    @endfor


                            </tbody>
                        </table>
                        <button type="button" id="addRow" class="btn btn-primary">Add Row</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                        </form>
                    </div>
                    <!-- End Table with stripped rows -->

                </div>
            </div>

        </div>
    </div>
</section>

@include('partials.modal')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let index = 0;
        const table = document.querySelector('table tbody');
        const addRowButton = document.querySelector('#addRow');

        addRowButton.addEventListener('click', function() {
            index++;

            const newRow = `
                <tr>
                    <td>
                        <input type="text" name="students[${index}][name]" class="form-control" value="" required>
                    </td>
                    <td>
                        <input type="text" name="students[${index}][class]" class="form-control" value="" required>
                    </td>
                    <td>
                        <select name="students[${index}][skill_id]" class="form-control" required>
                            <option value="">Select Skill</option>
                            @foreach ($skills as $skill)
                                <option value="{{ $skill->id }}">{{ $skill->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="text" name="students[${index}][group]" class="form-control" required>
                    </td>

                    <td><button type="button" class="btn btn-danger removeRow">Remove</button></td>
                </tr>
            `;

            table.insertAdjacentHTML('beforeend', newRow);
        });
    });


    document.addEventListener('DOMContentLoaded', function() {
        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('removeRow')) {
                e.target.closest('tr').remove();
                // Update numbering after removal
                let rows = document.querySelectorAll('#userTable tr');
                rows.forEach((row, index) => {
                    row.querySelector('th').textContent = index + 1;
                    let inputs = row.querySelectorAll('input, select');
                    inputs.forEach(input => {
                        let name = input.getAttribute('name').replace(/\[\d+\]/, `[${index}]`);
                        input.setAttribute('name', name);
                    });
                });
            }
        });
    });
</script>

@endsection