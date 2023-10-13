<?php
include_once dirname(__DIR__) . "/models/subject.php";
$subject = new Subject();
$list = $subject->getSubjectList();
// var_dump($list);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Danh sách môn học tại trường</title>
    <style>
        td {
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <?php include_once("nav.html") ?>
    <p></p>
    <div class="container">
        <?php
        if (isset($_GET["delete"])) {
            $id = $_GET["delete"];
            if (isset($_POST["confirm"])) {
                $subject->deleteSubjectInfo($id);
                header('Location: /view/subject_manager.php');
            } else if (isset($_POST["cancel"])) {
                header('Location: /view/subject_manager.php');
            }
        ?>
            <form method="post">
                <div class="row">
                    <label>Bạn có chắc chắn muốn xóa không?</label>
                    <div class="form-floating mb-3 mt-3">
                        <button class="btn btn-success" name="confirm">Xác nhận</button>
                        <button class="btn btn-secondary" name="cancel">Cancel</button>
                    </div>
                </div>
            </form>
        <?php
        } else if (isset($_GET["add"])) {
            if (isset($_POST["submit"])) {
                echo $subCode = $_POST["subCode"];
                echo $subName = $_POST["subName"];
                echo $credits = $_POST["credits"];
                echo $coef = $_POST["coef"];

                if (empty($subCode) || empty($subName) || empty($credits) || empty($coef)) {
                    echo "<script>alert(\"Vui long nhap du thong tin\")</script>";
                } else {
                    $subject->addSubject($subCode, $subName, $credits, $coef);
                    echo "<script>alert(\"Them thanh cong\")</script>";
                    header("Location: /view/subject_manager.php");
                }
            }
        ?>
            <form method="post">
                <div class="form-floating mb-3">
                    <input type="text" name="subCode" class="form-control" placeholder="Nhập mã môn" value="">
                    <label for="">Mã môn</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" name="subName" class="form-control" placeholder="Nhập tên môn" value="">
                    <label for="">Tên môn</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="number" name="credits" class="form-control" placeholder="Nhập số tín" value="">
                    <label for="">Số tín</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="number" name="coef" class="form-control" placeholder="Nhập hệ số" value="">
                    <label for="">Hệ số</label>
                </div>
                <div class="row">
                    <div class="form-floating mb-3 mt-3">
                        <button class="btn btn-success" name="submit">Submit</button>
                        <button class="btn btn-secondary" name="cancel">Cancel</button>
                    </div>
                </div>
            </form>
        <?php } ?>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-floating mb-3 mt-3">
                    <input type="text" id="subName" onkeyup="searchSubject()" class="form-control" placeholder="Nhập môn học cần tìm ...">
                    <label for="">Tìm kiếm môn học</label>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-floating mb-3 mt-3">
                    <button class="btn btn-success" id="redirectButton">Thêm môn học</button>
                </div>
            </div>
        </div>
        <table id="subject-table" class="table table-bordered">
            <thead>
                <tr>
                    <th>Mã môn</th>
                    <th>Tên môn</th>
                    <th>Số tín chỉ</th>
                    <th>Hệ số</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($list as $row) {
                    echo "<tr>
                            <td> " . $row["subject_code"] . "</td>
                            <td> " . $row["subject_name"] . "</td>
                            <td> " . $row["credits"] . "</td>
                            <td> " . $row["coef"] . "</td>
                            <td>
                                    <button class=\"btn btn-success dropdown-toggle\" type=\"button\" id=\"book-dropdown\" data-bs-toggle=\"dropdown\">Option</button>
                                    <ul class=\"dropdown-menu\" aria-labelledby=\"book-dropdown\">
                                        <li><a class=\"dropdown-item\" href=\"?delete=" . $row["subject_code"] . "\">Xóa</a></li>
                                        <li><a class=\"dropdown-item\" href=\"/view/update_subject.php?subjectid=" . $row["subject_code"] . "\">Sửa</a></li>
                                    </ul>
                            </td>
                        </tr>";
                }
                ?>
            </tbody>
    </div>
    <script>
        // Lấy tham chiếu đến nút chuyển hướng bằng cách sử dụng id
        var redirectButton = document.getElementById("redirectButton");

        // Đặt sự kiện onclick cho nút
        redirectButton.onclick = function() {
            // Chuyển hướng đến URL mong muốn khi nút được nhấn
            window.location.href = '?add'; // Thay thế URL bằng URL bạn muốn chuyển hướng đến
        };

        function searchSubject() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("subName");
            filter = input.value.toUpperCase();
            table = document.getElementById("subject-table");
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