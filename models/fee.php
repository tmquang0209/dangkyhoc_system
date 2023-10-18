<?php
include_once dirname(__DIR__) . "/vendor/autoload.php";
include_once dirname(__DIR__) . "/models/schedule.php";

class Fee extends DB
{
    public function __construct()
    {
    }

    public function getFee($semester)
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("SELECT cash FROM semester WHERE semester_id = ?");
        $query->execute([$semester]);
        return $query->fetch()["cash"];
    }

    public function setFee($semester, $value)
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("UPDATE semester SET cash = ? WHERE semester_id = ?");
        $query->execute([$value, $semester]);
    }

    // public function getFee
}
