<?php
// session_start();
include_once("../models/semester.php");

$semester = new Semester();
if (isset($_GET["list"])) {
    $list = $semester->getSemesterList();
    echo json_encode(["result" => $list]);
} else if (isset($_GET["add"])) {
    $name = $_POST["semesterName"];
    $year = $_POST["year"];

    $id = $semester->addSemester($name, $year);

    echo json_encode(["id" => $id]);
} else if (isset($_GET["update"])) {
    $id = $_POST["semesterID"];
    $name = $_POST["semesterName"];
    $year = $_POST["year"];
    $tuition = $_POST["cash"];

    $rs = $semester->editSemester($id, $name, $year, $tuition);
    echo json_encode(["result" => $rs]);
}
