<!doctype html>
<html lang="en">
  <head>
     @include('partials.head')
  </head>

  <body>
    <!-- Wrapper -->
    <div id="db-wrapper">
      <!-- navbar vertical -->
    @include('partials.navbar-vertical')
      
      <!-- Page Content -->
      <main id="page-content">
        @include('partials.dashboard-header')

        <!-- Page Header -->
        <!-- Container fluid -->
        <section class="container-fluid p-4">
          <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
              <div class="border-bottom pb-3 mb-3 d-flex flex-column flex-lg-row gap-3 justify-content-between align-items-lg-center">
                <div>
                  <h1 class="mb-0 h2 fw-bold">Dashboard admin 123</h1>
                </div>
                <div class="d-flex gap-3">
                  <div class="input-group">
                    <input class="form-control flatpickr" type="text" placeholder="Select Date" aria-describedby="basic-addon2" />

                    <span class="input-group-text" id="basic-addon2"><i class="fe fe-calendar"></i></span>
                  </div>
                  <a href="#" class="btn btn-primary">Setting</a>
                </div>
              </div>
            </div>
          </div>
          <div class="row gy-4 mb-4">
            <div class="col-xl-3 col-lg-6 col-md-12 col-12">
              <!-- Card -->
              <div class="card">
                <!-- Card body -->
                <div class="card-body d-flex flex-column gap-3">
                  <div class="d-flex align-items-center justify-content-between lh-1">
                    <div>
                      <span class="fs-6 text-uppercase fw-semibold ls-md">Sales</span>
                    </div>
                    <div>
                      <span class="fe fe-shopping-bag fs-3 text-primary"></span>
                    </div>
                  </div>
                  <div class="d-flex flex-column gap-1">
                    <h2 class="fw-bold mb-0">$10,800</h2>
                    <div class="d-flex flex-row gap-2">
                      <span class="text-success fw-semibold">
                        <i class="fe fe-trending-up me-1"></i>
                        +20.9$
                      </span>

                      <span class="fw-medium">Number of sales</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-12 col-12">
              <!-- Card -->
              <div class="card">
                <!-- Card body -->
                <div class="card-body d-flex flex-column gap-3">
                  <div class="d-flex align-items-center justify-content-between lh-1">
                    <div>
                      <span class="fs-6 text-uppercase fw-semibold ls-md">Courses</span>
                    </div>
                    <div>
                      <span class="fe fe-book-open fs-3 text-primary"></span>
                    </div>
                  </div>
                  <div class="d-flex flex-column gap-1">
                    <h2 class="fw-bold mb-0">2,456</h2>
                    <div class="d-flex flex-row gap-2">
                      <span class="text-danger fw-semibold">120+</span>
                      <span class="fw-medium">Number of pending</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-12 col-12">
              <!-- Card -->
              <div class="card">
                <!-- Card body -->
                <div class="card-body d-flex flex-column gap-3">
                  <div class="d-flex align-items-center justify-content-between lh-1">
                    <div>
                      <span class="fs-6 text-uppercase fw-semibold ls-md">Students</span>
                    </div>
                    <div>
                      <span class="fe fe-users fs-3 text-primary"></span>
                    </div>
                  </div>
                  <div class="d-flex flex-column gap-1">
                    <h2 class="fw-bold mb-0">1,22,456</h2>
                    <div class="d-flex flex-row gap-2">
                      <span class="text-success fw-semibold">
                        <i class="fe fe-trending-up me-1"></i>
                        +1200
                      </span>
                      <span class="fw-medium">Students</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-12 col-12">
              <!-- Card -->
              <div class="card">
                <!-- Card body -->
                <div class="card-body d-flex flex-column gap-3">
                  <div class="d-flex align-items-center justify-content-between lh-1">
                    <div>
                      <span class="fs-6 text-uppercase fw-semibold ls-md">Instructor</span>
                    </div>
                    <div>
                      <span class="fe fe-user-check fs-3 text-primary"></span>
                    </div>
                  </div>
                  <div class="d-flex flex-column gap-1">
                    <h2 class="fw-bold mb-0">22,786</h2>
                    <div class="d-flex flex-row gap-1">
                      <span class="text-success fw-semibold">
                        <i class="fe fe-trending-up me-1"></i>
                        +200
                      </span>
                      <span class="ms-1 fw-medium">Instructor</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </main>
    </div>

    <!-- Script -->

    @include('partials.scripts')

    <script src="assets/js/vendors/chart.js"></script>
    <script src="assets/js/vendors/flatpickr.js"></script>
  </body>
</html>
