<?php
session_start();
include_once("../models/semester.php");

$semester = new Semester();
if (isset($_GET["list"])) {
    $list = $semester->getSemesterList();
    echo json_encode(["result" => $list]);
} else if (isset($_GET["add"])) {
    $name = $_POST["semesterName"];
    $year = $_POST["year"];
    $cash = $_POST["cash"];
    $start = $_POST["start"];
    $end = $_POST["end"];

    $id = $semester->addSemester($name, $year, $cash, $start, $end);

    echo json_encode(["id" => $id]);
} else if (isset($_GET["update"])) {
    $id = $_POST["semesterID"];
    $name = $_POST["semesterName"];
    $year = $_POST["year"];
    $tuition = $_POST["cash"];
    $start = $_POST["start"];
    $end = $_POST["end"];

    $rs = $semester->editSemester($id, $name, $year, $tuition, $start, $end);
    echo json_encode(["result" => $rs]);
}
