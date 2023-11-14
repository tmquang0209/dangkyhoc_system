<?php
include_once(dirname(__DIR__) . "/models/db.php");
class Semester extends DB
{
    public function __construct()
    {
    }

    public function getSemesterList($time = "")
    {
        $stmt = $this->connect();
        if($time == "")
            $query = $stmt->prepare("SELECT S.*, start_date, end_date FROM semester S LEFT JOIN semester_register SR ON S.semester_id = SR.semester_id");
        else
            $query = $stmt->prepare("SELECT S.*, start_date, end_date FROM semester S LEFT JOIN semester_register SR ON S.semester_id = SR.semester_id WHERE CURRENT_DATE BETWEEN start_date AND end_date");
        
        $query->execute();
        return $query->fetchAll();
    }

    public function getSemester($id)
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("SELECT S.*, start_date, end_date FROM semester S LEFT JOIN semester_register SR ON S.semester_id = SR.semester_id WHERE S.semester_id = ?");
        $query->execute([$id]);
        return $query->fetch();
    }
    
    public function checkTime($id){
        $stmt = $this->connect();
        $query = $stmt->prepare("SELECT * FROM semester_register WHERE semester_id = ? AND CURRENT_DATE BETWEEN start_date AND end_date");
        $query->execute([$id]);
        return $query->rowCount();
    }

    public function addSemester($name, $year, $cash, $start, $end)
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("INSERT INTO semester (semester_name, year, cash) VALUES (?, ?, ?)");
        $query->execute([$name, $year, $cash]);
        
        $lastID = $stmt->lastInsertId();
        $query = $stmt->prepare("INSERT INTO semester_register (semester_id, start_date, end_date) VALUES (?, ?, ?)");
        $query->execute([$lastID, $start, $end]);
        return $stmt->lastInsertId();
    }

    public function editSemester($id, $name, $year, $tuition, $start, $end)
    {
        if ($this->getSemester($id)) {
            $stmt = $this->connect();
            $query = $stmt->prepare("UPDATE semester SET `semester_name` = ?, `year` = ?, `cash` = ? WHERE semester_id = ?");
            $query->execute([$name, $year, $tuition, $id]);
            
            $query = $stmt->prepare("SELECT semester_id FROM semester_register WHERE semester_id = ?");
            $query->execute([$id]);
            $fetch = $query->fetch();
            if($fetch)
            {
                $query = $stmt->prepare("UPDATE `semester_register` SET `start_date`=?,`end_date`=? WHERE `semester_id` = ?");
                $query->execute([$start, $end, $id]);
            }else{
                $query = $stmt->prepare("INSERT INTO `semester_register` (`semester_id`, `start_date`, `end_date`) VALUES (?, ?, ?)");
                $query->execute([$id, $start, $end]);
            }
            
            return 1;
        }
        return -1;
    }

    public function deleteSemester($id)
    {
        if ($this->getSemester($id)) {
            $stmt = $this->connect();
            $query = $stmt->prepare("DELETE FROM semester WHERE id = ?");
            $query->execute([$id]);
            return 1;
        }
        return -1;
    }

    public function getFee($semesterID)
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("SELECT cash FROM semester WHERE semester_id = ?");
        $query->execute([$semesterID]);

        return $query->fetch()["cash"];
    }

    public function updateFee($semesterID, $value)
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("UPDATE semester SET cash = ? WHERE semester_id = ?");
        $query->execute([$value, $semesterID]);
    }
}
