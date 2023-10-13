<?php
include "../db.php";

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    // Retrieve data sent from the React Native application
    $firstName = $_GET["firstName"];
    $lastName = $_GET["lastName"];
    $email = $_GET["email"];
    $address = $_GET["address"];
    $city = $_GET["city"];
    $mobilePhone = $_GET["mobilePhone"];
    $hotelDetail = $_GET["hotelDetail"];
    $totalPrice = $_GET["totalPrice"];

    $query = $conn->prepare("INSERT INTO `booking`(`first_name`, `last_name`, `email`, `address`, `city`, `mobile_phone`, `search_id`, `hotel_id`, `check_in`, `check_out`, `qty_room`, `qty_people`, `total_price`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $query->execute([$firstName, $lastName, $email, $address, $city, $mobilePhone, $hotelDetail["searchID"], $hotelDetail["hotelID"], $hotelDetail["checkIn"], $hotelDetail["checkOut"], $hotelDetail["numOfRoom"], $hotelDetail["numOfPeople"], $totalPrice]);


    $queryGetID = $conn->prepare("SELECT id FROM `booking` WHERE 
        `first_name` = ? AND 
        `last_name` = ?
       ");
    $queryGetID->execute([$firstName, $lastName]);
    $queryGetID->debugDumpParams();
    $fetch = $queryGetID->fetch();
    // Send a response back to the React Native application if needed
    $response = [
        "message" => "Booking data received successfully.",
        "OrderID" => $fetch["id"], // You can include the received data in the response if required.
    ];

    // Convert the response to JSON and echo it
    header("Content-Type: application/json");
    echo json_encode($response);
} else {
    // Return an error response if the request method is not POST
    http_response_code(400);
    echo json_encode(["error" => "Invalid request method"]);
}
