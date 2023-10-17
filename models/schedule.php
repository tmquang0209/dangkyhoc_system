﻿<?php
include_once dirname(__DIR__) . "/models/db.php";
include_once dirname(__DIR__) . "/vendor/autoload.php";
include_once dirname(__DIR__) . "/models/subject.php";

class Schedule extends DB
{

    public function __construct()
    {
    }

    public function getSchedule($semesterID)
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("SELECT schedule.*, subject.subject_name, subject.credits, subject.coef, teacher.teacher_code, teacher.teacher_name FROM schedule JOIN subject ON schedule.subject_code = subject.subject_code JOIN teacher ON schedule.teacher_code = teacher.teacher_code WHERE semester_id = ? ORDER BY subject_code ASC");
        $query->execute([$semesterID]);
        // return $query->debugDumpParams();
        return $query->fetchAll();
    }

    public function getClassByID($id)
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("SELECT S.*, T.teacher_name FROM schedule S JOIN teacher T ON S.teacher_code = T.teacher_code WHERE id = ?");
        $query->execute([$id]);
        return $query->fetch();
    }

    public function getClassByClassName($name)
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("SELECT * FROM schedule WHERE class_name = ?");
        $query->execute([$name]);
        return $query->fetch();
    }

    public function addClass($subCode, $subName, $credits, $coef, $groupID, $className, $day, $shift, $classroom, $teacher = "")
    {
        $stmt = $this->connect();
        $queryCheck = $stmt->prepare("SELECT class_name FROM schedule WHERE `group_id` = ? AND `class_name`= ? AND `day` = ? AND `shift`= ? AND `classroom` = ?");
        $queryCheck->execute([$groupID, $className, $day, $shift, $classroom]);

        // Fetch the result as an associative array
        $row = $queryCheck->rowCount();

        // Check if a row was returned and if 'class_name' exists in the result
        if ($row == 0) {
            $subject = new Subject();
            $subject->addSubject($subCode, $subName, $credits, $coef);

            $query = $stmt->prepare("INSERT INTO schedule (`group_id`, `subject_code`, `class_name`, `day`, `shift`, `classroom`, `teacher`) VALUES (?,?,?,?,?,?,?)");
            $query->execute([$groupID, $subCode, $className, $day, $shift, $classroom, $teacher]);
        }
    }


    public function updateSchedule($classID, $day, $shift, $classroom, $numStudent, $teacherCode)
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("UPDATE `schedule` SET `day`= ?,`shift`= ?,`classroom`= ?, `num_student` = ?, `teacher_code`= ? WHERE id = ?");
        $query->execute([$day, $shift, $classroom, $teacherCode, $numStudent, $classID]);
    }

    public function convertData()
    {
        $stmt = $this->connect();
        $data = file_get_contents("./data/155.txt");

        // Convert JSON string to an array
        $dataArray = json_decode($data, true);

        // Check if decoding was successful
        if ($dataArray === null) {
            // Handle the JSON parsing error
            echo "JSON parsing error!";
        } else {
            // Access elements in the array
            foreach ($dataArray as $item) {
                $query = $stmt->prepare("INSERT INTO schedule(`group_id`, `subject_code`, `class_name`, `day`, `shift`, `classroom`, `teacher`) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $query->execute([3, $item["SubID"], $item["ClassName"], $item["Day"], $item["Shift"], $item["Classroom"], $item["Teacher"]]);
            }
        }
    }
}
