<?php
include "../vendor/autoload.php";
require_once(dirname(__DIR__) . "/system/db.php");

class Account extends DB
{
    public function __construct()
    {
    }

    public function getStudentList()
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("SELECT * FROM student");
        $query->execute();
        return $query->fetchAll();
    }

    public function getStudentInfo($studentCode)
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("SELECT * FROM student WHERE student_code = ?");
        $query->execute([$studentCode]);
        return $query->fetch();
    }


    public function checkAccountStudent($studentCode, $studentName)
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("SELECT * FROM student WHERE student_code = ?");
        $query->execute([$studentCode]);

        $fetch = $query->fetch();

        if (!$fetch) {
            // No matching row found
            return -1;
        } else if ($fetch["student_name"] != $studentName) {
            // Matching row found, but the student_name does not match
            return -2;
        } else {
            // Both student_code and student_name match
            return 1;
        }
    }

    public function addAccount($studentCode, $studentName)
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("INSERT INTO student (`student_code`,`student_name`) VALUES (?, ?)");
        $query->execute([$studentCode, $studentName]);
    }
}

if (isset($_GET["check_student"])) {
    $account = new Account();
    $data = file_get_contents('php://input'); // Retrieve the JSON data from the request body
    $jsonData = json_decode($data, true); // Decode JSON into an associative array
    // echo $data;
    // var_dump($jsonData);
    $studentCode = $jsonData["studentCode"];
    $studentName = $jsonData["studentName"];
    $check = $account->checkAccountStudent($studentCode, $studentName);

    if ($check == -1) {
        $account->addAccount($studentCode, $studentName);
        echo 1;
    } else {
        echo $check;
    }
}
