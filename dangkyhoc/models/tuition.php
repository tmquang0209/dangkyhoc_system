<?php
include_once dirname(__DIR__) . "/system/db.php";
include_once dirname(__DIR__) . "/models/fee.php";

class Tuition extends DB
{
    public function __construct()
    {
    }

    public function addTuition($semesterID)
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("SELECT student_code, semester_id, subject.subject_code, credits, coef FROM enroll JOIN schedule ON enroll.schedule_id = schedule.id JOIN subject ON schedule.subject_code = subject.subject_code WHERE semester_id = ?");
        $query->execute([$semesterID]);
        $dataQuery = $query->fetchAll();

        $fee = new Fee();
        $feeCost = $fee->getFee();

        foreach ($dataQuery as $row) {
            // Check if the data already exists in the tuition table
            $checkQuery = $stmt->prepare("SELECT COUNT(*) as count FROM tuition WHERE student_code = ? AND semester_id = ? AND subject_code = ?");
            $checkQuery->execute([$row["student_code"], $row["semester_id"], $row["subject_code"]]);
            $result = $checkQuery->fetch();

            // If no matching record is found, insert the data
            if ($result["count"] == 0) {
                $insertQuery = $stmt->prepare("INSERT INTO tuition (`student_code`, `semester_id`, `subject_code`, `credits`, `coef`, `cost`, `date_create`) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $insertQuery->execute([$row["student_code"], $row["semester_id"], $row["subject_code"], $row["credits"], $row["coef"], $feeCost, date("Y-m-d H:i:s")]);
            }
        }
    }


    public function delTuition()
    {
    }

    public function getTuition($studentCode)
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("SELECT student.student_code, semester_id, CONCAT(semester.semester_name,' năm học ', semester.year) AS semester_name, SUM(credits) AS total_credits, SUM(credits*coef*cost) AS total_fee, status FROM `tuition` JOIN semester ON tuition.semester_id = semester.id JOIN student ON tuition.student_code = student.student_code WHERE student.student_code = ? GROUP BY semester.semester_name;");
        $query->execute([$studentCode]);
        return $query->fetchAll();
    }

    public function getTuitionDetail($studentCode, $semesterID)
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("SELECT S.subject_code, subject_name, T.credits, T.coef, cost, (T.credits*T.coef*cost) as total, status FROM `tuition` T JOIN `subject` S ON T.subject_code = S.subject_code WHERE student_code = ? AND semester_id = ?");
        $query->execute([$studentCode, $semesterID]);
        return $query->fetchAll();
    }

    public function calcTotalTuition($studentCode)
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("SELECT SUM(credits*coef*cost) as total FROM tuition WHERE student_code = ?");
        $query->execute([$studentCode]);
        return $query->fetch()["total"];
    }

    public function calcTuitionBySemester($studentCode, $semesterID)
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("SELECT SUM(credits*coef*cost) as total FROM tuition WHERE student_code = ? AND semester_id = ?");
        $query->execute([$studentCode, $semesterID]);
        return $query->fetch()["total"];
    }
}
