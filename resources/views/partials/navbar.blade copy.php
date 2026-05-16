<nav class="navbar navbar-expand-lg">
  <div class="container-fluid px-0">
    {{-- <a class="navbar-brand" href="index.php"><img src="/build/assets/images/brand/logo/logo.svg" alt="Geeks" /></a> --}}
    <!-- Mobile view nav wrap -->
    <div class="ms-auto d-flex align-items-center order-lg-3">
      <div class="dropdown">
        <button class="btn btn-light btn-icon rounded-circle d-flex align-items-center" type="button" aria-expanded="false" data-bs-toggle="dropdown" aria-label="Toggle theme (auto)">
          <i class="bi theme-icon-active"></i>
          <span class="visually-hidden bs-theme-text">Toggle theme</span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bs-theme-text">
          <li>
            <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light" aria-pressed="false">
              <i class="bi theme-icon bi-sun-fill"></i>
              <span class="ms-2">Light</span>
            </button>
          </li>
          <li>
            <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" aria-pressed="false">
              <i class="bi theme-icon bi-moon-stars-fill"></i>
              <span class="ms-2">Dark</span>
            </button>
          </li>
          <li>
            <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto" aria-pressed="true">
              <i class="bi theme-icon bi-circle-half"></i>
              <span class="ms-2">Auto</span>
            </button>
          </li>
        </ul>
      </div>
      <ul class="navbar-nav navbar-right-wrap ms-2 flex-row d-none d-md-block">
        <li class="dropdown d-inline-block stopevent position-static">
          <a
            class="btn btn-light btn-icon rounded-circle indicator indicator-primary"
            href="#"
            role="button"
            id="dropdownNotificationSecond"
            data-bs-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false">
            <i class="fe fe-bell"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-end dropdown-menu-lg position-absolute mx-3 my-5" aria-labelledby="dropdownNotificationSecond">
            <div>
              <div class="border-bottom px-3 pb-3 d-flex align-items-center">
                <span class="h5 mb-0">Notifications</span>
                <a href="# ">
                  <span class="align-middle"><i class="fe fe-settings me-1"></i></span>
                </a>
              </div>
              <ul class="list-group list-group-flush" style="height: 300px" data-simplebar>
                <li class="list-group-item bg-light">
                  <div class="row">
                    <div class="col">
                      <a class="text-body" href="#">
                        <div class="d-flex">
                          <img src="/build/assets/images/avatar/avatar-1.jpg" alt="" class="avatar-md rounded-circle" />
                          <div class="ms-3">
                            <h5 class="fw-bold mb-1">Kristin Watson:</h5>
                            <p class="mb-3 text-body">Krisitn Watsan like your comment on course Javascript Introduction!</p>
                            <span class="fs-6">
                              <span>
                                <span class="fe fe-thumbs-up text-success me-1"></span>
                                2 hours ago,
                              </span>
                              <span class="ms-1">2:19 PM</span>
                            </span>
                          </div>
                        </div>
                      </a>
                    </div>
                    <div class="col-auto text-center me-2">
                      <a href="#" class="badge-dot bg-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Mark as read"></a>
                      <div>
                        <a href="#" class="bg-transparent" data-bs-toggle="tooltip" data-bs-placement="top" title="Remove">
                          <i class="fe fe-x"></i>
                        </a>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="list-group-item">
                  <div class="row">
                    <div class="col">
                      <a class="text-body" href="#">
                        <div class="d-flex">
                          <img src="/build/assets/images/avatar/avatar-2.jpg" alt="" class="avatar-md rounded-circle" />
                          <div class="ms-3">
                            <h5 class="fw-bold mb-1">Brooklyn Simmons</h5>
                            <p class="mb-3 text-body">Just launched a new Courses React for Beginner.</p>
                            <span class="fs-6">
                              <span>
                                <span class="fe fe-thumbs-up text-success me-1"></span>
                                Oct 9,
                              </span>
                              <span class="ms-1">1:20 PM</span>
                            </span>
                          </div>
                        </div>
                      </a>
                    </div>
                    <div class="col-auto text-center me-2">
                      <a href="#" class="badge-dot bg-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Mark as unread"></a>
                    </div>
                  </div>
                </li>
                <li class="list-group-item">
                  <div class="row">
                    <div class="col">
                      <a class="text-body" href="#">
                        <div class="d-flex">
                          <img src="/build/assets/images/avatar/avatar-3.jpg" alt="" class="avatar-md rounded-circle" />
                          <div class="ms-3">
                            <h5 class="fw-bold mb-1">Jenny Wilson</h5>
                            <p class="mb-3 text-body">Krisitn Watsan like your comment on course Javascript Introduction!</p>
                            <span class="fs-6">
                              <span>
                                <span class="fe fe-thumbs-up text-info me-1"></span>
                                Oct 9,
                              </span>
                              <span class="ms-1">1:56 PM</span>
                            </span>
                          </div>
                        </div>
                      </a>
                    </div>
                    <div class="col-auto text-center me-2">
                      <a href="#" class="badge-dot bg-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Mark as unread"></a>
                    </div>
                  </div>
                </li>
                <li class="list-group-item">
                  <div class="row">
                    <div class="col">
                      <a class="text-body" href="#">
                        <div class="d-flex">
                          <img src="/build/assets/images/avatar/avatar-4.jpg" alt="" class="avatar-md rounded-circle" />
                          <div class="ms-3">
                            <h5 class="fw-bold mb-1">Sina Ray</h5>
                            <p class="mb-3 text-body">You earn new certificate for complete the Javascript Beginner course.</p>
                            <span class="fs-6">
                              <span>
                                <span class="fe fe-award text-warning me-1"></span>
                                Oct 9,
                              </span>
                              <span class="ms-1">1:56 PM</span>
                            </span>
                          </div>
                        </div>
                      </a>
                    </div>
                    <div class="col-auto text-center me-2">
                      <a href="#" class="badge-dot bg-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Mark as unread"></a>
                    </div>
                  </div>
                </li>
              </ul>
              <div class="border-top px-3 pt-3 pb-0">
                <a href="dashboard-notification-history.php" class="text-link fw-semibold">See all Notifications</a>
              </div>
            </div>
          </div>
        </li>

        <li class="dropdown ms-2 d-inline-block position-static">
          <a class="rounded-circle" href="#" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
            <div class="avatar avatar-md avatar-indicators avatar-online">
              <img alt="avatar" src="/build/assets/images/avatar/avatar-1.jpg" class="rounded-circle" />
            </div>
          </a>
          <div class="dropdown-menu dropdown-menu-end position-absolute mx-3 my-5">
            <div class="dropdown-item">
              <div class="d-flex">
                <div class="avatar avatar-md avatar-indicators avatar-online">
                  <img alt="avatar" src="/build/assets/images/avatar/avatar-1.jpg" class="rounded-circle" />
                </div>
                <div class="ms-3 lh-1">
                  <h5 class="mb-1">Annette Black</h5>
                  <p class="mb-0">annette@geeksui.com</p>
                </div>
              </div>
            </div>
            <div class="dropdown-divider"></div>
            <ul class="list-unstyled">
              <li class="dropdown-submenu dropstart-lg">
                <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">
                  <i class="fe fe-circle me-2"></i>
                  Status
                </a>
                <ul class="dropdown-menu">
                  <li>
                    <a class="dropdown-item" href="#">
                      <span class="badge-dot bg-success me-2"></span>
                      Online
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="#">
                      <span class="badge-dot bg-secondary me-2"></span>
                      Offline
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="#">
                      <span class="badge-dot bg-warning me-2"></span>
                      Away
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="#">
                      <span class="badge-dot bg-danger me-2"></span>
                      Busy
                    </a>
                  </li>
                </ul>
              </li>
              <li>
                <a class="dropdown-item" href="profile-edit.php">
                  <i class="fe fe-user me-2"></i>
                  Profile
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="student-subscriptions.php">
                  <i class="fe fe-star me-2"></i>
                  Subscription
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="#">
                  <i class="fe fe-settings me-2"></i>
                  Settings
                </a>
              </li>
            </ul>
            <div class="dropdown-divider"></div>
            <ul class="list-unstyled">
                  <li>
                      <form method="POST" action="{{ route('logout') }}" class="w-100">
                          @csrf
                          <button type="submit" class="dropdown-item w-100 text-start">
                              <i class="fe fe-power me-2"></i>
                              Sign Out user
                          </button>
                      </form>
                  </li>
              </ul>
          </div>
        </li>
      </ul>
    </div>
    <div>
      <!-- Button -->
      <button
        class="navbar-toggler collapsed ms-2"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbar-default"
        aria-controls="navbar-default"
        aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="icon-bar top-bar mt-0"></span>
        <span class="icon-bar middle-bar"></span>
        <span class="icon-bar bottom-bar"></span>
      </button>
    </div>
    <!-- Collapse -->
    <div class="collapse navbar-collapse" id="navbar-default">
      <ul class="navbar-nav mt-3 mt-lg-0 mx-xxl-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarBrowse" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-bs-display="static">Categories</a>
          <ul class="dropdown-menu dropdown-menu-arrow" aria-labelledby="navbarBrowse">
            <li class="dropdown-submenu dropend">
              <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Web Development</a>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" href="pages-course-category.php">Bootstrap</a>
                </li>
                <li>
                  <a class="dropdown-item" href="pages-course-category.php">React</a>
                </li>
                <li>
                  <a class="dropdown-item" href="pages-course-category.php">GraphQl</a>
                </li>
                <li>
                  <a class="dropdown-item" href="pages-course-category.php">Gatsby</a>
                </li>
                <li>
                  <a class="dropdown-item" href="pages-course-category.php">Grunt</a>
                </li>
                <li>
                  <a class="dropdown-item" href="pages-course-category.php">Svelte</a>
                </li>
                <li>
                  <a class="dropdown-item" href="pages-course-category.php">Meteor</a>
                </li>
                <li>
                  <a class="dropdown-item" href="pages-course-category.php">HTML5</a>
                </li>
                <li>
                  <a class="dropdown-item" href="pages-course-category.php">Angular</a>
                </li>
              </ul>
            </li>
            <li class="dropdown-submenu dropend">
              <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Design</a>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" href="pages-course-category.php">Graphic Design</a>
                </li>
                <li>
                  <a class="dropdown-item" href="pages-course-category.php">Illustrator</a>
                </li>
                <li>
                  <a class="dropdown-item" href="pages-course-category.php">UX / UI Design</a>
                </li>
                <li>
                  <a class="dropdown-item" href="pages-course-category.php">Figma Design</a>
                </li>
                <li>
                  <a class="dropdown-item" href="pages-course-category.php">Adobe XD</a>
                </li>
                <li>
                  <a class="dropdown-item" href="pages-course-category.php">Sketch</a>
                </li>
                <li>
                  <a class="dropdown-item" href="pages-course-category.php">Icon Design</a>
                </li>
                <li>
                  <a class="dropdown-item" href="pages-course-category.php">Photoshop</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="pages-course-category.php" class="dropdown-item">Mobile App</a>
            </li>
            <li>
              <a href="pages-course-category.php" class="dropdown-item">IT Software</a>
            </li>
            <li>
              <a href="pages-course-category.php" class="dropdown-item">Marketing</a>
            </li>
            <li>
              <a href="pages-course-category.php" class="dropdown-item">Music</a>
            </li>
            <li>
              <a href="pages-course-category.php" class="dropdown-item">Life Style</a>
            </li>
            <li>
              <a href="pages-course-category.php" class="dropdown-item">Business</a>
            </li>
            <li>
              <a href="pages-course-category.php" class="dropdown-item">Photography</a>
            </li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarLanding" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Landings</a>
          <ul class="dropdown-menu" aria-labelledby="navbarLanding">
            <li>
              <h4 class="dropdown-header">Landings</h4>
            </li>
            <li>
              <a href="index.php" class="dropdown-item">
                <span>Home Default</span>
              </a>
            </li>
            <li>
              <a href="landing-abroad.php" class="dropdown-item">
                <span>Home Abroad</span>
              </a>
            </li>
            <li>
              <a href="mentor.php" class="dropdown-item">
                <span>Home Mentor</span>
              </a>
            </li>
            <li>
              <a href="landing-education.php" class="dropdown-item">Home Education</a>
            </li>
            <li>
              <a href="landing-home-academy.php" class="dropdown-item">Home Academy</a>
            </li>
            <li>
              <a href="landing-courses.php" class="dropdown-item">Home Courses</a>
            </li>
            <li>
              <a href="landing-sass.php" class="dropdown-item">Home Sass</a>
            </li>
            <li class="border-bottom my-2"></li>
            <li>
              <a href="landings-course-lead.php" class="dropdown-item">Lead Course</a>
            </li>
            <li>
              <a href="landings-request-access.php" class="dropdown-item">Request Access</a>
            </li>

            <li>
              <a href="landing-job.php" class="dropdown-item">Job Listing</a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="all-courses.php">All Courses</a>
        </li>
      </ul>
      <form class="mt-3 mt-lg-0 me-lg-5 d-flex align-items-center">
        <span class="position-absolute ps-3 search-icon">
          <i class="fe fe-search"></i>
        </span>
        <label for="search" class="visually-hidden"></label>
        <input type="search" id="search" class="form-control ps-6" placeholder="Search Courses" />
      </form>
    </div>
  </div>
</nav>
