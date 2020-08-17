<?php
require_once "../models/Database.php";
require_once "../models/Manga.php";
require_once "../models/Chapter.php";
require_once "../models/Author.php";

$mangaId = $_GET["manga_id"];

$manga = Manga::getById($mangaId);

// Converts image to Base64 binary data
$path = "F:/xampp/htdocs/comicmart/" . $manga->getCoverImage();
$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

$manga->coverImageBase64 = $base64;

echo json_encode($manga);
