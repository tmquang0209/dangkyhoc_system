<?php
date_default_timezone_set("Asia/Ho_Chi_Minh");

class DB
{
    private $serverName = "localhost";
    private $databaseName = "dangkyhoc";
    private $databaseUser = "root";
    private $databasePassword = "";

    public function connect()
    {
        try {
            $conn = new PDO("mysql:host=" . $this->serverName . ";dbname=" . $this->databaseName, $this->databaseUser, $this->databasePassword);
            $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection error: " . $e->getMessage());
        }
        return $conn;
    }
}

//check login
$curPageName = substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1);

if ($curPageName !== "sign-in.html") {
    
}
?>