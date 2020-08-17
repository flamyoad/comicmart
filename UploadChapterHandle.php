<?php
require_once "models/Manga.php";
require_once "models/Chapter.php";
require_once "models/Page.php";

$mangaId = $_POST["mangaId"];

$manga = Manga::getById($mangaId);

$chapterTitle = trim($_POST['chapterTitle']);
$chapterPages = $_FILES['images']['tmp_name'];   // array

$rootPath = str_replace("\\", "/", __DIR__);
$mangaFolder = $rootPath . "/uploads/" . $manga->getTitle();

// Inserts chapter information into DB
$todayDate = date_create()->format("Y-m-d H:i:s");
$totalPageNumber = count($chapterPages);

$latestChapter = Chapter::getLatestChapter($mangaId);
$newChapterNumber = $latestChapter->getChapterNumber() + 1;

$chapter = new Chapter("NULL", $mangaId, $chapterTitle, $todayDate, $totalPageNumber, 0, $newChapterNumber);
$chapterId = $chapter->insert();

$chapterFolder = $mangaFolder . "/" . $chapterTitle;
mkdir($chapterFolder);

foreach ($chapterPages as $index => $page) {
    $pagePathAbsolute = $chapterFolder . "/" . $index . ".jpg";
    move_uploaded_file($page, $pagePathAbsolute);

    $pagePathRelative = "uploads/" . $manga->getTitle() . "/" . $chapterTitle . "/" . $index . ".jpg";

    $page = new Page("NULL", $chapterId, $index, $pagePathRelative);
    $page->insert();
}

header("Location: account-settings-upload.php");

