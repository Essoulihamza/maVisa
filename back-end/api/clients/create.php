<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

include_once '../../config/Database.php';
include_once '../../model/Posts.php';

$database = new Database;
$conn = $database->connect();

$post = new Posts($conn);

$data = json_decode(file_get_contents('php://input'));

$token = uniqid();
$post->token = $token;
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

if ($post->create()) {
    echo json_encode(
        array('message' => 'Post Created Successfully', 'token' => $token)
    );
} else {
    echo json_encode(
        array('message' => 'Post Creation Failed')
    );
}
