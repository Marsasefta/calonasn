<!doctype html>
<html lang="en">
  <head>
     @include('partials.head')

    <title>Student Dashboard | Geeks - Bootstrap 5 Template</title>
  </head>

  <body>
    <!-- Page Content -->
    @include('partials.navbar')
    <!-- Sidebar -->
    @include('partials.navbar-student')

    <div class="db-content">
      <div class="container mb-4">
        <div class="row mb-5">
          <div class="col-12">
            <h1 class="h2 mb-0">My Dashboard</h1>
          </div>
        </div>
        <div class="row mb-5 g-4 gy-lg-0">
          <div class="col-xxl-3 col-lg-5 col-12">
            <div class="card h-100">
              <div class="card-body d-flex flex-column gap-4 p-4">
                <div class="d-flex flex-column gap-2">
                  <div class="d-flex flex-row justify-content-between">
                    <img src="assets/images/avatar/avatar-1.jpg" alt="avatar" class="avatar avatar-xl rounded-circle" />
                    <a href="#!" class="btn-icon btn btn-ghost btn-sm rounded-circle" data-bs-toggle="tooltip" data-placement="top" title="Edit">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                        <path
                          d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325" />
                      </svg>
                    </a>
                  </div>
                  <div class="d-flex flex-column gap-1">
                    <h2 class="h3 mb-0">Hey, Jitu</h2>
                    <span class="fs-6 fw-medium">ID: 98765</span>
                  </div>
                </div>
                <div class="d-flex flex-column">
                  <span class="fs-6 fw-medium">Current Course: </span>
                  <span class="fw-bold">Full Stack Development</span>
                </div>
                <div class="d-flex flex-column gap-2">
                  <div class="progress" style="height: 4px">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 65%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <span class="small">Profile 30% complete</span>
                </div>
                <div class="d-flex flex-row gap-2">
                  <a href="#!">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <rect width="24" height="24" rx="12" fill="var(--gk-gray-100)" />
                      <path
                        d="M12 20C15.314 20 18 18 18 14.5C18 13 17.5 10.5 15.5 8.5C15.75 10 14.25 10.5 14.25 10.5C15 8 13 4.5 10 4C10.357 6 10.5 8 8 10C6.75 11 6 12.729 6 14.5C6 18 8.686 20 12 20ZM12 19C10.343 19 9 18 9 16.25C9 15.5 9.25 14.25 10.25 13.25C10.125 14 11 14.5 11 14.5C10.625 13.25 11.5 11.25 13 11C12.821 12 12.75 13 14 14C14.625 14.5 15 15.364 15 16.25C15 18 13.657 19 12 19Z"
                        fill="url(#paint0_linear_8175_5853)" />
                      <defs>
                        <linearGradient id="paint0_linear_8175_5853" x1="12" y1="4" x2="12" y2="20" gradientUnits="userSpaceOnUse">
                          <stop stop-color="var(--gk-danger)" />
                          <stop offset="1" stop-color="var(--gk-danger)" />
                        </linearGradient>
                      </defs>
                    </svg>
                  </a>
                  <a href="#!">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <rect width="24" height="24" rx="12" fill="var(--gk-gray-100)" />
                      <path
                        d="M12 20C15.314 20 18 18 18 14.5C18 13 17.5 10.5 15.5 8.5C15.75 10 14.25 10.5 14.25 10.5C15 8 13 4.5 10 4C10.357 6 10.5 8 8 10C6.75 11 6 12.729 6 14.5C6 18 8.686 20 12 20ZM12 19C10.343 19 9 18 9 16.25C9 15.5 9.25 14.25 10.25 13.25C10.125 14 11 14.5 11 14.5C10.625 13.25 11.5 11.25 13 11C12.821 12 12.75 13 14 14C14.625 14.5 15 15.364 15 16.25C15 18 13.657 19 12 19Z"
                        fill="var(--gk-gray-300)" />
                    </svg>
                  </a>

                  <a href="#!">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <rect width="24" height="24" rx="12" fill="var(--gk-gray-100)" />
                      <path
                        d="M12 20C15.314 20 18 18 18 14.5C18 13 17.5 10.5 15.5 8.5C15.75 10 14.25 10.5 14.25 10.5C15 8 13 4.5 10 4C10.357 6 10.5 8 8 10C6.75 11 6 12.729 6 14.5C6 18 8.686 20 12 20ZM12 19C10.343 19 9 18 9 16.25C9 15.5 9.25 14.25 10.25 13.25C10.125 14 11 14.5 11 14.5C10.625 13.25 11.5 11.25 13 11C12.821 12 12.75 13 14 14C14.625 14.5 15 15.364 15 16.25C15 18 13.657 19 12 19Z"
                        fill="var(--gk-gray-300)" />
                    </svg>
                  </a>
                  <a href="#!">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <rect width="24" height="24" rx="12" fill="var(--gk-gray-100)" />
                      <path
                        d="M12 20C15.314 20 18 18 18 14.5C18 13 17.5 10.5 15.5 8.5C15.75 10 14.25 10.5 14.25 10.5C15 8 13 4.5 10 4C10.357 6 10.5 8 8 10C6.75 11 6 12.729 6 14.5C6 18 8.686 20 12 20ZM12 19C10.343 19 9 18 9 16.25C9 15.5 9.25 14.25 10.25 13.25C10.125 14 11 14.5 11 14.5C10.625 13.25 11.5 11.25 13 11C12.821 12 12.75 13 14 14C14.625 14.5 15 15.364 15 16.25C15 18 13.657 19 12 19Z"
                        fill="var(--gk-gray-300)" />
                    </svg>
                  </a>
                  <a href="#!">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <rect width="24" height="24" rx="12" fill="var(--gk-gray-100)" />
                      <path
                        d="M12 20C15.314 20 18 18 18 14.5C18 13 17.5 10.5 15.5 8.5C15.75 10 14.25 10.5 14.25 10.5C15 8 13 4.5 10 4C10.357 6 10.5 8 8 10C6.75 11 6 12.729 6 14.5C6 18 8.686 20 12 20ZM12 19C10.343 19 9 18 9 16.25C9 15.5 9.25 14.25 10.25 13.25C10.125 14 11 14.5 11 14.5C10.625 13.25 11.5 11.25 13 11C12.821 12 12.75 13 14 14C14.625 14.5 15 15.364 15 16.25C15 18 13.657 19 12 19Z"
                        fill="var(--gk-gray-300)" />
                    </svg>
                  </a>
                  <a href="#!">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <rect width="24" height="24" rx="12" fill="var(--gk-gray-100)" />
                      <path
                        d="M12 20C15.314 20 18 18 18 14.5C18 13 17.5 10.5 15.5 8.5C15.75 10 14.25 10.5 14.25 10.5C15 8 13 4.5 10 4C10.357 6 10.5 8 8 10C6.75 11 6 12.729 6 14.5C6 18 8.686 20 12 20ZM12 19C10.343 19 9 18 9 16.25C9 15.5 9.25 14.25 10.25 13.25C10.125 14 11 14.5 11 14.5C10.625 13.25 11.5 11.25 13 11C12.821 12 12.75 13 14 14C14.625 14.5 15 15.364 15 16.25C15 18 13.657 19 12 19Z"
                        fill="var(--gk-gray-300)" />
                    </svg>
                  </a>
                  <a href="#!">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <rect width="24" height="24" rx="12" fill="var(--gk-gray-100)" />
                      <path
                        d="M12 20C15.314 20 18 18 18 14.5C18 13 17.5 10.5 15.5 8.5C15.75 10 14.25 10.5 14.25 10.5C15 8 13 4.5 10 4C10.357 6 10.5 8 8 10C6.75 11 6 12.729 6 14.5C6 18 8.686 20 12 20ZM12 19C10.343 19 9 18 9 16.25C9 15.5 9.25 14.25 10.25 13.25C10.125 14 11 14.5 11 14.5C10.625 13.25 11.5 11.25 13 11C12.821 12 12.75 13 14 14C14.625 14.5 15 15.364 15 16.25C15 18 13.657 19 12 19Z"
                        fill="var(--gk-gray-300)" />
                    </svg>
                  </a>

                  <a href="#!">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <rect width="24" height="24" rx="12" fill="var(--gk-gray-100)" />
                      <path
                        d="M12 20C15.314 20 18 18 18 14.5C18 13 17.5 10.5 15.5 8.5C15.75 10 14.25 10.5 14.25 10.5C15 8 13 4.5 10 4C10.357 6 10.5 8 8 10C6.75 11 6 12.729 6 14.5C6 18 8.686 20 12 20ZM12 19C10.343 19 9 18 9 16.25C9 15.5 9.25 14.25 10.25 13.25C10.125 14 11 14.5 11 14.5C10.625 13.25 11.5 11.25 13 11C12.821 12 12.75 13 14 14C14.625 14.5 15 15.364 15 16.25C15 18 13.657 19 12 19Z"
                        fill="var(--gk-gray-300)" />
                    </svg>
                  </a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xxl-9 col-lg-7 col-12">
            <div class="card h-100">
              <div class="card-body p-5">
                <div class="slider dashboard-slider">
                  <div>
                    <div class="row align-items-center gy-5">
                      <div class="col-xl-6 col-12">
                        <div class="d-flex flex-column gap-4">
                          <div class="d-flex flex-column gap-2">
                            <h2 class="mb-0">Welcome to your Dashboard!</h2>
                            <p class="mb-0">
                              Research shows that setting specific goals boosts effectiveness and success. We suggest you start by taking a moment to think about what you want to achieve
                            </p>
                          </div>
                          <div>
                            <a href="#!" class="btn btn-dark">Create a Learning Path</a>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="text-center d-xl-block d-none">
                          <img src="assets/images/svg/education.svg" alt="education" />
                        </div>
                      </div>
                    </div>
                  </div>
                  <div>
                    <div class="row align-items-center gy-5">
                      <div class="col-xl-6 col-12">
                        <div class="d-flex flex-column gap-4">
                          <div class="d-flex flex-column gap-2">
                            <h2 class="mb-0">Earn the Tech Certificate</h2>
                            <p class="mb-0">Earn industry-recognized certifications by passing the required exams that include questions reflecting real world problems faced in a job.</p>
                          </div>
                          <div>
                            <a href="#!" class="btn btn-dark">Earn Certificate</a>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="text-center d-xl-block d-none">
                          <img src="assets/images/svg/certificates.svg" alt="certificates" />
                        </div>
                      </div>
                    </div>
                  </div>
                  <div>
                    <div class="row align-items-center gy-5">
                      <div class="col-xl-6 col-12">
                        <div class="d-flex flex-column gap-4">
                          <div class="d-flex flex-column gap-2">
                            <h2 class="mb-0">Real World Projects</h2>
                            <p class="mb-0">Engage with real-world challenges using our projects directory. Apply your knowledge to real scenarios in a practical environment.</p>
                          </div>
                          <div>
                            <a href="#!" class="btn btn-dark">Start Project</a>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="text-center d-xl-block d-none">
                          <img src="assets/images/svg/projects.svg" alt="projects" />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Bullet Navigation -->
                <div id="custom-pagination" class="slider-pagination"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="row g-4 mb-5">
          <div class="col-12">
            <div class="d-flex flex-row align-items-center justify-content-between">
              <div class="d-flex flex-row align-items-center gap-2">
                <div>
                  <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_8175_5628)">
                      <path
                        d="M8.211 2.0467C8.14491 2.01594 8.07289 2 8 2C7.9271 2 7.85508 2.01594 7.789 2.0467L0.288996 5.5467C0.200678 5.58793 0.126334 5.65406 0.0751066 5.73698C0.0238794 5.81989 -0.00199738 5.91597 0.000658795 6.0134C0.00331497 6.11083 0.0343882 6.20536 0.0900571 6.28536C0.145726 6.36536 0.223563 6.42735 0.313996 6.4637L7.814 9.4637C7.93338 9.51155 8.06661 9.51155 8.186 9.4637L14 7.1397V12.9997C13.7348 12.9997 13.4804 13.1051 13.2929 13.2926C13.1054 13.4801 13 13.7345 13 13.9997V15.9997H16V13.9997C16 13.7345 15.8946 13.4801 15.7071 13.2926C15.5196 13.1051 15.2652 12.9997 15 12.9997V6.7387L15.686 6.4637C15.7764 6.42735 15.8543 6.36536 15.9099 6.28536C15.9656 6.20536 15.9967 6.11083 15.9993 6.0134C16.002 5.91597 15.9761 5.81989 15.9249 5.73698C15.8737 5.65406 15.7993 5.58793 15.711 5.5467L8.211 2.0467ZM8 8.4597L1.758 5.9647L8 3.0517L14.242 5.9647L8 8.4597Z"
                        fill="#64748B" />
                      <path
                        d="M4.176 9.0321C4.11162 9.00784 4.04292 8.99714 3.97421 9.00065C3.9055 9.00416 3.83825 9.02182 3.77668 9.05251C3.7151 9.08321 3.66053 9.12628 3.61636 9.17903C3.57219 9.23179 3.53939 9.29309 3.52 9.3591L3.02 11.0591C2.98498 11.1784 2.9957 11.3066 3.05006 11.4184C3.10442 11.5303 3.19853 11.6179 3.314 11.6641L7.814 13.4641C7.93339 13.5119 8.06662 13.5119 8.186 13.4641L12.686 11.6641C12.8015 11.6179 12.8956 11.5303 12.9499 11.4184C13.0043 11.3066 13.015 11.1784 12.98 11.0591L12.48 9.3591C12.4606 9.29309 12.4278 9.23179 12.3836 9.17903C12.3395 9.12628 12.2849 9.08321 12.2233 9.05251C12.1618 9.02182 12.0945 9.00416 12.0258 9.00065C11.9571 8.99714 11.8884 9.00784 11.824 9.0321L8 10.4661L4.176 9.0321ZM4.108 10.9051L4.328 10.1571L7.824 11.4681C7.93746 11.5108 8.06255 11.5108 8.176 11.4681L11.672 10.1571L11.892 10.9051L8 12.4601L4.108 10.9051Z"
                        fill="#64748B" />
                    </g>
                    <defs>
                      <clipPath id="clip0_8175_5628">
                        <rect width="16" height="16" fill="white" />
                      </clipPath>
                    </defs>
                  </svg>
                </div>
                <h3 class="mb-0">Learn</h3>
              </div>
              <a href="#!" class="btn btn-primary">View All</a>
            </div>
          </div>
          <div class="col-xl-3 col-md-6 col-12">
            <!-- Card -->
            <div class="card">
              <a href="#"><img src="assets/images/course/course-html.jpg" alt="course" class="card-img-top" /></a>
              <!-- Card body -->
              <div class="card-body d-flex flex-column gap-3">
                <h3 class="h4 mb-0"><a href="#" class="text-inherit">HTML Courses</a></h3>

                <div class="d-flex flex-column gap-2">
                  <div class="d-flex flex-row justify-content-between align-items-center">
                    <span class="text-truncate">12 of 12 lessons completed...</span>
                    <span class="fw-bold">100%</span>
                  </div>
                  <div class="progress" style="height: 6px">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
                <div>
                  <span class="badge bg-success-subtle border border-success rounded-pill text-success">Completed</span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-md-6 col-12">
            <!-- Card -->
            <div class="card">
              <a href="#"><img src="assets/images/course/course-javascript.jpg" alt="course" class="card-img-top" /></a>
              <!-- Card body -->
              <div class="card-body d-flex flex-column gap-3">
                <h3 class="h4 mb-0"><a href="#" class="text-inherit">Javascript Courses</a></h3>

                <div class="d-flex flex-column gap-2">
                  <div class="d-flex flex-row justify-content-between align-items-center">
                    <span class="text-truncate">1 of 12 lessons completed...</span>
                    <span class="fw-bold">20%</span>
                  </div>
                  <div class="progress" style="height: 6px">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 35%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
                <div>
                  <span class="badge bg-warning-subtle border border-warning rounded-pill text-warning">In Process</span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-md-6 col-12">
            <!-- Card -->
            <div class="card">
              <a href="#"><img src="assets/images/course/course-python.jpg" alt="course" class="card-img-top" /></a>
              <!-- Card body -->
              <div class="card-body d-flex flex-column gap-3">
                <h3 class="h4 mb-0"><a href="#" class="text-inherit">Learn Python</a></h3>

                <div class="d-flex flex-column gap-2">
                  <div class="d-flex flex-row justify-content-between align-items-center">
                    <span class="text-truncate">0 of 15 lessons completed...</span>
                    <span class="fw-bold">0%</span>
                  </div>
                  <div class="progress" style="height: 6px">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
                <div>
                  <span class="badge bg-light-subtle border rounded-pill text-secondary">Not Started</span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-md-6 col-12">
            <!-- Card -->
            <div class="card">
              <a href="#"><img src="assets/images/course/course-react.jpg" alt="course" class="card-img-top" /></a>
              <!-- Card body -->
              <div class="card-body d-flex flex-column gap-3">
                <h3 class="h4 mb-0"><a href="#" class="text-inherit">React Fundamental</a></h3>

                <div class="d-flex flex-column gap-2">
                  <div class="d-flex flex-row justify-content-between align-items-center">
                    <span class="text-truncate">0 of 10 lessons completed...</span>
                    <span class="fw-bold">0%</span>
                  </div>
                  <div class="progress" style="height: 6px">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 35%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
                <div>
                  <span class="badge bg-light-subtle border rounded-pill text-secondary">Not Started</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="d-flex flex-row align-items gap-2 mb-3">
              <div>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <g clip-path="url(#clip0_8182_18024)">
                    <path
                      d="M14.5035 1.296L12 0L9.49648 1.296L6.70948 1.719L5.44648 4.239L3.44098 6.219L3.89998 9L3.44098 11.781L5.44648 13.761L6.70948 16.281L9.49648 16.704L12 18L14.5035 16.704L17.2905 16.281L18.5535 13.761L20.559 11.781L20.1 9L20.559 6.219L18.5535 4.239L17.2905 1.719L14.5035 1.296ZM16.2975 3.0855L17.3235 5.133L18.9525 6.741L18.5805 9L18.9525 11.259L17.3235 12.867L16.2975 14.9145L14.0325 15.258L12 16.311L9.96748 15.258L7.70248 14.9145L6.67648 12.867L5.04748 11.259L5.42098 9L5.04598 6.741L6.67648 5.133L7.70248 3.0855L9.96748 2.742L12 1.689L14.034 2.742L16.2975 3.0855Z"
                      fill="#64748B" />
                    <path d="M6 17.6914V24.0004L12 22.5004L18 24.0004V17.6914L14.973 18.1504L12 19.6894L9.027 18.1504L6 17.6914Z" fill="#64748B" />
                  </g>
                  <defs>
                    <clipPath id="clip0_8182_18024">
                      <rect width="24" height="24" fill="white" />
                    </clipPath>
                  </defs>
                </svg>
              </div>
              <h3 class="mb-0">Certification</h3>
            </div>
          </div>
          <div class="col-12">
            <div class="border-dashed py-6 text-center rounded-3 px-4 px-md-7 px-lg-0">
              <div class="bg-gray-300 rounded-circle icon-shape icon-xl mb-4">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="text-secondary">
                  <g clip-path="url(#clip0_8182_18024)">
                    <path
                      d="M14.5035 1.296L12 0L9.49648 1.296L6.70948 1.719L5.44648 4.239L3.44098 6.219L3.89998 9L3.44098 11.781L5.44648 13.761L6.70948 16.281L9.49648 16.704L12 18L14.5035 16.704L17.2905 16.281L18.5535 13.761L20.559 11.781L20.1 9L20.559 6.219L18.5535 4.239L17.2905 1.719L14.5035 1.296ZM16.2975 3.0855L17.3235 5.133L18.9525 6.741L18.5805 9L18.9525 11.259L17.3235 12.867L16.2975 14.9145L14.0325 15.258L12 16.311L9.96748 15.258L7.70248 14.9145L6.67648 12.867L5.04748 11.259L5.42098 9L5.04598 6.741L6.67648 5.133L7.70248 3.0855L9.96748 2.742L12 1.689L14.034 2.742L16.2975 3.0855Z"
                      fill="#64748B" />
                    <path d="M6 17.6914V24.0004L12 22.5004L18 24.0004V17.6914L14.973 18.1504L12 19.6894L9.027 18.1504L6 17.6914Z" fill="#64748B" />
                  </g>
                  <defs>
                    <clipPath id="clip0_8182_18024">
                      <rect width="24" height="24" fill="white" />
                    </clipPath>
                  </defs>
                </svg>
              </div>
              <div class="d-flex flex-column gap-2 mb-4">
                <h3 class="mb-0 h2">Earn Certificates online Free</h3>
                <p class="mb-0">Improve your chances of getting hired with an industry recognized Geeks Certification.</p>
              </div>
              <div>
                <a href="#!" class="btn btn-success">See All Certificate</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Scroll top -->
     @include('partials.btn-scroll-top')
    <!-- Scripts -->
     @include('partials.scripts')
    <script src="assets/js/vendors/tnsSlider.js"></script>
    <script src="assets/js/vendors/chart.js"></script>
    <script src="assets/js/vendors/navbar-nav.js"></script>
  </body>
</html>
