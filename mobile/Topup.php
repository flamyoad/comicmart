<?php

require_once "../models/Payment.php";

$amount = $_POST["amount"];
$userId = $_POST["user_id"];

Payment::addTopup($userId, $amount);


