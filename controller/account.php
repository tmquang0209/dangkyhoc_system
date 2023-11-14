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
                if ($check["password"] == md5($password)) {
                    $_SESSION["account"] = $check;
                    echo json_encode(["success" => true, "message" => "Login success.", "info" => $_SESSION["account"]]);
                    
                } else {
                    echo json_encode(["success" => false, "message" => "Password is incorrect.", "pass"=>$password, "check"=>md5($password)]);
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
}else if(isset($_GET["updateInfo"])){
    $address = $_POST["address"];
    $phoneNumber = $_POST["phoneNumber"];
    $email = $_POST["email"];
    
    if(isset($_SESSION["account"]["staff_code"])){
        $staff->updateInfoPer($_SESSION["account"]["staff_code"], $phoneNumber, $address, $email);
    }else if(isset($_SESSION["account"]["teacher_code"])){
        $teacher->updateInfoPer($_SESSION["account"]["teacher_code"], $phoneNumber, $address, $email);
    }else if(isset($_SESSION["account"]["student_code"])){
        $student->updateInfoPer($_SESSION["account"]["student_code"], $phoneNumber, $address, $email);
    }
    $_SESSION["account"]["password"] = $hashPwd;
     echo json_encode(["success" => true, "message" => "Đổi mật khẩu thành công"]);
    exit;
    
}else if(isset($_GET["changePassword"])){
    $oldPwd = $_POST["oldPwd"];
    $newPwd = $_POST["newPwd"];
    $reNewPwd = $_POST["reNewPwd"];
    
    if(empty($oldPwd) || empty($newPwd) || empty($reNewPwd)){
        echo json_encode(["success" => false, "message" => "Vui lòng nhập đủ thông tin"]);
        exit;
    }
    
    if(md5($oldPwd) != $_SESSION["account"]["password"]){
        echo json_encode(["success" => false, "message" => "Mật khẩu cũ không chính xác"]);
        exit;
    }
    
    if($newPwd != $reNewPwd){
        echo json_encode(["success" => false, "message" => "Mật khẩu mới không giống nhau"]);
        exit;
    }
    
    $hashPwd = md5($newPwd);
    
    if(isset($_SESSION["account"]["staff_code"])){
        $staff->updatePassword($_SESSION["account"]["staff_code"], $hashPwd);
    }else if(isset($_SESSION["account"]["teacher_code"])){
        $teacher->updatePassword($_SESSION["account"]["teacher_code"], $hashPwd);
    }else if(isset($_SESSION["account"]["student_code"])){
        $student->updatePassword($_SESSION["account"]["student_code"], $hashPwd);
    }
    $_SESSION["account"]["password"] = $hashPwd;
     echo json_encode(["success" => true, "message" => "Đổi mật khẩu thành công"]);
    exit;
} else if (isset($_GET["staffList"])) {
    // if (!isset($_SESSION["account"]["staff_code"])) exit;
    echo json_encode(["result" => $staff->getList()]);
} else if (isset($_GET["teacherList"])) {
    // if (!isset($_SESSION["account"]["staff_code"])) exit;
    echo json_encode(["result" => $teacher->getList()]);
} else if (isset($_GET["studentList"])) {
    // if (!isset($_SESSION["account"]["staff_code"])) exit;
    echo json_encode(["result" => $student->getList()]);
} else if (isset($_GET["updateStaff"])) {
    // if (!isset($_SESSION["account"]["staff_code"])) exit;

    $staffCode = $_POST["staffCode"];
    $staffName = $_POST["staffName"];
    $birthday = $_POST["birthday"];
    $address = $_POST["address"];
    $email = $_POST["email"];
    $mobileNumber = $_POST["mobileNumber"];

    $staff->updateInfo($staffCode, $staffName, $birthday, $mobileNumber, $address, $email);
} else if (isset($_GET["addStaff"])) {
    $staffCode = $_POST["staffCode"];
    $staffName = $_POST["staffName"];
    $password = $_POST["password"];
    $birthday = $_POST["birthday"];
    $address = $_POST["address"];
    $email = $_POST["email"];
    $mobileNumber = $_POST["mobileNumber"];

    $staff->add($staffCode, $staffName, md5($password), $birthday, $mobileNumber, $address, $email);
} else if (isset($_GET["updateTeacher"])) {
    // if (!isset($_SESSION["account"]["staff_code"])) exit;

    $teacherCode = $_POST["teacherCode"];
    $teacherName = $_POST["teacherName"];
    $birthday = $_POST["birthday"];
    $address = $_POST["address"];
    $email = $_POST["email"];
    $mobileNumber = $_POST["mobileNumber"];

    $teacher->updateInfo($teacherCode, $teacherName, $birthday, $mobileNumber, $address, $email);
} else if (isset($_GET["addTeacher"])) {
    $teacherCode = $_POST["teacherCode"];
    $teacherName = $_POST["teacherName"];
    $password = $_POST["password"];
    $birthday = $_POST["birthday"];
    $address = $_POST["address"];
    $email = $_POST["email"];
    $mobileNumber = $_POST["mobileNumber"];

    $teacher->add($teacherCode, $teacherName, md5($password), $birthday, $mobileNumber, $address, $email);
} else if (isset($_GET["updateStudent"])) {
    // if (!isset($_SESSION["account"]["staff_code"])) exit;

    $studentCode = $_POST["studentCode"];
    $studentName = $_POST["studentName"];
    $birthday = $_POST["birthday"];
    $address = $_POST["address"];
    $email = $_POST["email"];
    $mobileNumber = $_POST["mobileNumber"];

    $student->updateInfo($studentCode, $studentName, $birthday, $mobileNumber, $address, $email);
} else if (isset($_GET["addStudent"])) {
    $studentCode = $_POST["studentCode"];
    $studentName = $_POST["studentName"];
    $password = $_POST["password"];
    $birthday = $_POST["birthday"];
    $address = $_POST["address"];
    $email = $_POST["email"];
    $mobileNumber = $_POST["mobileNumber"];

    $student->add($studentCode, $studentName, md5($password), $birthday, $mobileNumber, $address, $email);
}
