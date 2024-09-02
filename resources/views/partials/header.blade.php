  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    {{-- LOGO --}}
    <div class="d-flex align-items-center justify-content-between">
      <a href="
        @if(auth()->user()->role == 'admin')
          {{ route('admin.dashboard') }}
        @elseif(auth()->user()->role == 'teacher')
          {{ route('teacher.dashboard') }}
        @else
          {{ route('student.dashboard') }}
        @endif
      " class="logo d-flex align-items-center">
        <img src="{{ asset('img/logo.png') }}" alt="Aliyah Logo">
        <span class="d-none d-lg-block">SAPA 2024 - Beta</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->
  
    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        
        @auth
          <li class="nav-item dropdown pe-3">
    
            <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
              @if (auth()->user()->role == 'admin')
                  <img class="img-fluid rounded-circle" src="{{ asset('img/blank.jpg') }}" alt="profile">
                  <span class="d-none d-md-block dropdown-toggle ps-2">{{ auth()->user()->name }}</span>
              @elseif (auth()->user()->role == 'teacher')
                  <img class="img-fluid rounded-circle" src="{{ asset('img/teachers.png') }}" alt="profile">
                  <span class="d-none d-md-block dropdown-toggle ps-2">{{ auth()->user()->name }}</span>
              @elseif (auth()->user()->role == 'student')
                  <img class="img-fluid rounded-circle" src="{{ asset('img/students.png') }}" alt="profile">
                  <span class="d-none d-md-block dropdown-toggle ps-2">{{ auth()->user()->name }}</span>
              @else
                  <img class="img-fluid rounded-circle" src="{{ asset('img/blank.jpg') }}" alt="profile">
                  <span class="d-none d-md-block dropdown-toggle ps-2">{{ auth()->user()->name }}</span>
              @endif
            </a><!-- End Profile Image Icon -->
    
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
              <li class="dropdown-header">
                <h6>{{ auth()->user()->name }}</h6>
                <span>{{ auth()->user()->role }}</span>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>
    
              <li>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <i class="bi bi-person"></i>
                  <span>My Profile</span>
                </a>
              </li>
    
              <li>
                <hr class="dropdown-divider">
              </li>
    
              <li>
                <form class="d-flex align-items-center" action="{{ route('logout') }}" method="post">
                  @csrf
                  <button class="dropdown-item " type="submit">
                      <i class="bi bi-box-arrow-right"></i>Logout
                  </button>
                </form>
              </li>
    
            </ul><!-- End Profile Dropdown Items -->
          </li><!-- End Profile Nav -->
            
        @endauth
  
      </ul>
    </nav><!-- End Icons Navigation -->
  
  </header><!-- End Header -->