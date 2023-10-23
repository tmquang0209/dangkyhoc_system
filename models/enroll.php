<?php
include "../vendor/autoload.php";
require_once(dirname(__DIR__) . "/models/db.php");
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
        $checkEnd = strpos($className, "_BT");
        if ($checkEnd !== false) {
            $parts = explode($className, ".");
            return str_replace("." . end($parts), "_LT", $className);
        }
        return null;
    }



    public function getClassByClassName($className)
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("SELECT semester_id, subject_code, class_name, GROUP_CONCAT(day, ',') as DAY, GROUP_CONCAT(shift, ',') as SHIFT, GROUP_CONCAT(classroom, ',') as CLASSROOM, GROUP_CONCAT(T.teacher_name, '(',T.teacher_code ,'),') as TEACHER
FROM `schedule` S JOIN teacher T ON S.teacher_code = T.teacher_code
WHERE class_name = ?
GROUP BY class_name");
        $query->execute([$className]);
        // $query->debugDumpParams();
        $classes = [];
        foreach ($query->fetchAll() as $row) {
            $mainClassName = $this->getMainClass(($row["class_name"]));
            $classes[] = [
                "MainClass" => $mainClassName ?? null,
                "ClassName" => $row["class_name"],
                "Day" => $row["DAY"],
                "Shift" => $row["SHIFT"],
                "Classroom" => $row["CLASSROOM"],
                "Teacher" => $row["TEACHER"],
            ];
            // echo $this->getMainClass(($row["class_name"]));
            if ($mainClassName) {
                $query = $stmt->prepare("SELECT semester_id, subject_code, class_name, GROUP_CONCAT(day, ',') as DAY, GROUP_CONCAT(shift, ',') as SHIFT, GROUP_CONCAT(classroom, ',') as CLASSROOM, GROUP_CONCAT(T.teacher_name, '(',T.teacher_code ,'),') as TEACHER
FROM `schedule` S JOIN teacher T ON S.teacher_code = T.teacher_code
WHERE class_name = ?
GROUP BY class_name");
                $query->execute([$mainClassName]);
                // $query->debugDumpParams();
                $getMainClass = $query->fetch();

                $classes[] = [
                    // "MainClass" => $this->getMainClass($mainClassName) ?? null,
                    "ClassName" => $getMainClass["class_name"],
                    "Day" => $getMainClass["DAY"],
                    "Shift" => $getMainClass["SHIFT"],
                    "Classroom" => $getMainClass["CLASSROOM"],
                    "Teacher" => $getMainClass["TEACHER"],
                ];
            }
        }

        return $classes;
    }

    public function addEnroll($studentCode, $subjectCode, $scheduleId)
    {
        $stmt = $this->connect();
        $queryCheck = $stmt->prepare("SELECT `schedule_id`, `class_name` FROM `enroll` E JOIN `schedule` S ON E.schedule_id = S.id WHERE subject_code = ? AND student_code = ?");
        $queryCheck->execute([$subjectCode, $studentCode]);
        $resCheck = $queryCheck->rowCount();

        if ($resCheck == 0) {
            $query = $stmt->prepare("INSERT INTO `enroll` (`student_code`, `schedule_id`) VALUES (?,?)");
            $query->execute([$studentCode, $scheduleId]);
        } else {
            $query = $stmt->prepare("UPDATE `enroll` SET `student_code` = ?, `schedule_id` = ? WHERE `schedule_id` = ?");
            $query->execute([$studentCode, $scheduleId, $queryCheck->fetch()["schedule_id"]]);
        }

        // $query = $stmt->prepare("DELETE E FROM enroll E JOIN schedule S ON E.schedule_id = S.id WHERE subject_code = ?");
        // $query->execute([$subjectCode]);

        // if ($mainClass) {
        //     $query = $stmt->prepare("INSERT INTO `enroll` (`student_code`, `schedule_id`) VALUES (?,?)");
        //     $query->execute([$studentCode, $mainClass]);
        // }

        // $query = $stmt->prepare("INSERT INTO `enroll` (`student_code`, `schedule_id`) VALUES (?,?)");
        // $query->execute([$studentCode, $scheduleId]);
    }

    public function deleteEnroll($studentCode, $data)
    {
        $schedule = new Schedule();
        $scheduleID = $schedule->getClassByClassName($data)["id"];
        $stmt = $this->connect();
        $query = $stmt->prepare("DELETE FROM enroll WHERE student_code = ? AND schedule_id = ?");
        $query->execute([$studentCode, $scheduleID]);
    }

    public function countStudent($className)
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("SELECT COUNT(E.id) as count_student FROM enroll E JOIN schedule S ON E.schedule_id = S.id WHERE class_name = ? GROUP BY class_name");
        $query->execute([$className]);

        return $query->fetch()["count_student"];
    }
}
