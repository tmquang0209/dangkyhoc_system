<?php
include_once dirname(__DIR__) . "/vendor/autoload.php";
include_once dirname(__DIR__) . "/models/schedule.php";

class Fee extends DB
{

    public function __construct()
    {
    }

    public function getFee()
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("SELECT value FROM info WHERE name = ?");
        $query->execute(["fee"]);
        return $query->fetch()["value"];
    }

    public function setFee($value)
    {
        $stmt = $this->connect();
        $query = $stmt->prepare("UPDATE info SET value = ? WHERE name = ?");
        $query->execute([$value, "fee"]);
    }
}

function getFee()
{
    $fee = new Fee();
    echo $fee->getFee();
}

function updateFee()
{
    $fee = new Fee();
    if (isset($_POST["update"])) {
        $feeValue = floatval($_POST["fee"]);
        $fee->setFee($feeValue);
    }
    echo '<form method="post">
    <label>Nhập học phí: </label>
    <input type="number" name="fee" value="' . $fee->getFee() . '"/>
    <button name="update">Update</button>
    </form>';
}

if (isset($_GET["get_fee"])) {
    getFee();
}
