<?php
include_once dirname(__DIR__) . "/models/db.php";

class Teacher extends DB
{
    public function __construct()
    {
    }

    public function getInfo($teacherCode)
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("SELECT * FROM `teacher` WHERE `teacher_code` = ?");
        $query->execute([$teacherCode]);

        return $query->fetch();
    }

    public function updateInfo($teacherCode, $teacherName, $birthday, $mobilePhone, $address)
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("UPDATE `teacher` SET `teacher_name`=?,`birthday`=?,`phone_number`=?,`address`=? WHERE `teacher_code` = ?");
        $query->execute([$teacherName, $birthday, $mobilePhone, $address, $teacherCode]);
    }

    public function add($teacherCode, $teacherName, $password, $birthday, $mobilePhone, $address)
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("INSERT INTO `teacher`(`teacher_code`, `teacher_name`, `password`, `birthday`, `phone_number`, `address`) VALUES (?,?,?,?,?,?)");
        $query->execute([$teacherCode, $teacherName, $password, $birthday, $mobilePhone, $address]);
    }

    public function getList()
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("SELECT * FROM `teacher`");
        $query->execute();

        return $query->fetchAll();
    }
}
