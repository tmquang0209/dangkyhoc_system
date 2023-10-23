<?php
session_start();
include_once "../models/subject.php";

$subject = new Subject();

if (isset($_GET["list"])) {
    if (isset($_SESSION["account"]["staff_code"])) {
        echo json_encode(["result" => $subject->getSubjectList()]);
        exit;
    }

    echo json_encode(["result" => []]);
} else if (isset($_GET["update"])) {
    $editSubject = $_POST["editSubject"];
    $subjectCode = $_POST["subjectCode"];
    $subjectName = $_POST["subjectName"];
    $credits = $_POST["credits"];
    $coef = $_POST["coef"];

    $check = $subject->getSubjectInfo($editSubject);
    if ($check) {
        $subject->updateSubjectInfo($editSubject, $subjectCode, $subjectName, $credits, $coef);
    }
} else if (isset($_GET["info"])) {
    $subjectCode = $_POST["subjectCode"];
    $result = $subject->getSubjectInfo($subjectCode);
    echo json_encode(["result" => $result]);
    exit;
}
