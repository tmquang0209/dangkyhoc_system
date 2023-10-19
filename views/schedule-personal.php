<?php
session_start();
include_once __DIR__ . "/../models/semester.php";
if (!isset($_SESSION["account"])) {
    header('Location: /views/sign-in.html');
    exit;
} else {
    if (!$_SESSION["account"]["student_code"]) {
        header('Location: /');
        exit;
    }
}
$semester = new Semester();
$semesterInfo = $semester->getSemesterList();
if (isset($_GET["semester_id"])) {
    $semesterDetail = $semester->getSemester($_GET["semester_id"]);
    $title = $semesterDetail["semester_name"] . " năm học " . $semesterDetail["year"];
} else {
    $title = "";
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
        Thời khóa biểu cá nhân
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .title {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            color: red;
        }

        table td {
            width: 100px;
            word-break: break-word;
            overflow-wrap: break-word;
        }

        table th {
            width: 100px;
        }

        .loading-result {
            width: 100%;
            display: fixed;
            margin: auto;
            padding: 10px 50px;
        }

        .hidden {
            display: none;
        }

        table .sub {
            background-color: yellow;
            vertical-align: middle;
            text-align: center;
            margin: 10px;
        }
    </style>
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
                        <li class="breadcrumb-item text-sm text-white active" aria-current="page">Thời khóa biểu cá nhân</li>
                    </ol>
                    <h6 class="font-weight-bolder text-white mb-0"><?= $title; ?></h6>
                </nav>
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                        <div class="input-group">
                            <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                            <input type="text" class="form-control" placeholder="Type here...">
                        </div>
                    </div>
                    <ul class="navbar-nav  justify-content-end" id="nav-profile">
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
                            <h6><?= $title; ?></h6>
                        </div>
                        <div class="row">
                            <?php if (!isset($_GET["semester_id"])) { ?>
                                <div class="col-md-4">
                                    <div class="form-group" style="margin-left:10px">
                                        <label for="example-text-input" class="form-control-label">Học kỳ</label>
                                        <select name="" class="form-control" id="semester">
                                            <option value="">Chọn học kỳ</option>
                                            <?php
                                            foreach ($semesterInfo as $row) {
                                                echo '<option value="' . $row["semester_id"] . '">' . $row["semester_name"] . " năm học " . $row["year"] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <script>
                                    const semester = document.getElementById("semester");
                                    semester.addEventListener("change", function() {
                                        window.location.href = `?semester_id=${semester.value}`
                                    })
                                </script>
                            <?php } ?>
                        </div>
                        <input type="hidden" id="studentCode">
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="col-12">
                                <div class="table-responsive p-0">
                                    <table class="table align-items-center mb-0 table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="max-width:15vh" class="align-middle text-center text-s">Ca</th>
                                                <th>Thứ 2</th>
                                                <th>Thứ 3</th>
                                                <th>Thứ 4</th>
                                                <th>Thứ 5</th>
                                                <th>Thứ 6</th>
                                                <th>Thứ 7</th>
                                                <th>Chủ nhật</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            for ($i = 1; $i <= 13; $i++) {
                                                echo '<tr>
                                                    <td id="shift" data-item="' . $i . '" class="align-middle text-center text-s" style="max-width:15vh">' . $i . '</td>
                                                    <td id="mon_' . $i . '"></td>
                                                    <td id="tue_' . $i . '"></td>
                                                    <td id="wed_' . $i . '"></td>
                                                    <td id="thur_' . $i . '"></td>
                                                    <td id="fri_' . $i . '"></td>
                                                    <td id="sat_' . $i . '"></td>
                                                    <td id="sun_' . $i . '"></td>
                                                </tr>';
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="sm-12">
                                <div class="title">Môn học đã đăng ký</div>
                                <div class="loading-result">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Môn học</th>
                                                <th style="max-width:5px;">Số tín</th>
                                                <th style="max-width:50px">Hệ số</th>
                                                <th>Người dạy</th>
                                            </tr>
                                        </thead>
                                        <tbody id="selectedSubject"></tbody>
                                        <tr>
                                            <td>Tổng số tín</td>
                                            <td style="max-width:5px;" id="countCredits"></td>
                                            <td style="max-width:50px;" id="fee"></td>
                                            <td></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/app.js"></script>
    <!--   Core JS Files   -->
    <?php
    include_once("footer.php");
    ?>

</body>

</html>