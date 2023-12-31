<?php
require_once(dirname(__DIR__) . "/models/db.php");

class Subject extends DB
{
    public function __construct()
    {
    }

    public function getSubjectList()
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("SELECT * FROM subject");
        $query->execute();
        return $query->fetchAll();
    }

    public function getSubjectInfo($subCode)
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("SELECT * FROM subject WHERE subject_code = ?");
        $query->execute([$subCode]);
        return $query->fetchAll();
    }

    public function addSubject($subCode, $subName, $credits, $coef)
    {
        $creditsVal = ($credits == -1) ? 1 : $credits;
        $coefVal = ($coef == -1) ? 1 : $coef;

        $stmt = $this->connect();
        $queryCheckSubject = $stmt->prepare("SELECT subject_code FROM subject WHERE subject_code = ?");

        $queryCheckSubject->execute([$subCode]);
        $result = $queryCheckSubject->fetch();
        if (!$result) {
            $querySubject = $stmt->prepare("INSERT INTO subject (subject_code, subject_name, credits, coef) VALUES (?, ?, ?, ?)");
            $querySubject->execute([$subCode, $subName, $creditsVal, $coefVal]);
        }
    }

    public function updateSubjectInfo($subjectUpdate, $subCode, $subName, $credits, $coef)
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("UPDATE `subject` SET `subject_code` = ?, `subject_name` = ?, `credits` = ?, `coef` = ? WHERE `subject_code` = ?");
        $query->execute([$subCode, $subName, $credits, $coef, $subjectUpdate]);
    }

    public function deleteSubjectInfo($id)
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("DELETE FROM `subject` WHERE `subject_code` = ?");
        $query->execute([$id]);
        $query->debugDumpParams();
    }
}
