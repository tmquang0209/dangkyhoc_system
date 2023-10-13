<?php
include_once dirname(__DIR__) . "/models/account.php";
include_once dirname(__DIR__) . "/models/fee.php";
include_once dirname(__DIR__) . "/models/tuition.php";
include_once dirname(__DIR__) . "/models/semester.php";

$student = new Account();
$studentList = $student->getStudentList();

$semester = new Semester();
$semesterList = $semester->getSemesterList();

$tuition = new Tuition();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Quản lý học phí</title>
    <style>
        td {
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <?=include("nav.html") ?>
    <p></p>
    <div class="container">
        <?php if (isset($_GET["detail"])) {
            $studentCode = $_GET["detail"];
            $list = $tuition->getTuition($studentCode);
            $total = $tuition->calcTotalTuition($studentCode);
            // print_r($list);
        ?>
            <table id="student-table" class="table table-bordered">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Học kỳ</th>
                        <th>Số tín</th>
                        <th>Số tiền</th>
                        <th>Trạng thái</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $index = 1;
                    foreach ($list as $row) {
                        echo "<tr>
                            <td> " . $index++ . "</td>
                            <td> " . $row["semester_name"] . "</td>
                            <td> " . $row["total_credits"] . "</td>
                            <td> " . number_format($row["total_fee"]) . " <sup>đ</sup></td>
                            <td> " . $row["status"] . "</td>
                            <td style=\"text-align: center;\">
                                <a href=\"?detail_tuition=" . $row["student_code"] . "&semester=" . $row["semester_id"] . "\"><i class=\"fa fa-eye\" aria-hidden=\"true\"></i></a>
                            </td>
                        </tr>";
                    }
                    ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><?= number_format($total) ?><sup>đ</sup></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        <?php
        } else if (isset($_GET["detail_tuition"])) {
            $studentCode = $_GET["detail_tuition"];
            $semesterID = $_GET["semester"];
            $data = $tuition->getTuitionDetail($studentCode, $semesterID);
            $total = $tuition->calcTuitionBySemester($studentCode, $semesterID);
            $semesterInfo = $semester->getSemester($semesterID);
            $studentInfo = $student->getStudentInfo($studentCode);
        ?>
            <table class="table table-bordered">
                <tr>
                    <td>Kỳ học</td>
                    <td>:</td>
                    <td><?= $semesterInfo["semester_name"]; ?> năm học <?= $semesterInfo["year"]; ?></td>
                </tr>
                <tr>
                    <td>Mã sinh viên</td>
                    <td>:</td>
                    <td><?= $studentCode; ?></td>
                </tr>
                <tr>
                    <td>Họ tên</td>
                    <td>:</td>
                    <td><?= $studentInfo["student_name"]; ?></td>
                </tr>
                <tr>
                    <td>Tình trạng</td>
                    <td>:</td>
                    <td><?= $data[0]["status"]; ?></td>
                </tr>
            </table>
            <table id="student-table" class="table table-bordered">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã môn</th>
                        <th>Tên môn</th>
                        <th>Số tín</th>
                        <th>Hệ số</th>
                        <th>Đơn vị phí</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $index = 1;
                    foreach ($data as $row) {
                        echo "<tr>
                            <td> " . $index++ . "</td>
                            <td> " . $row["subject_code"] . "</td>
                            <td> " . $row["subject_name"] . "</td>
                            <td> " . $row["credits"] . "</td>
                            <td> " . $row["coef"] . "</td>
                            <td> " . number_format($row["cost"]) . "<sup>đ</sup></td>
                            <td> " . number_format($row["total"]) . " <sup>đ</sup></td>
                        </tr>";
                    }
                    ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><?= number_format($total) ?><sup>đ</sup></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        <?php
        } else if (isset($_GET["calcTuition"])) {
            if (isset($_POST["submit"])) {
                $semesterID = $_POST["semester"];
                $tuition->addTuition($semesterID);
            }
        ?>
            <form method="post">
                <div class="form-floating mb-3 mt-3">
                    <select class="form-select" id="semester" name="semester">
                        <option value="">---Lựa chọn---</option>
                        <?php
                        foreach ($semesterList as $row) {
                            echo '<option value="' . $row["id"] . '">' . $row["semester_name"] . " năm học " . $row["year"] . '</option>';
                        }
                        ?>
                    </select>
                    <label for="sel1" class="form-label">Học kỳ:</label>
                </div>
                <div class="col-sm-6">
                    <div class="form-floating mb-3 mt-3">
                        <button class="btn btn-success" name="submit">Tính tiền học</button>
                    </div>
                </div>
            </form>
        <?php } else { ?>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-floating mb-3 mt-3">
                        <input type="text" id="studentCode" onkeyup="searchStudent()" class="form-control" placeholder="Nhập mã sinh viên cần tìm ...">
                        <label for="">Tìm kiếm mã sinh viên</label>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-floating mb-3 mt-3">
                        <button class="btn btn-success" id="redirectButton">Tính tiền học</button>
                    </div>
                </div>
            </div>
            <table id="student-table" class="table table-bordered">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã sinh viên</th>
                        <th>Tên sinh viên</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $index = 1;
                    foreach ($studentList as $row) {
                        echo "<tr>
                            <td> " . $index++ . "</td>
                            <td> " . $row["student_code"] . "</td>
                            <td> " . $row["student_name"] . "</td>
                            <td style=\"text-align: center;\">
                                <a href=\"?detail=" . $row["student_code"] . "\"><i class=\"fa fa-eye\" aria-hidden=\"true\"></i></a>
                            </td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        <?php
        } ?>
    </div>
    <script>
        // Lấy tham chiếu đến nút chuyển hướng bằng cách sử dụng id
        var redirectButton = document.getElementById("redirectButton");

        // Đặt sự kiện onclick cho nút
        redirectButton.onclick = function() {
            // Chuyển hướng đến URL mong muốn khi nút được nhấn
            window.location.href = '?calcTuition'; // Thay thế URL bằng URL bạn muốn chuyển hướng đến
        };

        function searchStudent() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("studentCode");
            filter = input.value.toUpperCase();
            table = document.getElementById("student-table");
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
</body>

</html>