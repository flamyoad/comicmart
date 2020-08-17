<?php 

require_once "models/Payment.php";

session_start();

// CHANGE !! USING SESSION VARIABLES IS VERY DANGEROUS
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    $topupList = Payment::getTopupHistory($userId);

    // DataTable requires all objects to be encapsulated inside an array named "data" 
    $data = array("data" => $topupList);

    echo json_encode($data);
}

