<?php
session_start();
if (!isset($_SESSION["account"])) {
    header('Location: /views/sign-in.html');
    exit;
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
        Thông tin cá nhân
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
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Trang</a></li>
                        <li class="breadcrumb-item text-sm text-white active" aria-current="page">Thông tin cá nhân</li>
                    </ol>
                    <h6 class="font-weight-bolder text-white mb-0">Thông tin cá nhân</h6>
                </nav>
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                        <div class="input-group">
                            <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                            <input type="text" class="form-control" placeholder="Type here...">
                        </div>
                    </div>
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
                                <p class="mb-0">Chỉnh sửa thông tin</p>
                                <!-- <button class="btn btn-primary btn-sm ms-auto">Settings</button> -->
                            </div>
                        </div>

                        <div class="card-body">
                            <p class="text-uppercase text-sm">Thông tin cá nhân</p>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label" id="studentLabel">Mã sinh viên</label>
                                        <input class="form-control" type="text" value="" id="studentCode" disabled>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Họ và tên</label>
                                        <input class="form-control" type="email" value="" id="studentName" disabled>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Ngày sinh</label>
                                        <input class="form-control" type="text" value="" id="birthday" disabled>
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
                                        <input class="form-control" type="text" value="" id="email" disabled>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Số điện thoại</label>
                                        <input class="form-control" type="text" value="" id="mobileNumber">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Lớp học phần</label>
                                        <input class="form-control" type="text" value="" id="classroom" disabled>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Cố vấn học tập</label>
                                        <input class="form-control" type="text" value="" id="teacherName" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        const studentCode = document.getElementById("studentCode");
        const studentName = document.getElementById("studentName");
        const birthday = document.getElementById("birthday");
        const address = document.getElementById("address");
        const phoneNumber = document.getElementById("mobileNumber")
        const email = document.getElementById("email");
        const classroom = document.getElementById("classroom");
        const teacherName = document.getElementById("teacherName");

        $(document).ready(function() {
            getInfo(function(info) {
                console.table(info);
                studentCode.value = info.staff_code || info.teacher_code || info.student_code;
                studentName.value = info.staff_name || info.teacher_name || info.student_name;
                birthday.value = info.birthday;
                address.value = info.address;
                // email.value = info.email;
                phoneNumber.value = info.phone_number;
                classroom.value = info.classroom_code;
                teacherName.value = info.consultant_code + " " + info.consultant_name;
            });
        });

        address.addEventListener("change", function() {
            update();
        })

        phoneNumber.addEventListener("change", function() {
            update();
        })

        const getInfo = (callback) => {
            $.post(`/controller/account.php?getInfo`).done(function(res) {
                const info = JSON.parse(res.trim());
                console.log(info);
                callback(info);
            });
        }

        const update = () => {
            $.post(`/controller/account.php?updateInfo`, {
                address: address.value,
                phoneNumber: phoneNumber.value
            }).done(function(res) {
                console.log("Change success");
            }).fail(function(err) {
                console.error(err);
            });
        }
    </script>
    <!--   Core JS Files   -->
    <?php
    include_once("footer.php");
    ?>

</body>

</html>