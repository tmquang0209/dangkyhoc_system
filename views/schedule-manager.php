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
        Quản lý thời khóa biểu
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
                        <li class="breadcrumb-item text-sm text-white active" aria-current="page">Quản lý thời khóa biểu</li>
                    </ol>
                    <h6 class="font-weight-bolder text-white mb-0">Quản lý thời khóa biểu</h6>
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
                            <h6>Quản lý thời khóa biểu</h6>
                        </div>
                        <?php if (isset($_GET["update"])) {
                            include("../models/schedule.php");
                            $id = (int)$_GET["update"];
                            $schedule = new Schedule();
                            $getInfoClass =  $schedule->getClassByID($id);
                            // var_dump($getInfoClass);
                        ?>

                            <style>
                                #suggestions {
                                    position: absolute;
                                    background-color: #fff;
                                    /* border: 1px solid #ccc; */
                                    max-height: 150px;
                                    overflow-y: auto;
                                    width: 100%;
                                }

                                #suggestions div {
                                    padding: 8px;
                                    cursor: pointer;
                                }

                                #suggestions div:hover {
                                    background-color: #f0f0f0;
                                }
                            </style>
                            <input hidden class="form-control" type="text" value="<?= $getInfoClass["id"] ?>" id="classID">
                            <div class="card-body">
                                <p class="text-uppercase text-sm">Cập nhật thông tin lớp <?= $getInfoClass["class_name"] ?></p>
                                <div id="message"></div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Thứ</label>
                                            <input class="form-control" type="text" value="<?= $getInfoClass["day"] ?>" id="day">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Giờ học</label>
                                            <input class="form-control" type="text" value="<?= $getInfoClass["shift"] ?>" id="shift">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Phòng học</label>
                                            <input class="form-control" type="text" value="<?= $getInfoClass["classroom"] ?>" id="classroom">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Số lượng sinh viên</label>
                                            <input class="form-control" type="text" value="<?= $getInfoClass["num_student"] ?>" id="numStudent">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Giảng viên</label>
                                            <input type="text" hidden value="<?= $getInfoClass["teacher_code"] ?>" id="teacherCode">
                                            <input class="form-control" type="text" name="teacher" id="teacher" value="<?= $getInfoClass["teacher_name"]; ?>">
                                            <div id="suggestions"></div>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-sm ms-auto" id="updateBtn">Cập nhật</button>
                            </div>
                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                            <script>
                                var message = document.getElementById("message");
                                var day = document.getElementById("day");
                                var shift = document.getElementById("shift");
                                var classroom = document.getElementById("classroom");
                                var numStudent = document.getElementById("numStudent");
                                var teacherList = [];
                                var teacherInput = document.getElementById("teacher");
                                var teacherCode = document.getElementById("teacherCode");
                                var suggestionList = document.getElementById("suggestions");
                                var updateBtn = document.getElementById("updateBtn");

                                function getTeacherList() {
                                    $.post(`/controller/teacher.php?listTeacher`, function(res) {
                                        teacherList = JSON.parse(res.trim());
                                    });
                                }

                                getTeacherList();

                                teacherInput.addEventListener("input", function() {
                                    var inputText = teacherInput.value.toLowerCase();
                                    var suggestions = [];

                                    teacherList.forEach(function(teacher) {
                                        if (teacher.teacher_name.toLowerCase().includes(inputText)) {
                                            suggestions.push(teacher);
                                        }
                                    });

                                    showSuggestions(suggestions);
                                });

                                // Close the suggestions when clicking outside
                                document.body.addEventListener("click", function(event) {
                                    if (event.target !== teacherInput && event.target !== suggestionList) {
                                        suggestionList.innerHTML = ""; // Clear suggestions
                                    }
                                });

                                function showSuggestions(suggestions) {
                                    // Clear existing suggestions
                                    suggestionList.innerHTML = "";

                                    suggestions.forEach(function(suggestion) {
                                        var suggestionItem = document.createElement("div");
                                        suggestionItem.textContent = suggestion.teacher_name;
                                        suggestionItem.addEventListener("click", function() {
                                            teacherInput.value = suggestion.teacher_name;
                                            teacherCode.value = suggestion.teacher_code;
                                            suggestionList.innerHTML = ""; // Clear suggestions
                                        });
                                        suggestionList.appendChild(suggestionItem);
                                    });
                                }

                                updateBtn.addEventListener("click", function(e) {
                                    const classID = document.getElementById("classID").value;
                                    const dayValue = day.value;
                                    const shiftValue = shift.value;
                                    const classroomValue = classroom.value;
                                    const numStudentValue = numStudent.value;
                                    const teacherCodeValue = teacherCode.value;

                                    if (dayValue && shiftValue && classroomValue) {
                                        $.post(`/controller/schedule.php?update`, {
                                            classID,
                                            day: dayValue,
                                            shift: shiftValue,
                                            classroom: classroomValue,
                                            numStudent: numStudentValue,
                                            teacherCode: teacherCodeValue,
                                        }, function(res) {
                                            console.log(res);
                                            message.innerHTML = `<div class="alert alert-success" role="alert">Cập nhật thông tin lớp học thành công.</div>`
                                            setTimeout(() => {
                                                location.href = "/views/schedule-manager.php"
                                            }, 1000)
                                        });
                                    } else {
                                        message.innerHTML = `<div class="alert alert-danger" role="alert">Vui lòng nhập đầy đủ thứ và giờ học.</div>`
                                    }
                                })
                            </script>
                        <?php } ?>
                        <div class="row">
                            <div class="col-md-4">
                                <?php
                                include_once __DIR__ . "/../models/semester.php";
                                $semester = new Semester();
                                $semesterInfo = $semester->getSemesterList();
                                ?>
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
                            <div class="col-md-4">
                                <div class="form-group" style="margin-top:25px">
                                    <label for="example-text-input" class="form-control-label">Tìm kiếm môn học</label>
                                    <input name="" class="form-control" id="subName" onkeyup="searchSubject()">
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0" id="render-table">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        const renderTable = document.getElementById("render-table");
        $(document).ready(function() {
            $("#semester").on("change", function() {
                const value = this.value;
                localStorage.setItem("semester-id", value);
                load(value);
            });

            if (localStorage.getItem("semester-id")) {
                load(localStorage.getItem("semester-id"));
                document.getElementById("semester").value = localStorage.getItem("semester-id")
            }

        });

        function load(id) {
            $.post(`/views/schedule-semester.php`, {
                semester: id,
                type: "admin"
            }).done(function(res) {
                renderTable.innerHTML = res;
            });
        }

        function searchSubject() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("subName");
            filter = input.value.toUpperCase();
            table = document.getElementById("schedule-table");
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