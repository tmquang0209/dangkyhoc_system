<?php
// session_start();
include_once("../models/staff.php");
include_once("../models/teacher.php");
include_once("../models/student.php");

$staff = new Staff();
$teacher = new Teacher();
$student = new Student();
if (isset($_GET["check"])) {
    if (isset($_POST["username"]) && isset($_POST["password"])) {

        $username = $_POST["username"];
        $password = $_POST["password"];

        if (!empty($username) && !empty($password)) {
            $check = null;
            if ($staff->getInfo($username)) {
                $check = $staff->getInfo($username);
            } else if ($teacher->getInfo($username)) {
                $check = $teacher->getInfo($username);
            } else if ($student->getInfo($username)) {
                $check = $student->getInfo($username);
            }

            if ($check) {
                if ($check["password"] === md5($password)) {
                    echo json_encode(["success" => false, "message" => "Password is incorrect."]);
                } else {
                    $_SESSION["account"] = $check;
                    echo json_encode(["success" => true, "message" => "Login success.", "info" => $_SESSION["account"]]);
                }
            } else {
                echo json_encode(["success" => false, "message" => "Account isn't exists.", "check" => $username]);
            }
        } else {
            echo json_encode(["success" => false, "message" => "Please fill in all information."]);
        }
    }
} else if (isset($_GET["getInfo"])) {
    if (isset($_SESSION["account"]))
        $info = $_SESSION["account"];
    else
        $info = [];

    echo json_encode($info);
}
