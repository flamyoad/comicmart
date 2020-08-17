<?php 
// Important to tell your browser what we will be sending
header('Content-type: application/json; charset=utf-8');

require_once "models/Chapter.php";

session_start();

$chapterId = $_POST["chapterId"];
$userId = $_POST["userId"];

$message = Chapter::purchaseChapter($chapterId, $userId);

echo json_encode(array(
    "message" => $message
));
