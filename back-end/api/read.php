<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

include_once '../config/Database.php';
include_once '../model/ClientReservation.php';

$database = new Database;
$conn = $database->connect();

$client = new ClientReservation($conn);

$result = $client->read();
$numRow = $result->rowCount();

if($numRow > 0){

    $client_arr = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $client_items = array(
            'id' => $id,
            'token' => $token,
            'nom_complet' => $nom_complet,
            'naissance' => $naissance,
            'nationalite' => $nationalite,
            'situation' => $situation,
            'address' => $address,
            'type_visa' => $type_visa,
            'date_depart' => $date_depart,
            'date_arriver' => $date_arriver,
            'type_document' => $type_document,
            'numero_document' => $numero_document,
        );

        $client_arr[] = $client_items;
    }

    echo json_encode($client_arr);
} else {
    echo json_encode(
        array(
            'message' => 'No Clients Found'
        )
    );
}
