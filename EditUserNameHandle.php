<?php

session_start();

require_once "models/Database.php";

$userId = $_SESSION['user_id'];
$newName = $_POST['name'];

$sql = <<< SQL
    UPDATE `users`
    SET `display_name` = ?
    WHERE `id` = ?
SQL;

$stmt = Database::getConnection()->prepare($sql);

echo Database::getConnection()->error;

$stmt->bind_param("si", $newName, $userId);
$stmt->execute();

header("location: account-settings.php");