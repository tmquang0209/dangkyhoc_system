<?php
include __DIR__ . "/../models/semester.php";
$semester = new Semester();
$semesterInfo = $semester->getSemesterList();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="logo.svg" type="image/x-icon">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Đăng ký học</title>
</head>

<body>
    <?php include "nav.html"; ?>
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
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
            <div class="col-sm-6">
                <div class="form-floating mb-3 mt-3">
                    <input type="text" id="subName" onkeyup="searchSubject()" class="form-control" placeholder="Nhập môn học cần tìm ...">
                    <label for="">Tìm kiếm môn học</label>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            const container = document.querySelector(".container");
            $("#semester").on("change", function() {
                const value = this.value;
                $.post(`/view/schedule_list.php`, {
                    semester: value,
                    type: "guess"
                }).done(function(res) {
                    const scheduleTable = document.getElementById("schedule-table");
                    if (scheduleTable) scheduleTable.parentElement.removeChild(scheduleTable);
                    console.log(res);
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
</body>

</html>