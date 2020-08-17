<?php
    require_once "models/Rating.php";
    session_start();

    $userId = $_POST["userId"];
    $mangaId = $_POST["mangaId"];
    $rating = $_POST["ratedValue"];

    Rating::setRating($userId, $mangaId, $rating);
?>