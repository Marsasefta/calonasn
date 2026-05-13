<!-- navbar login -->
<nav class="navbar navbar-expand-lg">
  <div class="container px-0">
    <a class="navbar-brand" href="index.php"><img src="/build/assets/images/brand/logo/logo.svg" alt="Geeks" /></a>
    <div class="d-flex align-items-center order-lg-3">
      <div class="d-flex align-items-center">
        <div class="dropdown me-2">
          <button class="btn btn-light btn-icon rounded-circle d-flex align-items-center" type="button"
            aria-expanded="false" data-bs-toggle="dropdown" aria-label="Toggle theme (auto)">
            <i class="bi theme-icon-active"></i>
            <span class="visually-hidden bs-theme-text">Toggle theme</span>
          </button>
          <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bs-theme-text">
            <li>
              <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light"
                aria-pressed="false">
                <i class="bi theme-icon bi-sun-fill"></i>
                <span class="ms-2">Light</span>
              </button>
            </li>
            <li>
              <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark"
                aria-pressed="false">
                <i class="bi theme-icon bi-moon-stars-fill"></i>
                <span class="ms-2">Dark</span>
              </button>
            </li>
            <li>
              <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto"
                aria-pressed="true">
                <i class="bi theme-icon bi-circle-half"></i>
                <span class="ms-2">Auto</span>
              </button>
            </li>
          </ul>
        </div>
        <div class="d-none d-md-block me-2">
          <a href="https://themes.getbootstrap.com/product/geeks-academy-admin-template/" class="btn btn-primary">Buy
            Now</a>
        </div>
      </div>
      <div>
        <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
          data-bs-target="#navbar-default" aria-controls="navbar-default" aria-expanded="false"
          aria-label="Toggle navigation">
          <span class="icon-bar top-bar mt-0"></span>
          <span class="icon-bar middle-bar"></span>
          <span class="icon-bar bottom-bar"></span>
        </button>
      </div>
    </div>
    <!-- Button -->

    <!-- Collapse -->
    <div class="collapse navbar-collapse" id="navbar-default">
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarLanding" data-bs-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">Landings</a>
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
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarPages" data-bs-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">Pages</a>
          <ul class="dropdown-menu dropdown-menu-arrow" aria-labelledby="navbarPages">
            <li class="dropdown-submenu dropend">
              <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Courses</a>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" href="course-filter-grid.php">
                    Course Grid

                  </a>
                </li>
                <li>
                  <a class="dropdown-item" href="course-filter-list.php">
                    Course List

                  </a>
                </li>
                <li class="border-bottom my-2"></li>

                <li>
                  <a class="dropdown-item" href="pages-course-category.php">Course Category v1</a>
                </li>
                <li>
                  <a class="dropdown-item" href="course-category-v2.php">
                    Course Category v2

                  </a>
                </li>
                <li class="border-bottom my-2"></li>

                <li>
                  <a class="dropdown-item" href="course-single.php">Course Single v1</a>
                </li>
                <li>
                  <a class="dropdown-item" href="course-single-v2.php">Course Single v2</a>
                </li>
                <li>
                  <a class="dropdown-item" href="course-single-v3.php">
                    Course Single v3

                  </a>
                </li>
                <li class="border-bottom my-2"></li>
                <li>
                  <a class="dropdown-item" href="course-resume.php">Course Resume</a>
                </li>
                <li>
                  <a class="dropdown-item" href="course-checkout.php">Course Checkout</a>
                </li>
                <li>
                  <a class="dropdown-item" href="add-course.php">Add New Course</a>
                </li>
              </ul>
            </li>
            <li>
              <a class="dropdown-item" href="dashboard-project.php">Projects
                <span class="badge bg-primary ms-2">New</span>
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="dashboard-quiz.php">Quizzes
                <span class="badge bg-primary ms-2">New</span>
              </a>
            </li>
            <li class="dropdown-submenu dropend">
              <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Paths</a>
              <ul class="dropdown-menu">
                <li>
                  <a href="course-path.php" class="dropdown-item">Browse Path</a>
                </li>
                <li>
                  <a href="course-path-single.php" class="dropdown-item">Path Single</a>
                </li>
              </ul>
            </li>
            <li class="dropdown-submenu dropend">
              <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Blog</a>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" href="blog.php">Listing</a>
                </li>
                <li>
                  <a class="dropdown-item" href="blog-single.php">Article</a>
                </li>
                <li>
                  <a class="dropdown-item" href="blog-category.php">Category</a>
                </li>
                <li>
                  <a class="dropdown-item" href="blog-sidebar.php">Sidebar</a>
                </li>
              </ul>
            </li>

            <li class="dropdown-submenu dropend">
              <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Career</a>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" href="career.php">Overview</a>
                </li>
                <li>
                  <a class="dropdown-item" href="career-list.php">Listing</a>
                </li>
                <li>
                  <a class="dropdown-item" href="career-single.php">Opening</a>
                </li>
              </ul>
            </li>
            <li class="dropdown-submenu dropend">
              <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Portfolio</a>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" href="portfolio.php">List</a>
                </li>
                <li>
                  <a class="dropdown-item" href="portfolio-single.php">Single</a>
                </li>
              </ul>
            </li>
            <li class="dropdown-submenu dropend">
              <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">
                <span>Mentor</span>
              </a>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" href="mentor.php">Home</a>
                </li>
                <li>
                  <a class="dropdown-item" href="mentor-list.php">List</a>
                </li>
                <li>
                  <a class="dropdown-item" href="mentor-single.php">Single</a>
                </li>
              </ul>
            </li>
            <li class="dropdown-submenu dropend">
              <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Job</a>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" href="landing-job.php">Home</a>
                </li>
                <li>
                  <a class="dropdown-item" href="job-listing.php">List</a>
                </li>
                <li>
                  <a class="dropdown-item" href="job-grid.php">Grid</a>
                </li>
                <li>
                  <a class="dropdown-item" href="job-single.php">Single</a>
                </li>
                <li>
                  <a class="dropdown-item" href="company-list.php">Company List</a>
                </li>
                <li>
                  <a class="dropdown-item" href="company-about.php">Company Single</a>
                </li>
              </ul>
            </li>
            <li class="dropdown-submenu dropend">
              <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Specialty</a>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" href="coming-soon.php">Coming Soon</a>
                </li>
                <li>
                  <a class="dropdown-item" href="404-error.php">Error 404</a>
                </li>
                <li>
                  <a class="dropdown-item" href="maintenance-mode.php">Maintenance Mode</a>
                </li>
                <li>
                  <a class="dropdown-item" href="terms-condition-page.php">Terms & Conditions</a>
                </li>
              </ul>
            </li>
            <li>
              <hr class="mx-3" />
            </li>

            <li>
              <a class="dropdown-item" href="about.php">About</a>
            </li>

            <li class="dropdown-submenu dropend">
              <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Help Center</a>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" href="help-center.php">Help Center</a>
                </li>
                <li>
                  <a class="dropdown-item" href="help-center-faq.php">FAQ's</a>
                </li>
                <li>
                  <a class="dropdown-item" href="help-center-guide.php">Guide</a>
                </li>
                <li>
                  <a class="dropdown-item" href="help-center-guide-single.php">Guide Single</a>
                </li>
                <li>
                  <a class="dropdown-item" href="help-center-support.php">Support</a>
                </li>
              </ul>
            </li>
            <li>
              <a class="dropdown-item" href="pricing.php">Pricing</a>
            </li>
            <li>
              <a class="dropdown-item" href="compare-plan.php">Compare Plan</a>
            </li>

            <li>
              <a class="dropdown-item" href="contact.php">Contact</a>
            </li>
            <li class="dropdown-submenu dropend">
              <a class="dropdown-item dropdown-toggle" href="#">Dropdown levels</a>
              <ul class="dropdown-menu dropdown-menu-start" data-bs-popper="none">
                <li><a class="dropdown-item" href="#">Dropdown item</a></li>
                <li><a class="dropdown-item" href="#">Dropdown item</a></li>
                <li><a class="dropdown-item" href="#">Dropdown item</a></li>
                <!-- dropdown submenu open right -->
                <li class="dropdown-submenu dropend">
                  <a class="dropdown-item dropdown-toggle" href="#">Dropdown (end)</a>
                  <ul class="dropdown-menu" data-bs-popper="none">
                    <li><a class="dropdown-item" href="#">Dropdown item</a></li>
                    <li><a class="dropdown-item" href="#">Dropdown item</a></li>
                  </ul>
                </li>

                <!-- dropdown submenu open left -->
                <li class="dropdown-submenu dropstart">
                  <a class="dropdown-item dropdown-toggle" href="#">Dropdown (start)</a>
                  <ul class="dropdown-menu" data-bs-popper="none">
                    <li><a class="dropdown-item" href="#">Dropdown item</a></li>
                    <li><a class="dropdown-item" href="#">Dropdown item</a></li>
                  </ul>
                </li>
              </ul>
            </li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarAccount" data-bs-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">Accounts</a>
          <ul class="dropdown-menu dropdown-menu-arrow" aria-labelledby="navbarAccount">
            <li>
              <h4 class="dropdown-header">Accounts</h4>
            </li>
            <li class="dropdown-submenu dropend">
              <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Instructor
                <span class="badge bg-primary ms-2">New</span>
              </a>
              <ul class="dropdown-menu">
                <li class="text-wrap">
                  <h5 class="dropdown-header text-dark">Instructor</h5>
                  <p class="dropdown-text mb-0">Instructor dashboard for manage courses and earning.</p>
                </li>
                <li>
                  <hr class="mx-3" />
                </li>
                <li>
                  <a class="dropdown-item" href="dashboard-instructor.php">Dashboard</a>
                </li>
                <li>
                  <a class="dropdown-item" href="instructor-profile.php">Profile</a>
                </li>
                <li>
                  <a class="dropdown-item" href="instructor-courses.php">My Courses</a>
                </li>
                <li>
                  <a class="dropdown-item" href="instructor-order.php">Orders</a>
                </li>
                <li>
                  <a class="dropdown-item" href="instructor-reviews.php">Reviews</a>
                </li>
                <li>
                  <a class="dropdown-item" href="instructor-students.php">Students</a>
                </li>
                <li>
                  <a class="dropdown-item" href="instructor-payouts.php">Payouts</a>
                </li>
                <li>
                  <a class="dropdown-item" href="instructor-earning.php">Earning</a>
                </li>
                <li class="dropdown-submenu dropend">
                  <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Quiz</a>
                  <ul class="dropdown-menu">
                    <li>
                      <a class="dropdown-item" href="instructor-quiz.php">Quiz</a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="instructor-quiz-details.php">Single</a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="instructor-quiz-result.php">Result</a>
                    </li>
                  </ul>
                </li>
              </ul>
            </li>
            <li class="dropdown-submenu dropend">
              <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Students
                <span class="badge bg-primary ms-2">New</span>
              </a>
              <ul class="dropdown-menu">
                <li class="text-wrap">
                  <h5 class="dropdown-header text-dark">Students</h5>
                  <p class="dropdown-text mb-0">Students dashboard to manage your courses and subscriptions.</p>
                </li>
                <li>
                  <hr class="mx-3" />
                </li>
                <li>
                  <a class="dropdown-item" href="dashboard-student.php">Dashboard</a>
                </li>
                <li>
                  <a class="dropdown-item" href="student-subscriptions.php">Subscriptions</a>
                </li>
                <li>
                  <a class="dropdown-item" href="payment-method.php">Payments</a>
                </li>
                <li>
                  <a class="dropdown-item" href="billing-info.php">Billing Info</a>
                </li>
                <li class="dropdown-submenu dropend">
                  <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Invoice</a>
                  <ul class="dropdown-menu">
                    <li>
                      <a class="dropdown-item" href="invoice.php">Invoice</a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="invoice-details.php">Invoice Details</a>
                    </li>
                  </ul>
                </li>


                <li>
                  <a class="dropdown-item" href="dashboard-student.php">Bookmarked</a>
                </li>
                <li>
                  <a class="dropdown-item" href="dashboard-student.php">My Path</a>
                </li>
                <li>
                  <a class="dropdown-item" href="all-courses.php">All Courses</a>
                </li>
                <li>
                  <a class="dropdown-item" href="learning-path.php">Learning Path</a>
                </li>

                <li class="dropdown-submenu dropend">
                  <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Quiz</a>
                  <ul class="dropdown-menu">
                    <li>
                      <a class="dropdown-item" href="quiz-blank.php">Quiz Blank</a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="my-quiz.php">My Quiz</a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="student-quiz-attempt.php">Quiz Attempt</a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="student-quiz-start.php">Quiz Single</a>
                    </li>

                    <li>
                      <a class="dropdown-item" href="quiz-result.php">Quiz Result</a>
                    </li>
                  </ul>
                </li>
                <li class="dropdown-submenu dropend">
                  <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Certificate</a>
                  <ul class="dropdown-menu">
                    <li>
                      <a class="dropdown-item" href="certificate-blank.php">Certificate</a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="my-certificate.php">My Certificate</a>
                    </li>
                  </ul>
                </li>
                <li class="dropdown-submenu dropend">
                  <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Learning</a>
                  <ul class="dropdown-menu">
                    <li>
                      <a class="dropdown-item" href="my-learning.php">My Learning</a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="learning-single.php">Learning Single</a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="learning-path-single.php">Learning Path Single</a>
                    </li>
                  </ul>
                </li>
                <li class="dropdown-submenu dropend">
                  <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">My Projects</a>
                  <ul class="dropdown-menu">
                    <li>
                      <a class="dropdown-item" href="project-blank.php">Project Blank</a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="dashboard-project.php">Dashboard Project</a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="project-single.php">Project Single</a>
                    </li>
                  </ul>
                </li>
              </ul>
            </li>
            <li class="dropdown-submenu dropend">
              <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Admin</a>
              <ul class="dropdown-menu">
                <li class="text-wrap">
                  <h5 class="dropdown-header text-dark">Master Admin</h5>
                  <p class="dropdown-text mb-0">Master admin dashboard to manage courses, user, site setting , and work
                    with amazing apps.</p>
                </li>
                <li>
                  <hr class="mx-3" />
                </li>
                <li class="px-3 d-grid">
                  <a href="dashboard-admin-dashboard.php" class="btn btn-sm btn-primary">Go to Dashboard</a>
                </li>
              </ul>
            </li>
            <li>
              <hr class="mx-3" />
            </li>
            <li>
              <a class="dropdown-item" href="sign-in.php">Sign In</a>
            </li>
            <li>
              <a class="dropdown-item" href="sign-up.php">Sign Up</a>
            </li>
            <li>
              <a class="dropdown-item" href="forget-password.php">Forgot Password</a>
            </li>
            <li>
              <a class="dropdown-item" href="profile-edit.php">Edit Profile</a>
            </li>
            <li>
              <a class="dropdown-item" href="security.php">Security</a>
            </li>
            <li>
              <a class="dropdown-item" href="social-profile.php">Social Profiles</a>
            </li>
            <li>
              <a class="dropdown-item" href="notifications.php">Notifications</a>
            </li>
            <li>
              <a class="dropdown-item" href="profile-privacy.php">Privacy Settings</a>
            </li>
            <li>
              <a class="dropdown-item" href="delete-profile.php">Delete Profile</a>
            </li>
            <li>
              <a class="dropdown-item" href="linked-accounts.php">Linked Accounts</a>
            </li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
            <i class="fe fe-more-horizontal"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-md" aria-labelledby="navbarDropdown">
            <div class="list-group">
              <a class="list-group-item list-group-item-action border-0" href="docs-index.php">
                <div class="d-flex align-items-center">
                  <i class="fe fe-file-text fs-3 text-primary"></i>
                  <div class="ms-3">
                    <h5 class="mb-0">Documentations</h5>
                    <p class="mb-0 fs-6">Browse the all documentation</p>
                  </div>
                </div>
              </a>
              <a class="list-group-item list-group-item-action border-0" href="docs-bootstrap-5-snippets.php">
                <div class="d-flex align-items-center">
                  <i class="bi bi-files fs-3 text-primary"></i>
                  <div class="ms-3">
                    <h5 class="mb-0">Snippet</h5>
                    <p class="mb-0 fs-6">Bunch of Snippet</p>
                  </div>
                </div>
              </a>
              <a class="list-group-item list-group-item-action border-0" href="docs-changelog.php">
                <div class="d-flex align-items-center">
                  <i class="fe fe-layers fs-3 text-primary"></i>
                  <div class="ms-3">
                    <h5 class="mb-0">
                      Changelog
                      <span class="text-primary ms-1" id="changelog"></span>
                    </h5>
                    <p class="mb-0 fs-6">See what's new</p>
                  </div>
                </div>
              </a>
              <a class="list-group-item list-group-item-action border-0"
                href="https://coderthemes.com/geeks-rtl/" target="_blank">
                <div class="d-flex align-items-center">
                  <i class="fe fe-toggle-right fs-3 text-primary"></i>
                  <div class="ms-3">
                    <h5 class="mb-0">RTL demo</h5>
                    <p class="mb-0 fs-6">RTL Pages</p>
                  </div>
                </div>
              </a>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>