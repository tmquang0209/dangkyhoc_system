<?php
include_once dirname(__DIR__) . "/models/db.php";

class Student extends DB
{
    public function __construct()
    {
    }

    public function getInfo($studentCode)
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("SELECT S.*, C.classroom_code, C.consultant as consultant_code, T.teacher_name as consultant_name FROM `student` S LEFT JOIN classroom C ON S.classroom_code = C.classroom_code LEFT JOIN teacher T ON C.consultant = T.teacher_code WHERE S.student_code = ?");
        $query->execute([$studentCode]);
        // $query->debugDumpParams();

        return $query->fetch();
    }

    public function updateInfo($studentCode, $studentName, $birthday, $mobilePhone, $address)
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("UPDATE `student` SET `student_name`=?,`birthday`=?,`phone_number`=?,`address`=? WHERE `student_code` = ?");
        $query->execute([$studentName, $birthday, $mobilePhone, $address, $studentCode]);
    }

    public function add($studentCode, $studentName, $password, $birthday, $mobilePhone, $address)
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("INSERT INTO `student`(`student_code`, `student_name`, `password`, `birthday`, `phone_number`, `address`) VALUES (?,?,?,?,?,?)");
        $query->execute([$studentCode, $studentName, $password, $birthday, $mobilePhone, $address]);
    }

    public function getList()
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("SELECT * FROM `student`");
        $query->execute();

        return $query->fetchAll();
    }
}
