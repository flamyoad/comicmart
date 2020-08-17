<h3>

</h3>

<?php
session_start();

    var_dump($_SESSION['user_id']);
    require_once 'models/User.php';
    require_once "models/Manga.php";

    $userId = $_SESSION["user_id"];

$publishedMangas = Manga::getPublishedMangas($userId);
var_dump($publishedMangas);
?>