<?php
include_once dirname(__DIR__) . "/models/db.php";
include_once dirname(__DIR__) . "/models/semester.php";

class Tuition extends DB
{
    public function __construct()
    {
    }

    public function addTuition($semesterID)
    {
        $stmt = $this->connect();

        // Prepare the initial query to fetch data
        $query = $stmt->prepare("SELECT student_code, semester_id, subject.subject_code, credits, coef
                            FROM enroll
                            JOIN schedule ON enroll.schedule_id = schedule.id
                            JOIN subject ON schedule.subject_code = subject.subject_code
                            WHERE semester_id = ?");
        $query->execute([$semesterID]);
        $data = $query->fetchAll();

        foreach ($data as $row) {
            // Check if tuition details already exist for the student, semester, and subject
            $checkQuery = $stmt->prepare("SELECT T.tuition_id
                                        FROM tuition T
                                        JOIN tuition_detail TD ON T.tuition_id = TD.tuition_id
                                        WHERE student_code = ? AND semester_id = ? AND subject_code = ?");
            $checkQuery->execute([$row["student_code"], $row["semester_id"], $row["subject_code"]]);
            $result = $checkQuery->fetch();

            if (!$result) {
                // Tuition details don't exist, so we need to insert them
                $tuitionID = $this->getTuitionID($stmt, $row["student_code"], $semesterID);

                $query = $stmt->prepare("INSERT INTO `tuition_detail`(`tuition_id`, `subject_code`, `credits`, `coef`) VALUES (?, ?, ?, ?)");
                $query->execute([$tuitionID, $row["subject_code"], $row["credits"], $row["coef"]]);
            }
        }
    }

    // Function to get or create a tuition entry for a student in a semester
    private function getTuitionID($stmt, $studentCode, $semesterID)
    {
        $check = $stmt->prepare("SELECT tuition_id FROM tuition WHERE student_code = ? AND semester_id = ?");
        $check->execute([$studentCode, $semesterID]);
        $resultCheck = $check->fetch();

        if ($resultCheck) {
            return $resultCheck["tuition_id"];
        } else {
            $insertQuery = $stmt->prepare("INSERT INTO tuition (`student_code`, `semester_id`) VALUES (?, ?)");
            $insertQuery->execute([$studentCode, $semesterID]);

            return $stmt->lastInsertId();
        }
    }



    public function delTuition()
    {
    }

    public function getTuitionSemester($semesterID)
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("SELECT T.tuition_id, S.student_code, S.student_name, SUM(TD.credits*TD.coef*SM.cash) AS total_tuition, T.status FROM tuition T JOIN tuition_detail TD ON T.tuition_id = TD.tuition_id JOIN student S ON T.student_code = S.student_code JOIN semester SM ON T.semester_id = SM.semester_id WHERE SM.semester_id = ? GROUP BY T.tuition_id, S.student_code, S.student_name");
        $query->execute([$semesterID]);
        return $query->fetchAll();
    }

    public function getTuitionByID($tuitionID)
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("SELECT T.tuition_id, T.student_code, T.semester_id, T.status, T.date_create, S.semester_name, S.year, ST.student_name, SUM(TD.credits*TD.coef*S.cash) AS total_tuition FROM tuition T JOIN tuition_detail TD ON T.tuition_id = TD.tuition_id JOIN semester S ON T.semester_id = S.semester_id JOIN student ST ON T.student_code = ST.student_code WHERE T.tuition_id = ? GROUP BY T.tuition_id, T.student_code, T.semester_id, T.status, T.date_create, S.semester_name, S.year, ST.student_name");
        $query->execute([$tuitionID]);
        return $query->fetch();
    }

    public function getTuition($studentCode)
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("SELECT T.tuition_id, SM.semester_name, SM.year, S.student_code, S.student_name, SUM(TD.credits*TD.coef*SM.cash) AS total_tuition, T.status FROM tuition T JOIN tuition_detail TD ON T.tuition_id = TD.tuition_id JOIN student S ON T.student_code = S.student_code JOIN semester SM ON T.semester_id = SM.semester_id WHERE T.student_code = ? GROUP BY T.tuition_id, S.student_code, S.student_name");
        $query->execute([$studentCode]);
        return $query->fetchAll();
    }

    public function getTuitionDetail($tuitionID)
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("SELECT S.subject_code, subject_name, TD.credits, TD.coef, SM.cash, (TD.credits*TD.coef*SM.cash) as total, status FROM `tuition` T JOIN tuition_detail TD ON T.tuition_id = TD.tuition_id JOIN `subject` S ON TD.subject_code = S.subject_code JOIN semester SM ON T.semester_id = SM.semester_id WHERE T.tuition_id = ?");
        $query->execute([$tuitionID]);
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
