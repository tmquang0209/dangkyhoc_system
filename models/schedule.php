<?php
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
        $query = $stmt->prepare("SELECT S.id, S.semester_id, S.subject_code, class_name, classroom, day, shift, num_student, subject.subject_name, subject.credits, subject.coef, teacher.teacher_code, teacher.teacher_name, COUNT(enroll.id) AS count_student FROM `schedule` S JOIN subject ON S.subject_code = subject.subject_code JOIN teacher ON S.teacher_code = teacher.teacher_code LEFT JOIN enroll ON S.id = enroll.schedule_id WHERE semester_id = ? GROUP BY S.id, S.semester_id, S.subject_code, day, shift, num_student, subject.subject_name, subject.credits, subject.coef, teacher.teacher_code, teacher.teacher_name ORDER BY subject_code ASC;");
        $query->execute([$semesterID]);
        return $query->fetchAll();
    }

    public function getTeachingSchedule($semesterID, $teacherCode)
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("SELECT schedule.id, subject.subject_code, schedule.class_name, subject.subject_name, GROUP_CONCAT('Thứ ', day, '(', shift, ')<br />') AS teaching_schedule, COUNT(enroll.id) as count_student FROM schedule JOIN subject ON schedule.subject_code = subject.subject_code LEFT JOIN enroll ON schedule.id = enroll.schedule_id WHERE semester_id = ? AND teacher_code = ? GROUP BY subject.subject_code, schedule.class_name, subject.subject_name");
        $query->execute([$semesterID, $teacherCode]);
        return $query->fetchAll();
    }
    public function getTeachingScheduleDetail($id)
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("SELECT S.student_code, S.student_name, S.birthday, S.classroom_code FROM `enroll` E JOIN `student` S ON E.student_code = S.student_code WHERE schedule_id = ?");
        $query->execute([$id]);
        return $query->fetchAll();
    }

    public function getClassByID($id)
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("SELECT S.*, T.teacher_name, SM.semester_id, SM.semester_name, SM.year FROM schedule S JOIN teacher T ON S.teacher_code = T.teacher_code JOIN semester SM ON S.semester_id = SM.semester_id WHERE id = ?");
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

    public function addClass($subCode, $subName, $groupID, $className, $day, $shift, $classroom, $numStudent, $teacher = "")
    {
        $stmt = $this->connect();
        $queryCheck = $stmt->prepare("SELECT class_name FROM schedule WHERE `semester_id` = ? AND `class_name`= ? AND `day` = ? AND `shift`= ? AND `classroom` = ?");
        $queryCheck->execute([$groupID, $className, $day, $shift, $classroom]);

        // Fetch the result as an associative array
        $row = $queryCheck->rowCount();

        // Check if a row was returned and if 'class_name' exists in the result
        if ($row == 0) {
            $subject = new Subject();
            $subject->addSubject($subCode, $subName, -1, -1);

            $teacherName = explode("(", $teacher)[0];
            $teacherCode = explode("(", $teacher)[1];
            $teacherCode = str_replace(")", "", $teacherCode);

            $queryTeacher = $stmt->prepare("SELECT `teacher_code` FROM `teacher` WHERE `teacher_code` = ?");
            $queryTeacher->execute([$teacherCode]);
            $fetchTeacher = $queryTeacher->fetch();
            if (!$fetchTeacher) {
                $queryInsertTeacher = $stmt->prepare("INSERT INTO `teacher`(`teacher_code`, `teacher_name`, `password`) VALUES (?, ?, ?)");
                $queryInsertTeacher->execute([$teacherCode, $teacherName, "e10adc3949ba59abbe56e057f20f883e"]);
            }


            $query = $stmt->prepare("INSERT INTO schedule (`semester_id`, `subject_code`, `class_name`, `day`, `shift`, `classroom`, `teacher_code`, `num_student`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $query->execute([$groupID, $subCode, $className, $day, $shift, $classroom, $teacherCode, $numStudent]);
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
