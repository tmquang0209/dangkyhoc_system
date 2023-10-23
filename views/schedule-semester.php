<?php
// include "../models/subject.php";
include "../models/schedule.php";

if (isset($_POST["semester"])) {
    $semester = (int)$_POST["semester"];
    $type = $_POST["type"];
    $schedule = new Schedule();
    $data = $schedule->getSchedule($semester);
    // var_dump($data);

    if ($type == "guess") {

        echo "<table class=\"table align-items-center mb-0\" id=\"schedule-table\">";
        echo "<thead>
                    <tr>
                        <th class=\"text-uppercase text-secondary text-xxs font-weight-bolder opacity-7\">STT</th>
                        <th class=\"text-uppercase text-secondary text-xxs font-weight-bolder opacity-7\">Mã môn</th>
                        <th class=\"text-uppercase text-secondary text-xxs font-weight-bolder opacity-7\">Tên môn</th>
                        <th class=\"text-uppercase text-secondary text-xxs font-weight-bolder opacity-7\">Lớp</th>
                        <th class=\"text-uppercase text-secondary text-xxs font-weight-bolder opacity-7\">Thứ</th>
                        <th class=\"text-uppercase text-secondary text-xxs font-weight-bolder opacity-7\">Ca</th>
                        <th class=\"text-uppercase text-secondary text-xxs font-weight-bolder opacity-7\">Phòng</th>
                        <th class=\"text-uppercase text-secondary text-xxs font-weight-bolder opacity-7\">Số tín</th>
                        <th class=\"text-uppercase text-secondary text-xxs font-weight-bolder opacity-7\">Người dạy</th>
                    </tr>
                </thead>";
        echo "<tbody>";
        $count = 1;
        foreach ($data as $row) {
            echo "<tr>
                    <td style=\"max-width: 5px;white-space: pre-line;overflow: hidden;text-overflow: ellipsis;\">" . $count++ . "</td>
                    <td style=\"max-width: 20px;white-space: pre-line;overflow: hidden;text-overflow: ellipsis;\">" . $row["subject_code"] . "</td>
                    <td style=\"max-width: 300px;white-space: pre-line;overflow: hidden;text-overflow: ellipsis;\">" . $row["subject_name"] . "</td>
                    <td style=\"max-width: 100px;white-space: pre-line;overflow: hidden;text-overflow: ellipsis;\">" . $row["class_name"] . "</td>
                    <td style=\"max-width: 5px;white-space: pre-line;overflow: hidden;text-overflow: ellipsis;\">" . $row["day"] . "</td>
                    <td style=\"max-width: 5px;white-space: pre-line;overflow: hidden;text-overflow: ellipsis;\">" . $row["shift"] . "</td>
                    <td style=\"max-width: 5px;white-space: pre-line;overflow: hidden;text-overflow: ellipsis;\">" . $row["classroom"] . "</td>
                    <td style=\"max-width: 10px;white-space: pre-line;overflow: hidden;text-overflow: ellipsis;\">" . $row["credits"] . "</td>
                    <td>" . $row["teacher_name"] . " (" . $row["teacher_code"] . ")" . "</td>
                </tr>";
        }
        echo "</tbody>";
        echo "</table>";
    }
    if ($type == "admin") {

        echo "<table class=\"table align-items-center mb-0\" id=\"schedule-table\">";
        echo "<thead>
                    <tr>
                        <th class=\"text-uppercase text-secondary text-xxs font-weight-bolder opacity-7\">STT</th>
                        <th class=\"text-uppercase text-secondary text-xxs font-weight-bolder opacity-7\">Mã môn</th>
                        <th class=\"text-uppercase text-secondary text-xxs font-weight-bolder opacity-7\">Tên môn</th>
                        <th class=\"text-uppercase text-secondary text-xxs font-weight-bolder opacity-7\">Lớp</th>
                        <th class=\"text-uppercase text-secondary text-xxs font-weight-bolder opacity-7\">Thông tin</th>
                        <th class=\"text-uppercase text-secondary text-xxs font-weight-bolder opacity-7\">Người dạy</th>
                        <th class=\"text-uppercase text-secondary text-xxs font-weight-bolder opacity-7\">Thao tác</th>
                    </tr>
                </thead>";
        echo "<tbody>";
        $count = 1;
        foreach ($data as $row) {
            echo "<tr>
                    <td>" . $count++ . "</td>
                    <td>" . $row["subject_code"] . "</td>
                    <td style=\"max-width: 200px;white-space: pre-line;overflow: hidden;text-overflow: ellipsis;\">" . $row["subject_name"] . "</td>
                    <td style=\"max-width: 100px;white-space: pre-line;overflow: hidden;text-overflow: ellipsis;\">" . $row["class_name"] . "</td>
                    <td> Thứ: " . $row["day"] . "<br />Ca: " . $row["shift"] . "<br /> Phòng: " . $row["classroom"] . "<br /> Số lượng: " . $row["count_student"] . "/" . $row["num_student"] . "</td>
                    <td style=\"max-width: 80px;white-space: pre-line;overflow: hidden;text-overflow: ellipsis;\">" . $row["teacher_name"] . " (" . $row["teacher_code"] . ")" . "</td>
                    <td class=\"align-middle\">
                    <a href=\"/views/teaching-schedule-detail.php?id=" . $row["id"] . "\" data-toggle=\"tooltip\" data-original-title=\"Edit user\">
                    <span class=\"badge badge-sm bg-gradient-success\">
                    Xem chi tiết
                    </span>
                    </a>
                    <br />
                    <a href=\"?update=" . $row["id"] . "\" data-toggle=\"tooltip\" data-original-title=\"Edit user\">
                        <span class=\"badge badge-sm bg-gradient-warning\">
                            Sửa
                        </span>
                    </a>
                    <br />
                    <a  onclick=\"return deleteClass(" . $row["id"] . ");\" data-toggle=\"tooltip\" data-original-title=\"Edit user\">
                        <span class=\"badge badge-sm bg-gradient-danger\">
                            Xóa
                        </span>
                    </a>
                    </td>
                </tr>";
        }
        echo "</tbody>";
        echo "</table>";
    }
}
?>
<style>
    .update {
        background-color: green;
        padding: 5px;
        color: #FFFFFF;
        border-radius: 10px;
    }

    .delete {
        background-color: red;
        padding: 5px;
        color: #FFFFFF;
        border-radius: 10px;
    }
</style>