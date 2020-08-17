<?php
require_once "../models/Database.php";
require_once "../models/Manga.php";

$sql = <<< SQL
SELECT * FROM `manga` ORDER BY view_count DESC LIMIT 20
SQL;

$statement = Database::getConnection()->prepare($sql);
$statement->execute();
$result = $statement->get_result();

$fetchedMangas = array();

while ($row = $result->fetch_assoc()) {
    $mangaItem =  new Manga(
        $row['id'],
        $row['author_id'],
        $row['title'],
        $row['status'],
        $row['cover_image'],
        $row['view_count'],
        $row['money_earned'],
        $row['summary']
    );

    // Converts image to Base64 binary data
    $path = "F:/xampp/htdocs/comicmart/" . $mangaItem->getCoverImage();
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

    $mangaItem->coverImageBase64 = $base64;

    array_push($fetchedMangas, $mangaItem);
}

echo json_encode($fetchedMangas);
