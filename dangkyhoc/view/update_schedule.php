<?php
// include_once "../models/subject.php";
include_once "../models/schedule.php";
include_once "../models/semester.php";
include_once "../models/subject.php";

$semester = new Semester();
$semesterList = $semester->getSemesterList();

$schedule = new Schedule();
$subject = new Subject();

$classID = (isset($_GET["classid"])) ? $_GET["classid"] : 0;
$classInfo = $schedule->getClassByID($classID);
$subjectList = $subject->getSubjectList();
$schedule->updateSchedule($classID);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Cập nhật thông tin lớp học</title>
</head>

<body>
    <div style="text-align: center;font-size: 25px; color: red;">Cập nhật thông tin lớp học</div>
    <div class="container">
        <form method="POST">
            <div class="form-floating mb-3 mt-3">
                <select class="form-select" id="semester" name="semester">
                    <?php
                    foreach ($semesterList as $row) {
                        echo '<option value="' . $row["id"] . '" ' . ($classInfo["group_id"] == $row["id"] ? "selected" : "") . '>' . $row["semester_name"] . ' năm học ' . $row["year"] . '</option>';
                    }
                    ?>
                </select>
                <label for="sel1" class="form-label">Học kỳ:</label>
            </div>
            <div class="form-floating mb-3 mt-3">
                <select class="form-select" id="subject_code" name="subject_code">
                    <?php
                    foreach ($subjectList as $row) {
                        echo '<option value="' . $row["subject_code"] . '">' . $row["subject_name"] . '</option>';
                    }
                    ?>
                </select>
                <label for="sel1" class="form-label">Môn học:</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" name="day" class="form-control" placeholder="2" value="<?= $classInfo["day"]; ?>">
                <label for="">Thứ</label>
                <div style="color: red;">* Chủ nhật: nhập 1</div>
            </div>
            <div class="form-floating mb-3">
                <input type="text" name="shift" class="form-control" placeholder="1-2" value="<?= $classInfo["shift"]; ?>">
                <label for="">Ca</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" name="class_name" class="form-control" placeholder="LOPHOCPHAN" value="<?= $classInfo["class_name"]; ?>">
                <label for="">Tên lớp</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" name="classroom" class="form-control" placeholder="A101" value="<?= $classInfo["classroom"]; ?>">
                <label for="">Lớp học</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" name="teacher" class="form-control" placeholder="Nguyen Van A" value="<?= $classInfo["teacher"]; ?>">
                <label for="">Giáo viên dạy</label>
            </div>
            <div>
            </div>
            <button type="submit" class="btn btn-success" name="submit">Submit</button>
        </form>
    </div>
</body>

</html>