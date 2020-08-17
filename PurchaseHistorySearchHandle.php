<?php
header('Content-type: application/json; charset=utf-8');

require_once "models/Database.php";

session_start();

$userId = $_SESSION['user_id'];

$query = <<< SQL
    SELECT ChapterPurchased.id, 
    cover_image,  
    manga_id,
    manga.title as mangaTitle,
    chapter_id,
    chapter.title as chapterTitle,
    chapter.chapter_number,
    price,
    datetime_purchased

    FROM `chapter_purchased` as ChapterPurchased
    INNER JOIN `chapter` ON ChapterPurchased.chapter_id = chapter.id
    INNER JOIN `manga` ON chapter.manga_id = manga.id
    WHERE `user_id` = ?
SQL;

$conn = Database::getConnection();

$statement = $conn->prepare($query);
$statement->bind_param("i", $userId);
$statement->execute();

$result = $statement->get_result();

$historyList = array();

while ($row = $result->fetch_assoc()) {
    $item = array(
        "id" => $row["id"],
        "coverImg" => $row["cover_image"],
        "mangaId" => $row["manga_id"],
        "mangaTitle" => $row["mangaTitle"],
        "chapterId" => $row["chapter_id"],
        "chapterTitle" => $row["chapterTitle"],
        "chapterNumber" => $row["chapter_number"],  
        "price" => $row["price"],
        "datetime_purchased" => $row["datetime_purchased"]
    );

    array_push($historyList, $item);
}

echo json_encode(array("data" => $historyList));

