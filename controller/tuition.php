<?php
session_start();
include_once("../models/tuition.php");
include_once("../models/semester.php");

$semester = new Semester();
$tuition = new Tuition();

if (isset($_GET["manager"])) {
    if (!isset($_SESSION["account"]["staff_code"])) {
        echo json_encode(["result" => []]);
        exit;
    }

    $list = $semester->getSemesterList();
    echo json_encode(["result" => $list]);
} else if (isset($_GET["updateUnit"])) {
    if (!isset($_SESSION["account"]["staff_code"])) {
        exit;
    }

    $id = (int)$_POST["semesterID"];
    $cash = $_POST["cash"];

    $semester->updateFee($id, $cash);
} else if (isset($_GET["calc"])) {
    if (!isset($_SESSION["account"]["staff_code"])) {
        exit;
    }

    $id = (int)$_POST["id"];
    $tuition->addTuition($id);
} else if (isset($_GET["tuitionBySemester"])) {
    if (!isset($_SESSION["account"]["staff_code"])) {
        exit;
    }

    $id = (int)$_POST["id"];
    $result = $tuition->getTuitionSemester($id);
    echo json_encode(["result" => $result]);
} else if (isset($_GET["tuitionByID"])) {
    $id = (int)$_POST["id"];
    $result = $tuition->getTuitionByID($id);
    $detail = $tuition->getTuitionDetail($id);

    if (!isset($_SESSION["account"]["staff_code"]) && !isset($_SESSION["account"]["student_code"])) {
        echo json_encode([]);
        exit;
    } else if (isset($_SESSION["account"]["student_code"])) {
        if ($result["student_code"] != $_SESSION["account"]["student_code"]) {
            echo json_encode([]);
            exit;
        }
    }


    echo json_encode(["id" => $id, "general" => $result, "detail" => $detail, "account" => $_SESSION["account"]]);
} else if (isset($_GET["student"])) {
    $account = $_SESSION["account"];
    $result = $tuition->getTuition($account["student_code"]);

    echo json_encode(["result" => $result]);
}
