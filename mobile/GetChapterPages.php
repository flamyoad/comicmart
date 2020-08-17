<?php
require_once "../models/Database.php";
require_once "../models/Page.php";

$chapterId = $_GET["chapter_id"];

$sql = <<< SQL
    SELECT * FROM `page` WHERE `chapter_id` = ?
SQL;

$statement = Database::getConnection()->prepare($sql);
$statement->bind_param("i", $chapterId);
$statement->execute();
$result = $statement->get_result();

$pageList = array();

while ($row = $result->fetch_assoc()) {
    $page = Page::toObject($row);

    // Converts image to Base64 binary string
    $path = "F:/xampp/htdocs/comicmart/" . $page->getImageLocation();
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

    $page->imageBase64 = $base64;

    array_push($pageList, $page);
}

echo json_encode($pageList);
