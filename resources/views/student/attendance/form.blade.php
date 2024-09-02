@extends('layouts.main')
@section('title', 'Form Absensi')

@section('container')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get current time in UTC
            const now = new Date();

            // Convert to Western Indonesian Time (UTC+7)
            const wibOffset = 7 * 60; // 7 hours in minutes
            const localOffset = now.getTimezoneOffset(); // Local timezone offset in minutes
            const wibTime = new Date(now.getTime() + (wibOffset + localOffset) * 60000);

            // Format date and time
            const date = wibTime.toISOString().split('T')[0];
            const hours = wibTime.getHours().toString().padStart(2, '0');
            const minutes = wibTime.getMinutes().toString().padStart(2, '0');
            const time = `${hours}:${minutes}`;

            // Set date and time in the form fields
            document.getElementById('absence_date').value = date;
            document.getElementById('absence_time').value = time;

            // Geolocation API to get current location
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    document.getElementById('absence_location').value = position.coords.latitude + ', ' + position.coords.longitude;
                });
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        });
    </script>

    <div class="pagetitle">
        <h1>Form Absensi</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('student.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">Form</li>
                <li class="breadcrumb-item active">Absensi</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    
    @if ($errors->any())
        <div class="col-lg-8 alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form class="col g-3" id="attendance-form" action="{{ route('attendance.submit') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="card col-lg-8">
            <div class="card-body">
                <div class="card-title">Absen Siki!</div>
                <p>Kolom bertanda * wajib diisi</p>

                <div class="row mb-3">
                    <label for="student_name" class="col-sm-2 col-form-label">Nama *</label>
                    <input type="text" name="student_name" id="student_name" class="form-control" value="{{ $student->name }}" readonly>
                    <input type="hidden" name="student_id" id="student_id" value="{{ $student->id }}">
                </div>

                <div class="row mb-3">
                    <label for="class" class="col-sm-2 col-form-label">Kelas *</label>
                    <input type="text" name="class" id="class" class="form-control" value="{{ $student->class }}" readonly>
                </div>

                <div class="row mb-3">
                    <label for="skill_id" class="col-sm-2 col-form-label">Keterampilan *</label>
                    <input type="text" name="skill_id" id="skill_id" class="form-control" value="{{ $student->skill_id ? $student->skill->name : 'N/A'}}" readonly>
                </div>

                <div class="row mb-3">
                    <label for="group" class="col-sm-2 col-form-label">Group *</label>
                    <input type="text" name="group" id="group" class="form-control" value="{{ $student->group }}" readonly>
                </div>


            </div>
        </div>

        <div class="card col-lg-8">
            <div class="card-body">

                <div class="mb-3">
                    <label for="absence_date" class="col-sm-2 col-form-label">Date</label>
                    <input type="date" name="absence_date" id="absence_date" class="form-control" value="{{ old('absence_date', date('Y-m-d')) }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="absence_time" class="col-sm-2 col-form-label">Time</label>
                    <input type="time" name="absence_time" id="absence_time" class="form-control" value="{{ old('absence_time', date('H:i')) }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="absence_location" class="col-sm-2 col-form-label">Location</label>
                    <input type="text" name="absence_location" id="absence_location" class="form-control" value="{{ old('absence_location') }}" readonly>
                </div>

            </div>
        </div>

        <div class="card col-lg-8">
            <div class="card-body">
                <div class="mb-3 mt-3 form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" name="is_holiday" value="1" {{ old('is_holiday') ? 'checked' : '' }}>
                    <label for="flexSwitchCheckDefault" class="col-sm-2 form-check-label">Absen Libur ?</label>
                </div>

                <div class="mb-3">
                    <label for="absence_type" class="col-sm-2 col-form-label">Jenis Absensi *</label>
                    <select name="absence_type" id="absence_type" class="form-select" required>
                        <option value="" disabled selected>Select Type</option>
                        <option value="attendance_in" {{ old('absence_type') == 'attendance_in' ? 'selected' : '' }}>Absen Berangkat</option>
                        <option value="attendance_out" {{ old('absence_type') == 'attendance_out' ? 'selected' : '' }}>Absen Pulang</option>
                    </select>
                </div>

                <div id="attendance-section" class="mb-3" style="display: none;">
                    <label for="attendance" class="col-sm-2 col-form-label">Kehadiran *</label>
                    <select name="attendance" id="attendance" class="form-select">
                        <option value="attendance">Hadir</option>
                        <option value="sick">Sakit</option>
                        <option value="permission">Izin</option>
                    </select>
                </div>

            </div>
        </div>

        <div class="card col-lg-8">
            <div class="card-body">

                <div id="proof-section" class="mb-3" style="display: none;">
                    <label for="proof_of_attendance" class="col-sm-2 col-form-label">Bukti Kehadiran</label>
                    <div>
                        <video id="video" width="320" height="240" autoplay></video>
                        <img id="captured-image" style="display: none; max-width: 320px; max-height: 240px;">
                        <button type="button" id="capture" class="btn btn-primary">Capture</button>
                        <canvas id="canvas" style="display: none;"></canvas>
                        <input type="hidden" name="proof_of_attendance" id="proof_of_attendance" value="{{ old('proof_of_attendance') }}">
                    </div>
                </div>

                <div id="notes-section" class="mb-3" style="display: none;">
                    <label for="notes" class="col-sm-2 col-form-label">Catatan</label>
                    <textarea name="notes" id="notes" class="form-control">{{ old('notes') }}</textarea>
                </div>

            </div>
        </div>

        <div class="d-flex col-lg-8 justify-content-center align-items-center">
            <button type="submit" id="submit-button" class="btn btn-primary">Submit</button>
        </div>
    </form>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Confirm Your Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Student ID:</strong> <span id="confirm-student-id"></span></p>
                    <p><strong>Absence Date:</strong> <span id="confirm-absence-date"></span></p>
                    <p><strong>Absence Time:</strong> <span id="confirm-absence-time"></span></p>
                    <p><strong>Absence Location:</strong> <span id="confirm-absence-location"></span></p>
                    <p><strong>Is Holiday:</strong> <span id="confirm-is-holiday"></span></p>
                    <p><strong>Absence Type:</strong> <span id="confirm-absence-type"></span></p>
                    <p><strong>Notes:</strong> <span id="confirm-notes"></span></p>
                    <p><strong>Proof of Attendance:</strong></p>
                    <img id="confirm-proof-of-attendance" style="max-width: 320px; max-height: 240px;">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="confirm-submit" class="btn btn-primary">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            console.log("DOM fully loaded and parsed");

            const absenceTypeSelect = document.getElementById('absence_type');
            const attendanceSection = document.getElementById('attendance-section');
            const proofSection = document.getElementById('proof-section');
            const notesSection = document.getElementById('notes-section');
            const video = document.getElementById('video');
            const canvas = document.getElementById('canvas');
            const captureButton = document.getElementById('capture');
            const proofInput = document.getElementById('proof_of_attendance');
            const capturedImage = document.getElementById('captured-image');
            const submitButton = document.getElementById('submit-button');
            const confirmSubmitButton = document.getElementById('confirm-submit');
            const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
            const isHolidayCheckbox = document.getElementById('flexSwitchCheckDefault');

            if (!absenceTypeSelect || !proofSection || !notesSection || !video || !canvas || !captureButton || !proofInput || !capturedImage || !submitButton || !confirmSubmitButton || !confirmationModal) {
                console.error("One or more elements are missing");
                return;
            }

            function updateForm() {
                const absenceType = absenceTypeSelect.value;
                const isHolidayChecked = isHolidayCheckbox.checked;

                if (isHolidayChecked) {
                    absenceTypeSelect.style.display = 'none';
                    attendanceSection.style.display = 'none';
                    proofSection.style.display = 'none';
                    notesSection.style.display = 'none';
                } else {
                    absenceTypeSelect.style.display = 'block';

                    if (absenceType === 'attendance_in') {
                        attendanceSection.style.display = 'block';
                        proofSection.style.display = 'block';
                        notesSection.style.display = 'none';
                    } else if (absenceType === 'attendance_out') {
                        attendanceSection.style.display = 'none';
                        proofSection.style.display = 'block';
                        notesSection.style.display = 'block';
                    } else {
                        attendanceSection.style.display = 'none';
                        proofSection.style.display = 'none';
                        notesSection.style.display = 'none';
                    }
                }
            }

            absenceTypeSelect.addEventListener('change', updateForm);
            isHolidayCheckbox.addEventListener('change', updateForm);
            updateForm(); // Initial call to set the correct state on page load

            // Access the camera
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(stream => {
                    video.srcObject = stream;
                })
                .catch(err => {
                    console.error("Error accessing the camera: ", err);
                });

            // Capture the image
            captureButton.addEventListener('click', function () {
                console.log("Capture button clicked");
                const context = canvas.getContext('2d');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                context.drawImage(video, 0, 0, canvas.width, canvas.height);
                const dataUrl = canvas.toDataURL('image/png');
                proofInput.value = dataUrl;
                capturedImage.src = dataUrl;
                capturedImage.style.display = 'block';
                video.style.display = 'none';
                console.log("Image captured and stored in hidden input");
            });

            // Show confirmation modal
            submitButton.addEventListener('click', function (event) {
                event.preventDefault();
                document.getElementById('confirm-student-id').innerText = document.getElementById('student_id').value;
                document.getElementById('confirm-absence-date').innerText = document.getElementById('absence_date').value;
                document.getElementById('confirm-absence-time').innerText = document.getElementById('absence_time').value;
                document.getElementById('confirm-absence-location').innerText = document.getElementById('absence_location').value;
                document.getElementById('confirm-is-holiday').innerText = document.getElementById('is_holiday').checked ? 'Yes' : 'No';
                document.getElementById('confirm-absence-type').innerText = document.getElementById('absence_type').value;
                document.getElementById('confirm-notes').innerText = document.getElementById('notes').value;
                document.getElementById('confirm-proof-of-attendance').src = proofInput.value;
                confirmationModal.show();
            });

            // Confirm submission
            confirmSubmitButton.addEventListener('click', function () {
                document.getElementById('attendance-form').submit();
            });

        });
    </script>
@endsection

