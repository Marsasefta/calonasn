<!-- navbar -->
<nav class="navbar navbar-expand-lg">
    <div class="container px-0">
        <a class="navbar-brand" href="index.php"><img src="/build/assets/images/brand/logo/logo.svg" alt="Geeks" style="height: 1.875rem" /></a>

        <div class="ms-lg-3 d-none d-md-none d-lg-block">
            <!-- Form -->
            <form class="d-flex align-items-center">
                <span class="position-absolute ps-3 search-icon">
                    <i class="fe fe-search"></i>
                </span>
                <input type="search" class="form-control ps-6" placeholder="Search Entire Dashboard" />
            </form>
        </div>

        <div class="ms-auto d-flex align-items-center">
            <div class="dropdown me-2">
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
            <ul class="navbar-nav navbar-right-wrap d-flex nav-top-wrap ms-2">
                <li class="dropdown stopevent">
                    <a
                        class="btn btn-light btn-icon rounded-circle indicator indicator-primary"
                        href="#"
                        role="button"
                        id="dropdownNotification"
                        data-bs-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false">
                        <i class="fe fe-bell"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-lg" aria-labelledby="dropdownNotification">
                        <div>
                            <div class="border-bottom px-3 pb-3 d-flex justify-content-between align-items-center">
                                <span class="h4 mb-0">Notifications</span>
                                <a href="# ">
                                    <span class="align-middle">
                                        <i class="fe fe-settings me-1"></i>
                                    </span>
                                </a>
                            </div>
                            <!-- List group -->
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
                <!-- List -->
                <li class="dropdown ms-2">
                    <a class="rounded-circle" href="#" role="button" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="avatar avatar-md avatar-indicators avatar-online">
                            <img alt="avatar" src="/build/assets/images/avatar/avatar-1.jpg" class="rounded-circle" />
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
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
                                <a class="dropdown-item" href="index.php">
                                    <i class="fe fe-power me-2"></i>
                                    Sign Out
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
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
</nav>

<nav class="navbar navbar-expand-lg navbar-default py-0 py-lg-2">
    <div class="container px-0">
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="navbar-default">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDashboard" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-bs-display="static">Dashboard</a>
                    <ul class="dropdown-menu dropdown-menu-arrow" aria-labelledby="navbarDashboard">
                        <li>
                            <a class="dropdown-item" href="dashboard-admin-dashboard.php">Overview</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="dashboard-dashboard-analytics.php">Analytics</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarPages" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Pages</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarPages">
                        <li class="dropdown-submenu dropend">
                            <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Courses</a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="dashboard-admin-course-overview.php" class="dropdown-item">All Courses</a>
                                </li>
                                <li>
                                    <a href="dashboard-admin-course-category.php" class="dropdown-item">Course Category</a>
                                </li>
                                <li>
                                    <a href="dashboard-admin-course-category-single.php" class="dropdown-item">Category Single</a>
                                </li>
                            </ul>
                        </li>

                        <li class="dropdown-submenu dropend">
                            <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Users</a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="dashboard-admin-instructor.php" class="dropdown-item">Instructor</a>
                                </li>
                                <li>
                                    <a href="dashboard-admin-students.php" class="dropdown-item">Students</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown-submenu dropend">
                            <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">CMS</a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="dashboard-admin-cms-overview.php" class="dropdown-item">Overview</a>
                                </li>
                                <li>
                                    <a href="dashboard-admin-cms-post.php" class="dropdown-item">All Post</a>
                                </li>
                                <li>
                                    <a href="dashboard-admin-cms-post-new.php" class="dropdown-item">New Post</a>
                                </li>
                                <li>
                                    <a href="dashboard-admin-cms-post-category.php" class="dropdown-item">Category</a>
                                </li>
                            </ul>
                        </li>

                        <li class="dropdown-submenu dropend">
                            <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Project</a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="dashboard-project-grid.php">Grid</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="dashboard-project-list.php">List</a>
                                </li>

                                <li class="dropdown-submenu dropend">
                                    <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Single</a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="dashboard-project-overview.php">Overview</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="dashboard-project-task.php">Task</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="dashboard-project-budget.php">Budget</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="dashboard-project-team.php">Team</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="dashboard-project-files.php">Files</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="dashboard-project-summary.php">Summary</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="dashboard-add-project.php">Create Project</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown-submenu dropend">
                            <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Site Setting</a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="dashboard-setting-general.php">General</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="dashboard-setting-google.php">google</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="dashboard-setting-social.php">Social</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="dashboard-setting-social-login.php">Social Login</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="dashboard-setting-payment.php">Payment</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="dashboard-setting-smpt.php">SMPT</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarApps" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Apps</a>
                    <ul class="dropdown-menu dropdown-menu-arrow" aria-labelledby="navbarApps">
                        <li>
                            <a class="dropdown-item" href="dashboard-chat-app.php">Chat</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="dashboard-task-kanban.php">Task</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="dashboard-mail.php">Mail</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="dashboard-calendar.php">Calendar</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarAuthentication" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Authentication</a>
                    <ul class="dropdown-menu dropdown-menu-arrow" aria-labelledby="navbarAuthentication">
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
                            <a class="dropdown-item" href="dashboard-notification-history.php">Notifications</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="404-error.php">404 Error</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="ecommerceDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Ecommerce</a>
                    <ul class="dropdown-menu dropdown-menu-arrow" aria-labelledby="ecommerceDropdown">
                        <li><span class="dropdown-header">Ecommerce</span></li>
                        <li class="dropdown-submenu dropend">
                            <a class="dropdown-item dropdown-toggle d-flex justify-content-between" href="#">Products</a>
                            <ul class="dropdown-menu">
                                <li class="nav-item">
                                    <a class="dropdown-item" href="dashboard-ecommerce/product-grid.php">Grid</a>
                                </li>
                                <li class="nav-item">
                                    <a class="dropdown-item" href="dashboard-ecommerce/product-grid-with-sidebar.php">Grid Sidebar</a>
                                </li>
                                <li class="nav-item">
                                    <a class="dropdown-item" href="dashboard-ecommerce/products.php">Products</a>
                                </li>
                                <li class="nav-item">
                                    <a class="dropdown-item" href="dashboard-ecommerce/product-single.php">Product Single</a>
                                </li>
                                <li class="nav-item">
                                    <a class="dropdown-item" href="dashboard-ecommerce/product-single-v2.php">Product Single v2</a>
                                </li>
                                <li class="nav-item">
                                    <a class="dropdown-item" href="dashboard-ecommerce/add-product.php">Add Product</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="dropdown-item" href="ecommerce-shopping-cart.php">Shopping Cart</a>
                        </li>
                        <li class="nav-item">
                            <a class="dropdown-item" href="ecommerce-checkout.php">Checkout</a>
                        </li>
                        <li class="nav-item">
                            <a class="dropdown-item" href="ecommerce-order.php">Order</a>
                        </li>
                        <li class="nav-item">
                            <a class="dropdown-item" href="ecommerce-order-single.php">Order Single</a>
                        </li>
                        <li class="nav-item">
                            <a class="dropdown-item" href="ecommerce-order-history.php">Order History</a>
                        </li>
                        <li class="nav-item">
                            <a class="dropdown-item" href="ecommerce-order-summary.php">Order Summary</a>
                        </li>

                        <li class="nav-item">
                            <a class="dropdown-item" href="ecommerce-customers.php">Customers</a>
                        </li>
                        <li class="nav-item">
                            <a class="dropdown-item" href="ecommerce-customer-single.php">Customer Single</a>
                        </li>
                        <li class="nav-item">
                            <a class="dropdown-item" href="ecommerce-add-customer.php">Add Customer</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="layoutsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Layouts</a>
                    <ul class="dropdown-menu dropdown-menu-start" aria-labelledby="layoutsDropdown">
                        <li><span class="dropdown-header">Layouts</span></li>

                        <li class="nav-item">
                            <a class="dropdown-item" href="layout-horizontal.php">Top</a>
                        </li>
                        <li class="nav-item">
                            <a class="dropdown-item" href="layout-compact.php">Compact</a>
                        </li>
                        <li class="nav-item">
                            <a class="dropdown-item" href="layout-vertical.php">Vertical</a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarTables" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Tables</a>
                    <ul class="dropdown-menu dropdown-menu-arrow" aria-labelledby="navbarTables">
                        <li>
                            <a class="dropdown-item" href="dashboard-basic-table.php">Basic</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="dashboard-datatables.php">Datatables</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                            <a class="list-group-item list-group-item-action border-0" href="https://coderthemes.com/geeks-rtl/" target="_blank">
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
