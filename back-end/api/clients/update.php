<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Content-Type');


include_once '../../config/Database.php';
include_once '../../model/Posts.php';

$database = new Database;
$conn = $database->connect();

$post = new Posts($conn);

if(isset($_GET['token'])) {
    $post->token = $_GET['token'];
}

$data = json_decode(file_get_contents('php://input'));

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
