<?php
require_once(dirname(__DIR__) . "/system/db.php");

class Semester extends DB
{
    public function __construct()
    {
    }

    public function getSemesterList()
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("SELECT * FROM semester");
        $query->execute();
        return $query->fetchAll();
    }

    public function getSemester($id)
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("SELECT * FROM semester WHERE id = ?");
        $query->execute([$id]);
        return $query->fetch();
    }

    public function addSemester($name, $year)
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("INSERT INTO semester (semester_name, year) VALUES (?, ?)");
        $query->execute([$name, $year]);
        return $stmt->lastInsertId();
    }

    public function editSemester($id, $name, $year)
    {
        if ($this->getSemester($id)) {
            $stmt = $this->connect();
            $query = $stmt->prepare("UPDATE semester SET `semester_name` = ?, `year` = ? WHERE id = ?");
            $query->execute([$name, $year, $id]);
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
}
