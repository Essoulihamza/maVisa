<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Content-Type');

include_once '../../config/Database.php';
include_once '../../model/Posts.php';

$database = new Database;
$conn = $database->connect();

$post = new Posts($conn);

if(isset($_GET['token'])) {
    $post->token = $_GET['token'];
}

if ($post->delete()) {
    echo json_encode(   
        array('message' => 'Post Deleted Successfully')
    );
} else {
    echo json_encode(
        array('message' => 'Post Delete Failed')
    );
}
