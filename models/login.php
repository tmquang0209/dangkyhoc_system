<?php
include_once("db.php");

if (isset($_GET["checkAccount"])) {

    $responseData = ["msgCode" => 1, "message" => "login success"];

    echo json_encode($responseData);
}
