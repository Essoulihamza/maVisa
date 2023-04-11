<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

include_once '../config/Database.php';
include_once '../model/ClientReservation.php';

$database = new Database;
$conn = $database->connect();

$reservation = new ClientReservation($conn);

if (empty($_GET['date'])) {
    echo json_encode(
        array('message' => 'Missing Required Fields' )
    );
    exit;
} 

$errors = array();

if(!preg_match($reservation->date_pattern, $_GET['date'])) {
    $errors[] = 'invalid reservation date';
}

if(!empty($errors)) {
    echo json_encode([
        'message' => 'validation failed',
        'errors' => $errors
    ]);
    exit;
}

$reservation->reservation_date = $_GET['date'];

$result = $reservation->checkReservation();

$times = $result->fetchAll(PDO::FETCH_COLUMN);

if(count($times) > 0){

    echo json_encode($times);

} else {
    echo 0;
}
