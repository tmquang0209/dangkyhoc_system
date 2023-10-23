<?php
// session_start();
include "../vendor/autoload.php";
include_once("../models/schedule.php");
include "../models/fee.php";

$schedule = new Schedule();
if (isset($_GET["update"])) {

    $classID = $_POST["classID"];
    $day = $_POST["day"];
    $shift = $_POST["shift"];
    $classroom = $_POST["classroom"];
    $numStudent = (int)$_POST["student"];
    $teacherCode = $_POST["teacherCode"];

    $schedule->updateSchedule($classID, $day, $shift, $classroom, $numStudent, $teacherCode);
} else if (isset($_GET["subjectList"])) {
    if (isset($_POST)) {
        $semesterID = (int)$_POST["semesterID"];

        $scheduleList = $schedule->getSchedule($semesterID);
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
                "Teacher" => $row["teacher_code"] . " " . $row["teacher_name"]
            );
        }
        // header("Content-type: application/json");
        $dataJson = json_encode($data, JSON_PRETTY_PRINT);
        echo $dataJson;
    }
} else if (isset($_GET["getFee"])) {
    $data = file_get_contents('php://input'); // Retrieve the JSON data from the request body
    $jsonData = json_decode($data, true); // Decode JSON into an associative array

    $fee = new Fee();
    $semesterID = $jsonData["semesterid"];
    echo $fee->getFee($semesterID);
} else if (isset($_GET["getTeachingSchedule"])) {
    $semesterID = (int)$_POST["semesterID"];
    $teacher = $_SESSION["account"];

    $data = $schedule->getTeachingSchedule($semesterID, $teacher["teacher_code"]);

    echo json_encode(["result" => $data]);
} else if (isset($_GET["teachingScheduleDetail"])) {
    $id = (int)$_POST["id"];
    $data = $schedule->getTeachingScheduleDetail($id);
    echo json_encode(["result" => $data]);
}
