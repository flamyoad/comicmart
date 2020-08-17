<?php

require_once "../models/User.php";
require_once "../models/Chapter.php";

$userId = $_POST["user_id"];
$chapterId = $_POST["chapter_id"];

// $userId = 5;
// $chapterId = 23;

echo Chapter::purchaseChapter($chapterId, $userId);


