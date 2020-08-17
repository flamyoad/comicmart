<?php 

require_once "models/Bookmark.php";

$manga_id = $_POST["mangaId"];
$user_id = $_POST["userId"];

Bookmark::remove($manga_id, $user_id);