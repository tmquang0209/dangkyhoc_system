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
}else if (isset($_GET["add"])) {
    $subjectCode = $_POST["subjectCode"];
    $subjectName = $_POST["subjectName"];
    $credits = $_POST["credits"];
    $coef = $_POST["coef"];

    $check = $subject->getSubjectInfo($subjectCode);
    if (!$check) {
        $subject->addSubject($subjectCode, $subjectName, $credits, $coef);
        echo json_encode(["success" => true, "message" => "Thêm môn học thành công."]);
    }else{
        echo json_encode(["success" => false, "message" => "Môn học đã tồn tại."]);
    }
} else if (isset($_GET["info"])) {
    $subjectCode = $_POST["subjectCode"];
    $result = $subject->getSubjectInfo($subjectCode);
    echo json_encode(["result" => $result]);
    exit;
}
