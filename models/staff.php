<?php
include_once dirname(__DIR__) . "/models/db.php";

class Staff extends DB
{
    public function __construct()
    {
    }

    public function getInfo($staffCode)
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("SELECT * FROM `staff` WHERE `staff_code` = ?");
        $query->execute([$staffCode]);

        return $query->fetch();
    }

    public function updateInfo($staffCode, $staffName, $birthday, $mobilePhone, $address, $email)
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("UPDATE `staff` SET `staff_name` = ?,`birthday` = ?, `phone_number` = ?, `address` = ?, `email` = ? WHERE `staff_code` = ?");
        $query->execute([$staffName, $birthday, $mobilePhone, $address, $email, $staffCode]);
    }
    
    public function updateInfoPer($staffCode, $mobilePhone, $address, $email)
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("UPDATE `staff` SET `phone_number` = ?, `address` = ?, `email` = ? WHERE `staff_code` = ?");
        $query->execute([$mobilePhone, $address, $email, $staffCode]);
    }
    
    public function updatePassword($staffCode, $password)
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("UPDATE `staff` SET `password` = ? WHERE `staff_code` = ?");
        $query->execute([$password, $staffCode]);
    }

    public function add($staffCode, $staffName, $password, $birthday, $mobilePhone, $address, $email)
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("INSERT INTO `staff`(`staff_code`, `staff_name`, `password`, `birthday`, `phone_number`, `address`, `email`) VALUES (?,?,?,?,?,?,?)");
        $query->execute([$staffCode, $staffName, $password, $birthday, $mobilePhone, $address, $email]);
    }

    public function getList()
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("SELECT * FROM `staff`");
        $query->execute();

        return $query->fetchAll();
    }
}
