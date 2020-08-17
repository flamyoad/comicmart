<?php

require_once "../models/Database.php";
require_once "../models/Manga.php";

$keyword = $_GET["keyword"];

$sql = <<< SQL
    SELECT * FROM manga
    WHERE title LIKE CONCAT('%',?,'%')
SQL;

$conn = Database::getConnection();
$statement = $conn->prepare($sql);
$statement->bind_param("s", $keyword);
$statement->execute();

$result = $statement->get_result();

$mangaList = array();
while ($row = $result->fetch_assoc()) {
    $manga = Manga::toObject($row);

    // Converts image to Base64 binary data
    $path = "F:/xampp/htdocs/comicmart/" . $manga->getCoverImage();
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

    $manga->coverImageBase64 = $base64;

    array_push($mangaList, $manga);
}
echo json_encode($mangaList);
