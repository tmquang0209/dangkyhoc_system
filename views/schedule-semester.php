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
                    <td>" . $row["teacher"] . "</td>
                </tr>";
        }
        echo "</tbody>";
        echo "</table>";
    }
    if ($type == "admin") {

        echo "<table id=\"schedule-table\" class=\"table table-bordered\">";
        echo "<thead>
                    <tr>
                    <th>STT</th>
                        <th>Mã môn</th>
                        <th>Tên môn</th>
                        <th>Lớp</th>
                        <th>Thứ</th>
                        <th>Ca/Phòng</th>
                        <th>Người dạy</th>
                        <th>Thao tác</th>
                        </tr>
                        </thead>";
        echo "<tbody>";
        $count = 1;
        foreach ($data as $row) {
            echo "<tr>
                    <td>" . $count++ . "</td>
                    <td>" . $row["subject_code"] . "</td>
                    <td>" . $row["subject_name"] . "</td>
                    <td>" . $row["class_name"] . "</td>
                    <td>" . $row["day"] . "</td>
                    <td>" . $row["shift"] . "/ " . $row["classroom"] . "</td>
                    <td>" . $row["teacher"] . "</td>
                    <td>
                        <div class=\"dropdown mt-3\">
                            <button class=\"btn btn-success dropdown-toggle\" type=\"button\" id=\"book-dropdown\" data-bs-toggle=\"dropdown\">Option</button>
                            <ul class=\"dropdown-menu\" aria-labelledby=\"book-dropdown\">
                                <li><a class=\"dropdown-item\" href=\"?delete=" . $row["id"] . "\">Xóa</a></li>
                                <li><a class=\"dropdown-item\" href=\"/view/update_schedule.php?classid=" . $row["id"] . "\">Sửa</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>";
        }
        echo "</tbody>";
        echo "</table>";
    }
}
