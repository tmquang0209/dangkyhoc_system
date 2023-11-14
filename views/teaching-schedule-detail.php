<?php
// for student
session_start();
if (!isset($_SESSION["account"])) {
    header('Location: /views/sign-in.html');
    exit;
}
if (!isset($_SESSION["account"]["teacher_code"]) && !isset($_SESSION["account"]["staff_code"])) {
    header("Location: /");
    exit();
}
if (!isset($_GET["id"])) {
    header("Location: /views/classroom-manager.php");
    exit();
}
$id = (int)$_GET["id"];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="/assets/img/favicon.png">
    <title>
        Chi tiết lớp học
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="/assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
</head>

<body class="g-sidenav-show   bg-gray-100">
    <div class="min-height-300 bg-primary position-absolute w-100"></div>
    <?php include_once("header.php"); ?>
    <main class="main-content position-relative border-radius-lg ">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="/">Trang</a></li>
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="/views/teaching-schedule.php" id="semester"></a></li>
                        <li class="breadcrumb-item text-sm text-white active" aria-current="page" id="classname"></li>
                    </ol>
                    <h6 class="font-weight-bolder text-white mb-0" id="des"></h6>
                </nav>
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                        <div class="input-group">
                            <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                            <input type="text" class="form-control" placeholder="Type here...">
                        </div>
                    </div>
                    <ul class="navbar-nav  justify-content-end" id="nav-profile">
                        <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                          <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                            <div class="sidenav-toggler-inner">
                              <i class="sidenav-toggler-line bg-white"></i>
                              <i class="sidenav-toggler-line bg-white"></i>
                              <i class="sidenav-toggler-line bg-white"></i>
                            </div>
                          </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>Danh sách sinh viên</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">STT</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Mã sinh viên</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Họ tên</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ngày sinh</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Lớp chuyên ngành</th>
                                        </tr>
                                    </thead>
                                    <tbody id="detail"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const id = <?= $id; ?>;
        const detail = document.getElementById("detail");
        const title = document.querySelector("title");
        const semester = document.getElementById("semester");
        const classname = document.getElementById("classname");
        const des = document.getElementById("des");

        $(document).ready(async function() {
            get();
        });

        function get() {
            $.post(`/controller/schedule.php?teachingScheduleDetail`, {
                id
            }).done(function(res) {
                console.log(res);
                const data = JSON.parse(res.trim());
                if (data.length === 0) location.href = "/views/teaching-schedule.php";
                const detailSubject = data.result;
                const info = detailSubject[0];
                title.innerText = info.class_name + " - " + info.semester
                semester.innerText = info.semester;
                classname.innerText = info.class_name;
                des.innerText = "Danh sách sinh viên đăng ký lớp " + info.class_name + " - " + info.semester;
                detailSubject.forEach((item, index) => {
                    render(item, index);
                })
            });
        }

        function render(item, index) {
            console.log(item);
            const html = `
            <tr>
                <td class="align-middle text-center">${index + 1}</td>
                <td>${item.student_code}</td>
                <td class="align-middle text-center">${item.student_name}</td>
                <td class="align-middle text-center">${item.birthday}</td>
                <td class="align-middle text-center">${item.classroom_code}</td>
            </tr>
            `
            detail.insertAdjacentHTML("beforeend", html);
        }
    </script>
    <?php
    include_once("footer.php");
    ?>

</body>

</html>