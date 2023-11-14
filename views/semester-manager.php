<?php
session_start();
if (!isset($_SESSION["account"])) {
    header('Location: /views/sign-in.html');
    exit;
} else {
    if (!$_SESSION["account"]["staff_code"]) {
        header('Location: /');
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="/assets/img/favicon.png">
    <title>
        Quản lý kỳ học
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
    <?php require("header.php"); ?>
    <main class="main-content position-relative border-radius-lg ">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Trang</a></li>
                        <li class="breadcrumb-item text-sm text-white active" aria-current="page">Quản lý kỳ học</li>
                    </ol>
                    <h6 class="font-weight-bolder text-white mb-0">Quản lý kỳ học</h6>
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
                            <div class="d-flex align-items-center">
                                <p class="mb-0">Quản lý kỳ học</p>
                                <button class="btn btn-primary btn-sm ms-auto"> <a href="?add" style="color: white;">Thêm mới</a> </button>
                            </div>
                        </div>
                        <?php if (isset($_GET["add"])) { ?>
                            <div class="card-body">
                                <p class="text-uppercase text-sm">Thêm mới học kỳ</p>
                                <div id="message"></div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Học kỳ</label>
                                            <input class="form-control" type="text" value="" id="semesterName">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Năm học</label>
                                            <input class="form-control" type="text" value="" id="year">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Học phí 1 tín</label>
                                            <input class="form-control" type="number" value="" id="cash">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Bắt đầu đăng ký</label>
                                            <input class="form-control" type="date" value="" id="start">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Kết thúc đăng ký</label>
                                            <input class="form-control" type="date" value="" id="end">
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-sm ms-auto" id="updateBtn">Thêm mới</button>
                            </div>
                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                            <script>
                                var message = document.getElementById("message");
                                var semesterName = document.getElementById("semesterName");
                                var year = document.getElementById("year");
                                var cash = document.getElementById("cash");
                                var start = document.getElementById("start");
                                var end = document.getElementById("end");
                                var updateBtn = document.getElementById("updateBtn");
                                updateBtn.addEventListener("click", function(e) {
                                    const semesterNameValue = semesterName.value;
                                    const yearValue = year.value;
                                    const cashValue = cash.value;
                                    const startValue = start.value;
                                    const endValue = end.value;

                                    if (cashValue && semesterNameValue && yearValue) {
                                        $.post(`/controller/semester.php?add`, {
                                            semesterName: semesterNameValue,
                                            year: yearValue,
                                            cash: cashValue,
                                            start: startValue,
                                            end: endValue
                                        }, function(res) {
                                            console.log(res);
                                            message.innerHTML = `<div class="alert alert-success" role="alert">Thêm kỳ học mới thành công.</div>`
                                            setTimeout(() => {
                                                location.href = "/views/semester-manager.php"
                                            }, 1000)
                                        });
                                    } else {
                                        message.innerHTML = `<div class="alert alert-danger" role="alert">Vui lòng nhập đầy đủ thông tin.</div>`
                                    }
                                })
                            </script>
                        <?php } ?>
                        <?php if (isset($_GET["update"])) {
                            include("../models/semester.php");
                            $id = (int)$_GET["update"];
                            $semester = new Semester();
                            $getInfo =  $semester->getSemester($id);
                            // var_dump($getInfo);
                        ?>
                            <input hidden class="form-control" type="text" value="<?= $getInfo["semester_id"] ?>" id="semesterID">
                            <div class="card-body">
                                <p class="text-uppercase text-sm">Cập nhật đơn vị học phí <?= $getInfo["semester_name"] ?> năm học <?= $getInfo["year"]; ?></p>
                                <div id="message"></div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Học kỳ</label>
                                            <input class="form-control" type="text" value="<?= $getInfo["semester_name"] ?>" id="semesterName">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Năm học</label>
                                            <input class="form-control" type="text" value="<?= $getInfo["year"] ?>" id="year">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Học phí 1 tín</label>
                                            <input class="form-control" type="number" value="<?= $getInfo["cash"] ?>" id="cash">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Bắt đầu đăng ký</label>
                                            <input class="form-control" type="date" id="start" value="<?= $getInfo["start_date"] ;?>">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Kết thúc đăng ký</label>
                                            <input class="form-control" type="date" id="end" value="<?= $getInfo["end_date"] ;?>">
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-sm ms-auto" id="updateBtn">Cập nhật</button>
                            </div>
                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                            <script>
                                var message = document.getElementById("message");
                                var semesterName = document.getElementById("semesterName");
                                var year = document.getElementById("year");
                                var cash = document.getElementById("cash");
                                var start = document.getElementById("start");
                                var end = document.getElementById("end");
                                
                                var updateBtn = document.getElementById("updateBtn");
                                updateBtn.addEventListener("click", function(e) {
                                    const semesterID = document.getElementById("semesterID").value;
                                    const semesterNameValue = semesterName.value;
                                    const yearValue = year.value;
                                    const cashValue = cash.value;
                                    const startValue = start.value;
                                    const endValue = end.value;

                                    if (cashValue) {
                                        $.post(`/controller/semester.php?update`, {
                                            semesterID,
                                            semesterName: semesterNameValue,
                                            year: yearValue,
                                            cash: cashValue,
                                            start: startValue,
                                            end: endValue
                                        }, function(res) {
                                            console.log(res);
                                            message.innerHTML = `<div class="alert alert-success" role="alert">Cập nhật thông tin thành công.</div>`
                                            setTimeout(() => {
                                                location.href = "/views/semester-manager.php"
                                            }, 1000)
                                        });
                                    } else {
                                        message.innerHTML = `<div class="alert alert-danger" role="alert">Vui lòng nhập đầy đủ giá tiền.</div>`
                                    }
                                })
                            </script>
                        <?php } ?>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group" style="margin-left:25px">
                                    <label for="example-text-input" class="form-control-label">Tìm kiếm học kỳ</label>
                                    <input name="" class="form-control" id="subName" onkeyup="searchSubject()">
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">STT</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Học kỳ</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Số tiền 1 tín</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Bắt đầu đăng ký</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kết thúc đăng ký</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="list">

                                    </tbody>
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
        const semesterList = document.getElementById("list");
        $(document).ready(async function() {
            get();
        });

        function get() {
            $.post(`/controller/tuition.php?manager`).done(function(res) {
                console.log(res);
                const data = JSON.parse(res.trim()).result;

                data.forEach((item) => {
                    render(item);
                })
            });
        }

        function render(item) {
            console.log(item);
            const html = `
            <tr>
                <td class="align-middle text-center">${item.semester_id}</td>
                <td>
                    <p class="text-xs font-weight-bold mb-0">${item.semester_name} năm học ${item.year}</p>
                </td>
                <td class="align-middle text-center text-sm">
                    ${item.cash.toLocaleString('vi-VN',{
                        style: 'currency',
                        currency: 'VND',
                    })}
                </td>
<td>
                    <p class="text-xs font-weight-bold mb-0">${item.start_date}</p>
                </td>
                <td>
                    <p class="text-xs font-weight-bold mb-0">${item.end_date}</p>
                </td>
                <td class="align-middle">
                    <a href="/views/semester-manager.php?update=${item.semester_id}" data-toggle="tooltip" data-original-title="Edit user">
                        <span class="badge badge-sm bg-gradient-warning">
                            Sửa
                        </span>
                    </a>
                    <br />
                    <a href="/views/semester-manager-detail.php?id=${item.semester_id}" data-toggle="tooltip" data-original-title="Edit user">
                        <span class="badge badge-sm bg-gradient-danger">
                            Xóa
                        </span>
                    </a>
                </td>
            </tr>
            `
            semesterList.insertAdjacentHTML("beforeend", html);
        }

        function searchSubject() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("subName");
            filter = input.value.toUpperCase();
            table = document.getElementById("list");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
    <!--   Core JS Files   -->
    <?php
    include_once("footer.php");
    ?>

</body>

</html>