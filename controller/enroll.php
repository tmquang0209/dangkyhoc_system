<?php
session_start();
include_once("../models/enroll.php");
include_once("../models/schedule.php");

if (isset($_GET["save"])) {
    $enroll = new Enroll();
    $schedule = new Schedule();

    $data = file_get_contents('php://input'); // Retrieve the JSON data from the request body
    $jsonData = json_decode($data, true); // Decode JSON into aưn associative array
    // echo $data;
    $semesterID = $jsonData["semesterid"];
    $studentCode = $_SESSION["account"]["student_code"];

    // Check if decoding was successful
    if ($jsonData !== null) {
        foreach ($jsonData["data"] as $row) {
            // var_dump($row);
            foreach ($row["ClassList"] as $val) {
                // echo $val["ClassName"] . " ";
                if (strpos($val["ClassName"], "_LT") !== false) continue;
                $getClassID = $schedule->getClassByClassName($val["ClassName"])["id"];
                $enroll->addEnroll($studentCode, $row["SubID"], $getClassID);
            }
        }
    } else {
        echo "Failed to decode JSON data.";
    }
} else if (isset($_GET["getSchedule"])) {
    $enroll = new Enroll();

    $data = file_get_contents('php://input'); // Retrieve the JSON data from the request body
    $jsonData = json_decode($data, true); // Decode JSON into an associative array

    $semesterID = $jsonData["semesterid"];

    $studentCode = $_SESSION["account"]["student_code"];

    $res = $enroll->getEnroll($semesterID, $studentCode);
    $classList;
    $data = array();
    foreach ($res as $row) {
        $getClassList = $enroll->getClassByClassName($row["class_name"]);
        $data[] = array(
            "ID" => $row["id"],
            "SubID" => $row["subject_code"],
            "SubName" => $row["subject_name"],
            "Credits" => $row["credits"],
            "Coef" => $row["coef"],
            "ClassList" => $getClassList
        );
    }

    echo json_encode($data);
} elseif (isset($_GET["delSchedule"])) {
    $enroll = new Enroll();

    $data = file_get_contents('php://input'); // Retrieve the JSON data from the request body
    $jsonData = json_decode($data, true); // Decode JSON into an associative array

    if ($jsonData["studentCode"])
        $studentCode = $jsonData["studentCode"];
    else
        $studentCode = $_SESSION["account"]["student_code"];

    $dataDel = $jsonData["data"];

    foreach ($dataDel["ClassList"] as $row) {
        $enroll->deleteEnroll($studentCode, $row["ClassName"]);
    }
} else if (isset($_GET["checkLimit"])) {
    // var_dump($_POST);
    $classroom = $_POST["classroom"];

    $schedule = new Schedule();

    $data = $schedule->getClassByClassName($classroom);
    $max = $data["num_student"];

    //count in enroll table
    $enroll = new Enroll();
    $countStudent = $enroll->countStudent($classroom);

    if ($countStudent === $max)
        echo json_encode(["full" => true]);
    else
        echo json_encode(["full" => false]);
    // echo $data["num_student"];
}
