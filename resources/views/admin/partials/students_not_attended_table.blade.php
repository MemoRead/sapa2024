<div class="table-responsive">
  <table id="studentsNotAttendedTable" class="table table-striped">
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

  {{ $studentsNotAttended->links('pagination::bootstrap-5') }}

</div>
