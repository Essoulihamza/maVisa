<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Content-Type');

include_once '../config/Database.php';
include_once '../model/ClientReservation.php';

$database = new Database;
$conn = $database->connect();

$client = new ClientReservation($conn);

if(isset($_GET['token'])) {
    $client->token = $_GET['token'];
}

if ($client->delete()) {
    echo json_encode(   
        array('message' => 'Client Deleted Successfully')
    );
} else {
    echo json_encode(
        array('message' => 'Client Delete Failed')
    );
}
