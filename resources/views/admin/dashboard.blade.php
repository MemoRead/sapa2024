@extends('layouts.main')
@section('title', 'Admin Dashboard')

@section('container')
  <div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Home</a></li>
        </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">
      <div class="row">
          <div class="col-lg-12">
              <div class="card info-card sales-card text-center">
                  <div class="card-body ">
                      <h5 class="card-title">Welcome <span>| {{ auth()->user()->name }}</span></h5>
                      <div>
                          <form class="d-flex align-items-center justify-content-center" action="{{ route('logout') }}" method="post">
                              @csrf
                              <button class="btn btn-warning small pt-1 fw-bold text-white" type="submit">
                                  <i class="bi box-arrow-right text-white"></i> Logout
                              </button>
                          </form>

                      </div>
                  </div>
              </div>
          </div>
      </div>
  </section>

  <section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">
            <div class="row">

                <!-- Sales Card -->
                <div class="col-xxl-3 col-md-3">
                    <div class="card info-card sales-card">

                        <div class="card-body">
                            <h5 class="card-title">Users <span>| Teacher</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $teachersCount }}</h6>
                                    <span class="text-success small pt-1 fw-bold">People</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Sales Card -->

                <!-- Sales Card -->
                <div class="col-xxl-3 col-md-3">
                    <div class="card info-card sales-card">

                        <div class="card-body">
                            <h5 class="card-title">Users <span>| Students</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-person"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $studentsCount }}</h6>
                                    <span class="text-success small pt-1 fw-bold">People</span>

                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Sales Card -->

                <!-- Revenue Card -->
                <div class="col-xxl-3 col-md-3">
                    <div class="card info-card revenue-card">

                        <div class="card-body">
                            <h5 class="card-title">Attendant <span>| Records</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-journal-bookmark"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $attendantRecordsCount }}</h6>
                                    <span class="text-muted small pt-2 ps-1">Records</span>

                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Revenue Card -->

                <!-- Revenue Card -->
                <div class="col-xxl-3 col-md-3">
                    <div class="card info-card revenue-card">

                        <div class="card-body">
                            <h5 class="card-title">Journal <span>| Records</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-journal-bookmark"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $journalRecordsCount }}</h6>
                                    <span class="text-muted small pt-2 ps-1">Records</span>

                                </div>
                            </div>

                        </div>
                    </div>

                </div><!-- End Revenue Card -->

            </div>
        </div>

    </div>
</section>

@endsection