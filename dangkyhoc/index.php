<?php
include "./vendor/autoload.php";
include "./models/schedule.php";
include "./models/fee.php";

use Shuchkin\SimpleXLSX;

//update schedule
if (isset($_GET["insert"])) {
    $schedule = new Schedule();
    $schedule->convertData();
} else if (isset($_GET["update_fee"])) {
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
} else if (isset($_GET["insert_schedule"])) {
    if ($xlsx = SimpleXLSX::parse('thoikhoabieu.xlsx')) {
        $rawData = $xlsx->rows();

        $count = 0;
        foreach ($rawData as $row) {
            if ($count++ != 0) {

                $data = [
                    "SubID" => $row[1],
                    "SubName" => $row[2],
                    "Classname" => $row[3],
                    "Day" => $row[4],
                    "Shift" => $row[6],
                    "Classroom" => $row[7],
                    "Credits" => $row[8],
                    "Coef" => $row[9],
                    "Teacher" => $row[10],
                ];
                print_r($data);
            }
        }
    } else {
        echo SimpleXLSX::parseError();
    }
} else if (isset($_GET["fee_manager"])) {
    //update fee
    //list student's fee
} else if (isset($_GET["subject_manager"])) {
} else if (isset($_GET["schedule_manager"])) {
} else {
    include './view/home.php';
}
