<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

include_once '../config/Database.php';
include_once '../model/ClientReservation.php';

$database = new Database;
$conn = $database->connect();

$client = new ClientReservation($conn);

$data = json_decode(file_get_contents('php://input'));

if (!isset($data->nom_complet) || !isset($data->naissance) || !isset($data->nationalite) || !isset($data->situation) || !isset($data->address) || !isset($data->type_visa) || !isset($data->date_depart) || !isset($data->date_arriver) || !isset($data->type_document) || !isset($data->numero_document)) {
    echo json_encode(
        array(
            'message' => 'Missing Required Fields'
        )
    );
    exit;
}

$errors = array();

if(!preg_match($client->string_pattern, $data->nom_complet)) {
    $errors[] = 'invalid name field';
}
if(!preg_match($client->date_pattern, $data->naissance)) {
    $errors[] = 'invalid birth field';
}
if(!preg_match($client->string_pattern, $data->nationalite)) {
    $errors[] = 'invalid nationality field';
}
if(!preg_match($client->string_pattern, $data->situation)) {
    $errors[] = 'invalid situation field';
}
if(!preg_match($client->email_pattern, $data->address)) {
    $errors[] = 'invalid email field';
}
if(!preg_match($client->string_pattern, $data->type_visa)) {
    $errors[] = 'invalid visa type field';
}
if(!preg_match($client->date_pattern, $data->date_depart)) {
    $errors[] = 'invalid start date field';
}
if(!preg_match($client->date_pattern, $data->date_arriver)) {
    $errors[] = 'invalid end date field';
}
if(!preg_match($client->string_pattern, $data->type_document)) {
    $errors[] = 'invalid document type field';
}
if(!preg_match($client->numeric_pattern, $data->numero_document)) {
    $errors[] = 'invalid document number field';
}

if(!empty($errors)) {
    echo json_encode([
        'message' => "validation failed",
        "errors" => $errors
    ]);
    exit;
}

$token = uniqid();
$client->token = $token;
$client->nom_complet = $data->nom_complet;
$client->naissance = $data->naissance;
$client->nationalite = $data->nationalite;
$client->situation = $data->situation;
$client->address = $data->address;
$client->type_visa = $data->type_visa;
$client->date_depart = $data->date_depart;
$client->date_arriver = $data->date_arriver;
$client->type_document = $data->type_document;
$client->numero_document = $data->numero_document;

if ($client->create()) {
    echo json_encode(
        array(
            'message' => 'Client Created Successfully',
            'token' => $token
        )
    );
} else {
    echo json_encode(
        array(
            'message' => 'Post Creation Failed'
        )
    );
}
