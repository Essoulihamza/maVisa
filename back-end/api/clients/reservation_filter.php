<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

include_once '../../config/Database.php';
include_once '../../model/Posts.php';

$database = new Database;
$conn = $database->connect();

$post = new Posts($conn);

if (isset($_GET['date']) && isset($_GET['time'])) {
    $post->reservation_date = $_GET['date'];
    $post->reservation_time = $_GET['time'];
} else {
    echo json_encode(
        array('message' => 'Data Has Not Been Set Correctly' )
    );
    exit;
}

$result = $post->checkReservation();
$numRows = $result->rowCount();

if($numRows > 0){
    
    $times_array = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $time_items = array(
            'id' => $id,
            'time' => $time
        );

        $times_array[] = $time_items;
    }

    echo json_encode($times_array);
} else {
    echo json_encode(
        array(
            'message' => 'Reservation Available'
        )
    );
}
