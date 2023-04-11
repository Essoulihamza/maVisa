<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

include_once '../../config/Database.php';
include_once '../../model/Posts.php';

$database = new Database;
$conn = $database->connect();

$reservation = new Posts($conn);

$data = json_decode(file_get_contents('php://input'));

$reservation->id_client = $data->id_client;
$reservation->reservation_date = $data->reservation_date;
$reservation->reservation_time = $data->reservation_time;

if ($reservation->reservation()) {
    echo json_encode(
        array('message' => 'Reservation Added Successfully')
    );
} else {
    echo json_encode(
        array('message' => 'Reservation Creation Failed')
    );
}
