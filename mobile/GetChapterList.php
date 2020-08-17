<?php
require_once "../models/Chapter.php";

$mangaId = $_GET["manga_id"];

// Retrieve list of chapters
$chapterList = Chapter::getAllChapters($mangaId);

echo json_encode($chapterList);