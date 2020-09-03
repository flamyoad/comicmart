<?php

require_once "models/Database.php";

$sql = <<< SQL
    SELECT manga.title, SUM(price) AS total_earnings
    FROM `chapter_purchased` AS purchased
    INNER JOIN `chapter` ON chapter.id = purchased.chapter_id
    INNER JOIN `manga` ON chapter.manga_id = manga.id
    GROUP BY manga_id
SQL;

$statement = Database::getConnection()->prepare($sql);
$statement->execute();

$result = $statement->get_result();

$titleList = [];
$dataList = [];

while ($row = $result->fetch_assoc()) {
    $title = $row['title'];
    $totalEarnings = $row['total_earnings'];

    $object = array(
        'title' => $title,
        'totalEarnings' => $totalEarnings
    );
    array_push($titleList, $title);
    array_push($dataList, $totalEarnings);
}

echo json_encode(
    array(
        'title' => $titleList, 
        'data' => $dataList
    ));