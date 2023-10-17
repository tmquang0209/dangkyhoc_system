<?php
include_once("../models/teacher.php");

if (isset($_GET["listTeacher"])) {
    $teacher = new Teacher();

    $getList = $teacher->getList();

    echo json_encode($getList);
}
