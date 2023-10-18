<?php
// for student
session_start();
if (!isset($_SESSION["account"])) {
    header('Location: /views/sign-in.html');
    exit;
}
if (!isset($_SESSION["account"]["student_code"])) {
    header("Location: /");
    exit();
}
if (!isset($_GET["id"])) {
    header("Location: /views/fee.php");
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
        Học phí
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
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="/views/fee.php">Học phí</a></li>
                        <li class="breadcrumb-item text-sm text-white active" aria-current="page">Chi tiết học phí</li>
                    </ol>
                    <h6 class="font-weight-bolder text-white mb-0">Học phí</h6>
                </nav>
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                        <div class="input-group">
                            <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                            <input type="text" class="form-control" placeholder="Type here...">
                        </div>
                    </div>
                    <ul class="navbar-nav  justify-content-end">
                        <li class="nav-item d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-white font-weight-bold px-0">
                                <i class="fa fa-user me-sm-1"></i>
                                <span class="d-sm-inline d-none">Sign In</span>
                            </a>
                        </li>
                        <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line bg-white"></i>
                                    <i class="sidenav-toggler-line bg-white"></i>
                                    <i class="sidenav-toggler-line bg-white"></i>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item px-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-white p-0">
                                <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
                            </a>
                        </li>
                        <li class="nav-item dropdown pe-2 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-white p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-bell cursor-pointer"></i>
                            </a>
                            <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                            </ul>
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
                            <h6>Chi tiết hóa đơn</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <tbody>
                                        <tr>
                                            <td class="text-sm">Học kỳ</td>
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0" id="semesterName"></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-sm">
                                                Mã sinh viên
                                            </td>
                                            <td class="text-sm">
                                                <p class="text-sm font-weight-bold mb-0" id="studentCode"></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-sm">
                                                Họ tên
                                            </td>
                                            <td class="text-sm">
                                                <p class="text-sm font-weight-bold mb-0" id="studentName"></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-sm">
                                                Số tiền
                                            </td>
                                            <td class="text-sm">
                                                <p class="text-sm font-weight-bold mb-0" id="tuitionTotal"></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-sm">
                                                Trạng thái
                                            </td>
                                            <td class="text-sm">
                                                <p class="text-sm font-weight-bold mb-0" id="status"></p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-header pb-0">
                            <h6>Danh sách khoản thu</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">STT</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Mã môn</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tên môn</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tín chỉ</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Hệ số</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Giá tiền 1 tín</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Thành tiền</th>
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
        // console.log(id);
        const semesterName = document.getElementById("semesterName");
        const studentCode = document.getElementById("studentCode");
        const studentName = document.getElementById("studentName");
        const tuitionTotal = document.getElementById("tuitionTotal");
        const status = document.getElementById("status");
        const detail = document.getElementById("detail");

        $(document).ready(async function() {
            get();
        });

        function get() {
            $.post(`/controller/tuition.php?tuitionByID`, {
                id
            }).done(function(res) {
                const data = JSON.parse(res.trim());
                if (data.length === 0) location.href = "/views/tuition.php";
                const general = data.general;


                semesterName.innerText = `${general.semester_name} năm học ${general.year}`
                studentCode.innerText = general.student_code;
                studentName.innerText = general.student_name;
                tuitionTotal.innerText = general.total_tuition;
                status.innerText = general.status;

                const detailSubject = data.detail;
                detailSubject.forEach((item) => {
                    render(item);
                })
            });
        }

        function render(item) {
            // console.log(item);
            const html = `
            <tr>
                <td class="align-middle text-center">1</td>
                <td>${item.subject_code}</td>
                <td class="align-middle text-center">${item.subject_name}</td>
                <td class="align-middle text-center">${item.credits}</td>
                <td class="align-middle text-center">${item.coef}</td>
                <td class="align-middle text-center text-sm">${item.cash.toLocaleString('vi-VN',{
                                        style: 'currency',
                                        currency: 'VND',
                                    })}</td>
                <td class="align-middle text-center text-sm">${item.total.toLocaleString('vi-VN',{
                                        style: 'currency',
                                        currency: 'VND',
                                    })}</td>

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