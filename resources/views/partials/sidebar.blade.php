
<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        @if (Auth::user()->role == 'admin')
            <!-- Dashboard -->
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/dashboard') ? '' : 'collapsed' }}" href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->

            <li class="nav-heading">Admin Menu</li>

            <!-- Users -->
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/users*') ? '' : 'collapsed' }}" data-bs-target="#users-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-people"></i><span>Users</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="users-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a class="nav-link {{ Request::is('admin/users/students*') ? '' : 'collapsed' }}" href="{{ route('admin.users.student') }}">
                            <i class="bi bi-circle"></i><span>Students</span>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link {{ Request::is('admin/users/teachers*') ? '' : 'collapsed' }}"
                            href="{{ route('admin.users.teacher') }}">
                            <i class="bi bi-circle"></i><span>Teachers</span>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link {{ Request::is('admin/users/user*') ? '' : 'collapsed' }}"
                            href="{{ route('admin.users.index') }}">
                            <i class="bi bi-circle"></i><span>Users</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Users Nav -->

            <!-- Report -->
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/reports*') ? '' : 'collapsed' }}" data-bs-target="#mails-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-card-checklist"></i><span>Reports</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="mails-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a class="nav-link {{ Request::is('admin/reports/attendance*') ? '' : 'collapsed' }}" href="{{ route('admin.attendance.report') }}">
                            <i class="bi bi-circle"></i><span>Absensi Siswa</span>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link {{ Request::is('dashboard/reports/journal*') ? '' : 'collapsed' }}"
                            href="{{ route('admin.journal.report') }}">
                            <i class="bi bi-circle"></i><span>Jurnal Siswa</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Report Nav -->

        @elseif (Auth::user()->role == 'teacher')
            <!-- Dashboard -->
            <li class="nav-item">
                <a class="nav-link {{ Request::is('guru/dashboard') ? '' : 'collapsed' }}" href="{{ route('guru.dashboard') }}">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->

            <li class="nav-heading">Guru Menu</li>

            <!-- Absensi -->
            <li class="nav-item">
                <a class="nav-link {{ Request::is('guru/attendance-monitoring*') ? '' : 'collapsed' }}" href="{{ route('guru.attendance.monitoring') }}">
                    <i class="bi bi-person-gear"></i>
                    <span>Monitoring Absensi</span>
                </a>
            </li><!-- End Absensi Nav -->

            <!-- Jurnal -->
            <li class="nav-item">
                <a class="nav-link {{ Request::is('guru/journal-monitoring*') ? '' : 'collapsed' }}" href="{{ route('guru.journal.monitoring') }}">
                    <i class="bi bi-person-gear"></i>
                    <span>Monitoring Jurnal</span>
                </a>
            </li><!-- End Jurnal Nav -->

        @else
            <!-- Dashboard -->
            <li class="nav-item">
                <a class="nav-link {{ Request::is('student/dashboard') ? '' : 'collapsed' }}" href="{{ route('student.dashboard') }}">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->

            <li class="nav-heading">Siswa Menu</li>

            <!-- Absensi -->
            <li class="nav-item">
                <a class="nav-link {{ Request::is('student/attendance*') ? '' : 'collapsed' }}" data-bs-target="#attendance-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-card-checklist"></i><span>Absensi</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="attendance-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a id="absent-form-button" class="nav-link {{ Request::is('student/attendance/form*') ? '' : 'collapsed' }}" href="{{ route('attendance.form') }}">
                            <i class="bi bi-circle"></i><span>Form Absensi</span>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link {{ Request::is('student/attendance/recap*') ? '' : 'collapsed' }}"
                            href="{{ route('attendance.recap') }}">
                            <i class="bi bi-circle"></i><span>Riwayat Absen</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Absensi Nav -->

            <!-- Journal -->
            <li class="nav-item">
                <a class="nav-link {{ Request::is('student/journal*') ? '' : 'collapsed' }}" href="{{ route('student.journal.index') }}">
                    <i class="bi bi-card-checklist"></i>
                    <span>Journal</span>
                </a>
            </li><!-- End Journal Nav -->

        @endif

    </ul>

</aside><!-- End Sidebar-->