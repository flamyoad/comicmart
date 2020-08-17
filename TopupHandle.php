<?php
    require_once "models/Payment.php";

    session_start();

    $userId = $_SESSION["user_id"];
    $amount = $_POST["amount"];

    Payment::addTopup($userId, $amount);

    header("location: topup.php");
?>