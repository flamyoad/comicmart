<?php

require_once "../models/Database.php";

$conn = Database::getConnection();

$chapterId = $_GET["chapter_id"];
$userId = $_GET["user_id"];

$priceQuery = <<< SQL
    SELECT price
    FROM `chapter`
    WHERE `id` = ?
SQL;

$priceStmt = $conn->prepare($priceQuery);
$priceStmt->bind_param("i", $chapterId);
$priceStmt->execute();

$priceRow = $priceStmt->get_result()->fetch_assoc();

$price = $priceRow["price"];

if ($price <= 0) {
    echo "true";
    exit();
}

$purchaseQuery = <<< SQL
    SELECT COUNT(*) as count
    FROM `chapter_purchased`
    WHERE user_id = ? AND chapter_id = ?
SQL;

$purchaseStmt = $conn->prepare($purchaseQuery);
$purchaseStmt->bind_param("ii", $userId, $chapterId);
$purchaseStmt->execute();

$purchaseData = $purchaseStmt->get_result()->fetch_assoc();

if ($purchaseData["count"] == 0) {
    $chapterPurchasedByUser = "false";
} else {
    $chapterPurchasedByUser = "true";
}

echo $chapterPurchasedByUser;
