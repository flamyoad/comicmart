<?php

require_once "models/Bookmark.php";

$manga_id = $_POST["mangaId"];
$user_id = $_POST["userId"];

$bookmarkId = Bookmark::insert($manga_id, $user_id);

echo $bookmarkId;