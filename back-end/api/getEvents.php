<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

include_once '../config/Database.php';
include_once '../model/ClientReservation.php';

$database = new Database;
$conn = $database->connect();

$client = new ClientReservation($conn);

$result = $client->getAllEvents();

$dates = $result->fetchAll(PDO::FETCH_COLUMN);

if(count($dates) > 0){

    $events = array_map(function($date) {
        return [
            'start' => $date,
            'end' => $date,
            'display' => 'background',
            'color' => '#000',
        ];
    }, $dates);

    echo json_encode([
        'dates' => $events
    ]);
} else {
    echo json_encode(
        array(
            'message' => 'No reservation dates Found'   
        )
    );
}
