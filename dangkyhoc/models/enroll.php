<?php
include "../vendor/autoload.php";
require_once(dirname(__DIR__) . "/system/db.php");
require_once("schedule.php");

class Enroll extends DB
{
    public function __construct()
    {
    }

    public function getEnroll($semesterID, $studentCode)
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("SELECT semester_id, student_code, SJ.subject_code, subject_name, 
         S.id, S.class_name, credits, coef FROM enroll E JOIN schedule S ON E.schedule_id = S.id JOIN subject SJ ON S.subject_code = SJ.subject_code WHERE `student_code` = ? AND `semester_id` = ?");
        $query->execute([$studentCode, $semesterID]);

        return $query->fetchAll();
    }

    public function getClassListByID($id)
    {
        $stmt  = $this->connect();
        $query = $stmt->prepare("SELECT * FROM schedule WHERE id = ?");
        $query->execute([$id]);
        return $query->fetchAll();
    }

    // public function getClassByClassName($className)
    // {
    //     $stmt = $this->connect();
    //     $query = $stmt->prepare("SELECT group_id, subject_code, class_name, GROUP_CONCAT(day, ', ') as DAY, GROUP_CONCAT(shift, ', ') as SHIFT, GROUP_CONCAT(classroom, ', ') as CLASSROOM, GROUP_CONCAT(teacher, ', ') FROM `schedule` WHERE class_name = ? GROUP BY class_name");
    //     $query->execute([$className]);
    //     return $query->fetchAll();
    // }

    public function getMainClass($className)
    {
        // Tách phần con của tên lớp sau dấu chấm
        $parts = explode('.', $className);

        // Kiểm tra xem phần con cuối cùng có chứa '_BT' hoặc '_LT' không
        $lastPart = end($parts);
        if (strpos($lastPart, '_BT') !== false || strpos($lastPart, '_LT') !== false) {
            // Thay thế phần con cuối cùng bằng '_LT'
            $parts[count($parts) - 1] = 'LT';
        }

        // Ghép các phần lại thành tên main class
        $mainClass = implode('.', $parts);

        return $mainClass;
    }


    public function getClassByClassName($className)
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("SELECT group_id, subject_code, class_name, GROUP_CONCAT(day, ',') as DAY, GROUP_CONCAT(shift, ',') as SHIFT, GROUP_CONCAT(classroom, ',') as CLASSROOM, GROUP_CONCAT(teacher, ',') as TEACHER
FROM `schedule`
WHERE class_name = ?
GROUP BY class_name");
        $query->execute([$className]);
        // $query->debugDumpParams();
        $classes = [];
        foreach ($query->fetchAll() as $row) {
            $classes[] = [
                "MainClass" => $this->getMainClass($row["class_name"]) ?? null,
                "ClassName" => $row["class_name"],
                "Day" => $row["DAY"],
                "Shift" => $row["SHIFT"],
                "Classroom" => $row["CLASSROOM"],
                "Teacher" => $row["TEACHER"],
            ];
        }

        return $classes;
    }

    public function addEnroll($semesterID, $studentCode, $subjectCode, $schedule_id)
    {
        $stmt = $this->connect();
        $queryCheck = $stmt->prepare("SELECT `schedule_id` FROM `enroll` E JOIN `schedule` S ON E.schedule_id = S.id WHERE subject_code = ?");
        $queryCheck->execute([$subjectCode]);
        $resCheck = $queryCheck->rowCount();
        if ($resCheck == 0) {

            $query = $stmt->prepare("INSERT INTO `enroll` (`student_code`, `semester_id`, `schedule_id`) VALUES (?,?,?)");
            $query->execute([$studentCode, $semesterID, $schedule_id]);
        } else {
            $query = $stmt->prepare("UPDATE `enroll` SET `student_code` = ?, `semester_id` = ?, `schedule_id` = ? WHERE `schedule_id` = ?");
            $query->execute([$studentCode, $semesterID, $schedule_id, $queryCheck->fetch()["schedule_id"]]);
        }
        // $query->debugDumpParams();
    }

    public function deleteEnroll($semesterID, $studentCode, $data)
    {
        $schedule = new Schedule();
        $scheduleID = $schedule->getClassByClassName($data)["id"];
        $stmt = $this->connect();
        $query = $stmt->prepare("DELETE FROM enroll WHERE semester_id = ? AND student_code = ? AND schedule_id = ?");
        $query->execute([$semesterID, $studentCode, $scheduleID]);
    }
}

function enrollToClass($semesterID, $studentCode, $studentName, $data)
{
}


if (isset($_GET["save"])) {
    $enroll = new Enroll();
    $schedule = new Schedule();

    $data = file_get_contents('php://input'); // Retrieve the JSON data from the request body
    $jsonData = json_decode($data, true); // Decode JSON into aưn associative array
    // echo $data;
    $semesterID = $jsonData["semesterid"];
    $studentCode = $jsonData["studentCode"];
    $studentName = $jsonData["studentName"];

    // echo $semesterID;
    // echo $studentCode;
    // echo $studentName;

    // Check if decoding was successful
    if ($jsonData !== null) {
        foreach ($jsonData["data"] as $row) {
            foreach ($row["ClassList"] as $val) {
                // echo $val["ClassName"] . " ";
                $getClassID = $schedule->getClassByClassName($val["ClassName"])["id"];
                $enroll->addEnroll($semesterID, $studentCode, $row["SubID"], $getClassID);
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
    $studentCode = $jsonData["studentCode"];
    // echo json_encode($jsonData);
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

    $semesterID = $jsonData["semesterid"];
    $studentCode = $jsonData["studentCode"];
    $dataDel = $jsonData["data"];

    foreach ($dataDel["ClassList"] as $row) {
        $enroll->deleteEnroll($semesterID, $studentCode, $row["ClassName"]);
    }
}
