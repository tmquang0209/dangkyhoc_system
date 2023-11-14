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
        Quản lý giảng viên
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
                        <li class="breadcrumb-item text-sm text-white active" aria-current="page">Quản lý giảng viên</li>
                    </ol>
                    <h6 class="font-weight-bolder text-white mb-0">Quản lý giảng viên</h6>
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
                                <p class="mb-0">Quản lý giảng viên</p>
                                <button class="btn btn-primary btn-sm ms-auto"> <a href="?add" style="color: white;">Thêm</a> </button>
                            </div>
                        </div>
                        <?php if (isset($_GET["update"])) {
                            include("../models/teacher.php");
                            $id = $_GET["update"];
                            $teacher = new Teacher();
                            $getInfo =  $teacher->getInfo($id);
                        ?>
                            <div class="card-body">
                                <p class="text-uppercase text-sm">Cập nhật thông tin giảng viên <?= $getInfo["teacher_name"] ?></p>
                                <div id="message"></div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label" id="teacherLabel">Mã nhân viên</label>
                                            <input class="form-control" type="text" value="<?= $getInfo["teacher_code"] ?>" id="teacherCode" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Họ và tên</label>
                                            <input class="form-control" type="text" value="<?= $getInfo["teacher_name"]; ?>" id="teacherName">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Ngày sinh</label>
                                            <input class="form-control" type="date" value="<?= $getInfo["birthday"]; ?>" id="birthday">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Địa chỉ</label>
                                            <input class="form-control" type="text" value="<?= $getInfo["address"]; ?>" id="address">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Email</label>
                                            <input class="form-control" type="text" value="<?= $getInfo["email"]; ?>" id="email">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Số điện thoại</label>
                                            <input class="form-control" type="text" value="<?= $getInfo["phone_number"]; ?>" id="mobileNumber">
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-sm ms-auto" id="updateBtn">Cập nhật</button>
                            </div>
                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                            <script>
                                var message = document.getElementById("message");
                                var teacherCode = document.getElementById("teacherCode");
                                var teacherCode = document.getElementById("teacherCode");
                                var teacherName = document.getElementById("teacherName");
                                var birthday = document.getElementById("birthday");
                                var address = document.getElementById("address");
                                var email = document.getElementById("email");
                                var mobileNumber = document.getElementById("mobileNumber");
                                var updateBtn = document.getElementById("updateBtn");

                                updateBtn.addEventListener("click", function(e) {
                                    const teacherCodeValue = teacherCode.value;
                                    const teacherNameValue = teacherName.value;
                                    const birthdayValue = birthday.value;
                                    const addressValue = address.value;
                                    const emailValue = email.value;
                                    const mobileNumberValue = mobileNumber.value;

                                    if (teacherCodeValue && teacherCodeValue && teacherNameValue && birthdayValue && addressValue && emailValue && mobileNumberValue) {
                                        $.post(`/controller/account.php?updateTeacher`, {
                                            teacherCode: teacherCodeValue,
                                            teacherName: teacherNameValue,
                                            birthday: birthdayValue,
                                            address: addressValue,
                                            email: emailValue,
                                            mobileNumber: mobileNumberValue,
                                        }, function(res) {
                                            console.log(res);
                                            message.innerHTML = `<div class="alert alert-success" role="alert">Cập nhật thông tin thành công.</div>`
                                            setTimeout(() => {
                                                location.href = "/views/teacher-manager.php"
                                            }, 1000)
                                        });
                                    } else {
                                        message.innerHTML = `<div class="alert alert-danger" role="alert">Vui lòng điền đầy đủ thông tin.</div>`
                                    }
                                });
                            </script>
                        <?php } ?>
                        <?php if (isset($_GET["add"])) { ?>
                            <div class="card-body">
                                <p class="text-uppercase text-sm">Thêm mới giảng viên</p>
                                <div id="message"></div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label" id="teacherLabel">Mã giảng viên</label>
                                            <input class="form-control" type="text" value="" id="teacherCode">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Họ và tên</label>
                                            <input class="form-control" type="text" value="" id="teacherName">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Mật khẩu</label>
                                            <input class="form-control" type="text" value="" id="password">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Ngày sinh</label>
                                            <input class="form-control" type="date" value="" id="birthday">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Địa chỉ</label>
                                            <input class="form-control" type="text" value="" id="address">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Email</label>
                                            <input class="form-control" type="text" value="" id="email">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Số điện thoại</label>
                                            <input class="form-control" type="text" value="" id="mobileNumber">
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-sm ms-auto" id="updateBtn">Thêm</button>
                            </div>
                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                            <script>
                                var message = document.getElementById("message");
                                var teacherCode = document.getElementById("teacherCode");
                                var teacherCode = document.getElementById("teacherCode");
                                var teacherName = document.getElementById("teacherName");
                                var password = document.getElementById("password");
                                var birthday = document.getElementById("birthday");
                                var address = document.getElementById("address");
                                var email = document.getElementById("email");
                                var mobileNumber = document.getElementById("mobileNumber");
                                var updateBtn = document.getElementById("updateBtn");

                                updateBtn.addEventListener("click", function(e) {
                                    const teacherCodeValue = teacherCode.value;
                                    const teacherNameValue = teacherName.value;
                                    const passwordValue = password.value;
                                    const birthdayValue = birthday.value;
                                    const addressValue = address.value;
                                    const emailValue = email.value;
                                    const mobileNumberValue = mobileNumber.value;

                                    if (teacherCodeValue && teacherCodeValue && teacherNameValue && passwordValue && birthdayValue && addressValue && emailValue && mobileNumberValue) {
                                        $.post(`/controller/account.php?addTeacher`, {
                                            teacherCode: teacherCodeValue,
                                            teacherName: teacherNameValue,
                                            password: passwordValue,
                                            birthday: birthdayValue,
                                            address: addressValue,
                                            email: emailValue,
                                            mobileNumber: mobileNumberValue,
                                        }, function(res) {
                                            console.log(res);
                                            message.innerHTML = `<div class="alert alert-success" role="alert">Cập nhật thông tin thành công.</div>`
                                            setTimeout(() => {
                                                location.href = "/views/teacher-manager.php"
                                            }, 1000)
                                        });
                                    } else {
                                        message.innerHTML = `<div class="alert alert-danger" role="alert">Vui lòng điền đầy đủ thông tin.</div>`
                                    }
                                });
                            </script>
                        <?php } ?>
                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group" style="margin-left:25px">
                                    <label for="example-text-input" class="form-control-label">Tìm kiếm nhân viên</label>
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
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Mã nhân viên</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tên nhân viên</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ngày sinh</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Email</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Số điện thoại</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Địa chỉ</th>
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
            $.post(`/controller/account.php?teacherList`).done(function(res) {
                console.log(res);
                const data = JSON.parse(res.trim()).result;

                data.forEach((item, i) => {
                    if (item.teacher_code.length > 2)
                        render(item, i);
                })
            });
        }

        function render(item, index) {
            // console.log(item);
            const html = `
            <tr>
                <td class="align-middle text-center">${index+1}</td>
                <td><p class="text-xs font-weight-bold mb-0">${item.teacher_code}</p></td>
                <td class="align-middle text-center text-sm">${item.teacher_name}</td>
                <td class="align-middle text-center text-sm">${item.birthday}</td>
                <td class="align-middle text-center text-sm">${item.email}</td>
                <td class="align-middle text-center text-sm">${item.phone_number}</td>
                <td class="align-middle text-center text-sm">${item.address}</td>

                <td class="align-middle">
                    <a href="?update=${item.teacher_code}" data-toggle="tooltip" data-original-title="Edit user">
                        <span class="badge badge-sm bg-gradient-warning">
                            Sửa
                        </span>
                    </a>
                    <br />
                    <a href="?del=${item.teacher_code}" data-toggle="tooltip" data-original-title="Edit user">
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
                td = tr[i].getElementsByTagName("td")[2];
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