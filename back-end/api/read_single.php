<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

include_once '../config/Database.php';
include_once '../model/ClientReservation.php';

$database = new Database;
$conn = $database->connect();

$client = new ClientReservation($conn);

if (isset($_GET['token'])) {
    $client->token = $_GET['token'];
} else {
    echo json_encode(
        array('message' => 'Token Has Not Been Set Correctly' )
    );
    exit;
}

$client->read_single();

$client_arr = array(
    'id' => $client->id,
    'token' => $client->token,
    'nom_complet' => $client->nom_complet,
    'naissance' => $client->naissance,
    'nationalite' => $client->nationalite,
    'situation' => $client->situation,
    'address' => $client->address,
    'type_visa' => $client->type_visa,
    'date_depart' => $client->date_depart,
    'date_arriver' => $client->date_arriver,
    'type_document' => $client->type_document,
    'numero_document' => $client->numero_document
);

echo (json_encode($client_arr));