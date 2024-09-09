<div class="table-responsive">
  <table id="attendanceHistoryTable" class="table table-striped">
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
                  <td>{{ $attendance->attendance_in }}</td>
                  <td>{{ $attendance->attendance_out }}</td>
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

  {{ $attendanceReports->links('pagination::bootstrap-5') }}
</div>
