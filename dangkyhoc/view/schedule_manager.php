<?php
include dirname(__DIR__) . "/vendor/autoload.php";
include dirname(__DIR__) . "/models/semester.php";
include dirname(__DIR__) . "/models/schedule.php";

use Shuchkin\SimpleXLSX;

$semester = new Semester();
$semesterInfo = $semester->getSemesterList();

$schedule = new Schedule();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <title>Quản lý thời khóa biểu</title>

</head>

<body>
    <?php include "nav.html"; ?>
    <div class="container">
        <?php
        if (isset($_GET["delete"])) {
            $id = (int)$_GET["delete"];
            if (isset($_POST["confirm"])) {
                echo "Da xoa thanh cong";
            } else if (isset($_POST["cancel"])) {
                header('Location: /view/schedule_manager.php');
            }
        ?>
            <form method="post">
                <div class="row">
                    <label>Bạn có chắc chắn muốn xóa không? Lớp học sinh viên đăng ký sẽ bị xóa khỏi thời khóa biểu</label>
                    <div class="form-floating mb-3 mt-3">
                        <button class="btn btn-success" name="confirm">Xác nhận</button>
                        <button class="btn btn-secondary" name="cancel">Cancel</button>
                    </div>
                </div>
            </form>
        <?php
        } else if (isset($_GET["add"])) {
            if (isset($_POST["submit"])) {
                $selectType = (int)$_POST["selectType"];
                $semesterid = $_POST["semester"];
                if ($selectType == 0) {
                    $year = $_POST["year"];
                    $id = $semester->addSemester($semesterid, $year);
                } else {
                    $id = $semesterid;
                }
                // Kiểm tra xem có lỗi nào trong quá trình tải lên không
                if ($_FILES["excelFile"]["error"] == UPLOAD_ERR_OK) {
                    // Đường dẫn tạm thời của tệp trên máy chủ
                    $tempFilePath = $_FILES["excelFile"]["tmp_name"];

                    // Đường dẫn và tên tệp trên máy chủ mục tiêu
                    $targetDirectory = dirname(__DIR__) . "/data/"; // Thay đổi đường dẫn này thành thư mục bạn muốn lưu tệp vào
                    $targetFileName = basename($_FILES["excelFile"]["name"]);
                    $targetFilePath = $targetDirectory . $targetFileName;

                    // Di chuyển tệp từ đường dẫn tạm thời đến đường dẫn mục tiêu
                    if (move_uploaded_file($tempFilePath, $targetFilePath)) {
                        if ($xlsx = SimpleXLSX::parse('../data/thoikhoabieu.xlsx')) {
                            $rawData = $xlsx->rows();
                            // echo $xlsx->toHTML();
                            $count = 0;
                            foreach ($rawData as $row) {
                                if (
                                    $count++ != 0
                                ) {
                                    $data = [
                                        "SubID" => $row[1],
                                        "SubName" => $row[2],
                                        "Classname" => $row[3],
                                        "Day" => $row[4],
                                        "Shift" => $row[6],
                                        "Classroom" => $row[7],
                                        "Credits" => $row[8],
                                        "Coef" => $row[9],
                                        "Teacher" => $row[10],
                                    ];
                                    $schedule->addClass($data["SubID"], $data["SubName"], $data["Credits"], $data["Coef"], $id, $data["Classname"], $data["Day"], $data["Shift"], $data["Classroom"], $data["Teacher"]);
                                }
                            }
                        } else {
                            echo SimpleXLSX::parseError();
                        }
                    } else {
                        echo "Có lỗi xảy ra khi lưu tệp.";
                    }
                } else {
                    echo "Có lỗi xảy ra khi tải lên tệp.";
                }
            }
        ?>
            <p></p>
            <form method="POST" enctype="multipart/form-data">
                <div class="form-floating mb-3 mt-3">
                    <select class="form-select" name="selectType" id="selectType">
                        <option value="0">Thêm mới kỳ học</option>
                        <option value="1">Kỳ học có sẵn</option>
                    </select>
                    <label for="sel1" class="form-label">Loại:</label>
                </div>
                <div class="form-floating mb-3 mt-3" id="semester_select" style="display:none;">
                    <select class="form-select" id="semester" name="semester">
                        <option value="">---Lựa chọn---</option>
                        <?php
                        foreach ($semesterInfo as $row) {
                            echo '<option value="' . $row["id"] . '">' . $row["semester_name"] . " năm học " . $row["year"] . '</option>';
                        }
                        ?>
                    </select>
                    <label for="sel1" class="form-label">Học kỳ:</label>
                </div>
                <div class="form-floating mb-3 mt-3" id="semester_input" style="display:block;">
                    <input type="text" name="semester" class="form-control" placeholder="Nhập thời tên học kỳ ...">
                    <label for="sel1" class="form-label">Học kỳ:</label>
                </div>
                <div class="form-floating mb-3 mt-3" id="semester_input" style="display:block;">
                    <input type="text" name="year" class="form-control" placeholder="Nhập năm học ...">
                    <label for="sel1" class="form-label">Năm học:</label>
                </div>
                <div class="mb-3">
                    <input type="file" name="excelFile" id="excelFile" class="form-control">
                </div>
                <div class="row">
                    <div class="form-floating mb-3 mt-3">
                        <button class="btn btn-success" name="submit">Submit</button>
                        <button class="btn btn-secondary" name="cancel">Cancel</button>
                    </div>
                </div>
            </form>
            <script>
                const selectType = document.getElementById("selectType");
                selectType.addEventListener("change", function() {
                    const value = selectType.value;
                    console.log(value);
                    if (value === "0") {
                        console.log(123);
                        const semInput = document.getElementById("semester_input");
                        semInput.style.display = "block";
                        const semSelect = document.getElementById("semester_select");
                        semSelect.style.display = "none";
                    } else if (value === "1") {
                        console.log(123455);
                        const semSelect = document.getElementById("semester_select");
                        semSelect.style.display = "block";
                        const semInput = document.getElementById("semester_input");
                        semInput.style.display = "none";
                    }
                })
            </script>
        <?php } else { ?>

            <div class="row">
                <div class="col-sm-4">
                    <div class="form-floating mb-3 mt-3">
                        <select class="form-select" id="semester" name="semester">
                            <option value="">---Lựa chọn---</option>
                            <?php
                            foreach ($semesterInfo as $row) {
                                echo '<option value="' . $row["id"] . '">' . $row["semester_name"] . " năm học " . $row["year"] . '</option>';
                            }
                            ?>
                        </select>
                        <label for="sel1" class="form-label">Học kỳ:</label>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-floating mb-3 mt-3">
                        <input type="text" id="subName" onkeyup="searchSubject()" class="form-control" placeholder="Nhập môn học cần tìm ...">
                        <label for="">Tìm kiếm môn học</label>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-floating mb-3 mt-3">
                        <button class="btn btn-success" id="redirectButton">Nhập thời khóa biểu</button>
                    </div>
                </div>
            </div>
    </div>
    <script>
        // Lấy tham chiếu đến nút chuyển hướng bằng cách sử dụng id
        var redirectButton = document.getElementById("redirectButton");

        // Đặt sự kiện onclick cho nút
        redirectButton.onclick = function() {
            // Chuyển hướng đến URL mong muốn khi nút được nhấn
            window.location.href = '?add'; // Thay thế URL bằng URL bạn muốn chuyển hướng đến
        };
        $(document).ready(function() {
            const container = document.querySelector(".container");
            $("#semester").on("change", function() {
                const value = this.value;
                $.post(`/view/schedule_list.php`, {
                    semester: value,
                    type: "admin"
                }).done(function(res) {
                    const scheduleTable = document.getElementById("schedule-table");
                    if (scheduleTable) scheduleTable.parentElement.removeChild(scheduleTable);
                    container.insertAdjacentHTML("beforeend", res);
                });
            });
        });

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
<?php } ?>
</body>

</html>