<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="/" target="_blank">
            <img src="/assets/img/logo-ct-dark.png" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold">Đăng ký học</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link active" href="/">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Trang chủ</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="/views/school-schedule.php">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Thời khóa biểu toàn trường</span>
                </a>
            </li>
            <?php if (isset($_SESSION["account"]["student_code"])) { ?>
                <li class="nav-item">
                    <a class="nav-link " href="/views/tuition.php">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-credit-card text-success text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Học phí</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="/views/schedule-register.php">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa fa-calendar-plus-o text-info text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Đăng ký học</span>
                    </a>
                </li>
            <?php } ?>
            <?php if (isset($_SESSION["account"]["teacher_code"])) { ?>
                <li class="nav-item">
                    <a class="nav-link " href="/views/teaching-schedule.php">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa fa-calendar-o text-success text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Quản lý lớp học</span>
                    </a>
                </li>
            <?php } ?>
            <?php if (isset($_SESSION["account"]["staff_code"])) { ?>
                <li class="nav-item">
                    <a class="nav-link " href="/views/subject-manager.php">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa fa-calendar-o text-success text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Quản lý môn học</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="/views/staff-manager.php">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa fa-users text-danger text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Quản lý nhân sự</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="/views/teacher-manager.php">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa fa-users text-danger text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Quản lý giảng viên</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="/views/student-manager.php">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa fa-users text-danger text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Quản lý sinh viên</span>
                    </a>
                </li>
                <!-- set admin -->
                <li class="nav-item">
                    <a class="nav-link " href="/views/tuition-manager.php">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa fa-credit-card text-warning text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Quản lý học phí</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="/views/schedule-manager.php">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa fa-calendar-o text-danger text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Quản lý thời khóa biểu</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="/views/semester-manager.php">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa fa-calendar-o text-danger text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Quản lý học kỳ</span>
                    </a>
                </li>
                <!-- end set admin -->
            <?php } ?>
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Account pages</h6>
            </li>
            <?php if (isset($_SESSION["account"])) { ?>
                <li class="nav-item">
                    <a class="nav-link " href="/views/profile.php">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Thông tin cá nhân</span>
                    </a>
                </li>
            <?php }
            if (isset($_SESSION["account"]["student_code"])) {
            ?>
                <li class="nav-item">
                    <a class="nav-link " href="/views/schedule-personal.php">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-calendar-grid-58 text-success text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Thời khóa biểu cá nhân</span>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
</aside>