@extends('layouts.main')
@section('title', 'Add User')

@section('container')
<div class="pagetitle">
    <h1>Users</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Users</li>
            <li class="breadcrumb-item">User</li>
            <li class="breadcrumb-item active">Add</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Users Add</h5>

                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#uploadModal">Upload Users Data</button>

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
                        <form action="{{ route('admin.users.store') }}" method="post">
                        @csrf
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">password</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Teacher ID</th>
                                    <th scope="col">Student ID</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="userTable">

                                    @for($i = 0; $i < 1; $i++)
                                    <tr>
                                        <td>
                                            <input
                                                type="text"
                                                name="users[{{ $i }}][name]"
                                                class="form-control @error('users.' . $i . '.name') is-invalid @enderror"
                                                value="{{ old('users.' . $i . '.name') }}"
                                                required>
                                            @error("users[{{ $i }}][name]")
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </td>
                                        <td>
                                            <input type="text" name="users[{{ $i }}][username]" class="form-control @error('users.' . $i . '.username') is-invalid @enderror" value="{{ old('users.' . $i . '.username') }}" required>
                                            @error("users[{{ $i }}][username]")
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </td>
                                        <td>
                                            <input type="text" name="users[{{ $i }}][password]" class="form-control @error('users.' . $i . '.password') is-invalid @enderror" value="{{ old('users.' . $i . '.password') }}" required>
                                            @error("users[{{ $i }}][password]")
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </td>
                                        <td>
                                            <select name="users[{{ $i }}][role]" class="form-control @error('users.' . $i . '.role') is-invalid @enderror" required>
                                                <option value="">Select Role</option>
                                                <option value="admin">Admin</option>
                                                <option value="teacher">Guru</option>
                                                <option value="student">Siswa</option>
                                            </select>
                                            @error("users[{{ $i }}][role]")
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </td>
                                        <td>
                                            <select name="users[{{ $i }}][teacher_id]" class="form-control @error('users.' . $i . '.teacher_id') is-invalid @enderror">
                                                <option value="">Select Teacher</option>
                                                @foreach ($teachers as $teacher)
                                                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                                @endforeach
                                            </select>
                                            @error("users[{{ $i }}][teacher_id]")
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </td>
                                        <td>
                                            <select name="users[{{ $i }}][student_id]" class="form-control @error('users.' . $i . '.student_id') is-invalid @enderror">
                                                <option value="">Select Student</option>
                                                @foreach ($students as $student)
                                                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                                                @endforeach
                                            </select>
                                            @error("users[{{ $i }}][student_id]")
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
                        <input type="text" name="users[${index}][name]" class="form-control" value="" required>
                    </td>
                    <td>
                        <input type="text" name="users[${index}][username]" class="form-control" value="" required>
                    </td>
                    <td>
                        <input type="text" name="users[${index}][password]" class="form-control" required>
                    </td>
                    <td>
                        <select name="users[${index}][role]" class="form-control" required>
                            <option value="">Select Role</option>
                            <option value="admin">Admin</option>
                            <option value="guru">Guru</option>
                            <option value="siswa">Siswa</option>
                        </select>
                    </td>
                    <td>
                        <select name="users[${index}][teacher_id]" class="form-control" required>
                            <option value="">Select Teacher</option>
                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select name="users[${index}][student_id]" class="form-control" required>
                            <option value="">Select Student</option>
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}">{{ $student->name }}</option>
                            @endforeach
                        </select>
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