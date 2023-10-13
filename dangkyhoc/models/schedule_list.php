<?php
include "../vendor/autoload.php";
include "../models/schedule.php";
include "../models/fee.php";

if (isset($_POST)) {
    $semesterID = $_POST["semesterID"];

    $schedule = new Schedule();
    $scheduleList = $schedule->getSchedule($semesterID);

    // var_dump($scheduleList);

    $data = array();

    foreach ($scheduleList as $row) {
        $data[] = array(
            "ID" => $row["id"],
            "SubID" => $row["subject_code"],
            "SubName" => $row["subject_name"],
            "ClassName" => $row["class_name"],
            "Day" => $row["day"],
            "Shift" => $row["shift"],
            "Classroom" => $row["classroom"],
            "Credits" => $row["credits"],
            "Coef" => $row["coef"],
            "Teacher" => $row["teacher"]
        );
    }
    // header("Content-type: application/json");
    $dataJson = json_encode($data, JSON_PRETTY_PRINT);
    echo $dataJson;
}
