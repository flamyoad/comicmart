<?php

require_once "../models/Database.php";
require_once "../models/Bookmark.php";

$userId = $_GET["user_id"];

$sql = <<< SQL
    SELECT bk.id as bookmark_id, mg.id as manga_id, mg.title, mg.cover_image 
    FROM `bookmark` bk
    INNER JOIN `manga` mg ON mg.id = bk.manga_id
    WHERE user_id = ?;
SQL;

$statement = Database::getConnection()->prepare($sql);
$statement->bind_param("i", $userId);
$statement->execute();
$result = $statement->get_result();

$bookmarkList = array();

while ($row = $result->fetch_assoc()) {
    $readHistory = ReadHistory::get($userId, $row["manga_id"]);

    if ($readHistory != null) {
        $readChapter = $readHistory->getReadChapter();
    } else {
        $readChapter = null;
    }

    $latestChapter = Chapter::getLatestChapter($row["manga_id"]);

    $bookmark = new Bookmark(
        $row["bookmark_id"],
        $row["manga_id"],
        $row["title"],
        $row["cover_image"],
        $readChapter,
        $latestChapter
    );

    // Converts image to Base64 binary string
    $path = "F:/xampp/htdocs/comicmart/" . $bookmark->getCoverImage();
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

    $bookmark->coverImageBase64 = $base64;

    array_push($bookmarkList, $bookmark);
}

echo json_encode($bookmarkList);
