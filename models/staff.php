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

    public function updateInfo($staffCode, $staffName, $birthday, $mobilePhone, $address)
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("UPDATE `staff` SET `staff_name`=?,`birthday`=?,`phone_number`=?,`address`=? WHERE `staff_code` = ?");
        $query->execute([$staffName, $birthday, $mobilePhone, $address, $staffCode]);
    }

    public function add($staffCode, $staffName, $password, $birthday, $mobilePhone, $address)
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("INSERT INTO `staff`(`staff_code`, `staff_name`, `password`, `birthday`, `phone_number`, `address`) VALUES (?,?,?,?,?,?)");
        $query->execute([$staffCode, $staffName, $password, $birthday, $mobilePhone, $address]);
    }

    public function getList()
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("SELECT * FROM `staff`");
        $query->execute();

        return $query->fetchAll();
    }
}
