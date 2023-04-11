<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Content-Type');


include_once '../config/Database.php';
include_once '../model/ClientReservation.php';

$database = new Database;
$conn = $database->connect();

$post = new ClientReservation($conn);

if(isset($_GET['token'])) {
    $post->token = $_GET['token'];
} else {
    echo json_encode(
        array('message' => 'Token Has Not Been Set Correctly' )
    );
    exit;
}

$data = json_decode(file_get_contents('php://input'));

if (empty($data->nom_complet) || empty($data->naissance) || empty($data->nationalite) || empty($data->situation) || empty($data->address) || empty($data->type_visa) || empty($data->date_depart) || empty($data->date_arriver) || empty($data->type_document) || empty($data->numero_document) || empty($data->reservation_date) || empty($data->reservation_time)) {
    echo json_encode(
        array(
            'message' => 'Missing Required Fields'
        )
    );
    exit;
}

$errors = array();

if(!preg_match($post->string_pattern, $data->nom_complet)) {
    $errors[] = 'invalid name field';
}
if(!preg_match($post->date_pattern, $data->naissance)) {
    $errors[] = 'invalid birth field';
}
if(!preg_match($post->string_pattern, $data->nationalite)) {
    $errors[] = 'invalid nationality field';
}
if(!preg_match($post->string_pattern, $data->situation)) {
    $errors[] = 'invalid situation field';
}
if(!preg_match($post->email_pattern, $data->address)) {
    $errors[] = 'invalid email field';
}
if(!preg_match($post->string_pattern, $data->type_visa)) {
    $errors[] = 'invalid visa type field';
}
if(!preg_match($post->date_pattern, $data->date_depart)) {
    $errors[] = 'invalid start date field';
}
if(!preg_match($post->date_pattern, $data->date_arriver)) {
    $errors[] = 'invalid end date field';
}
if(!preg_match($post->string_pattern, $data->type_document)) {
    $errors[] = 'invalid document type field';
}
if(!preg_match($post->numeric_pattern, $data->numero_document)) {
    $errors[] = 'invalid document number field';
}
if(!preg_match($post->time_pattern, $data->reservation_time)) {
    $errors[] = 'invalid time field';
}

if(!empty($errors)) {
    echo json_encode([
        'message' => "validation failed",
        "errors" => $errors
    ]);
    exit;
}

$post->nom_complet = $data->nom_complet;
$post->naissance = $data->naissance;
$post->nationalite = $data->nationalite;
$post->situation = $data->situation;
$post->address = $data->address;
$post->type_visa = $data->type_visa;
$post->date_depart = $data->date_depart;
$post->date_arriver = $data->date_arriver;
$post->type_document = $data->type_document;
$post->numero_document = $data->numero_document;
$post->reservation_date = $data->reservation_date;
$post->reservation_time = $data->reservation_time;

if ($post->update()) {
    echo json_encode(
        array('message' => 'Post Updated Successfully')
    );
} else {
    echo json_encode(
        array('message' => 'Post Update Failed')
    );
}
