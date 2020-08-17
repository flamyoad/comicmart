<?php
require_once "models/Author.php";
require_once "models/Manga.php";
require_once "models/Genre.php";
require_once "models/Chapter.php";
require_once "models/Page.php";

    session_start();
    header("location: account-settings-upload.php");


    var_dump($_POST);
    var_dump($_FILES);

    $authorName = trim($_POST['authorName']);
    $mangaTitle = trim($_POST['mangaTitle']);
    $mangaSummary = trim($_POST['mangaSummary']);
    $chapterTitle = trim($_POST['chapterTitle']);
    $genreList = $_POST['genres']; // array

    $coverImage = $_FILES['coverImage']; // array
    $chapterPages = $_FILES['images']['tmp_name'];   // array

    /* __DIR__ is the path of the root directory. In my case, __DIR__ is "F:\xampp\htdocs\comicmart"
       It is needed because mkdir() requires absolute path.
    */

    // For some reason, "\" trailing slash can't be stored in MYSQL (Is it OS-dependent or just MySQL??)
    // Example: "F:xampphtdocscomicmart/uploads//coverImg.jpg"
    // In reality, it should have been "F:xampp\htdocs\comicmart/uploads//coverImg.jpg"
    $rootPath = str_replace("\\", "/", __DIR__);
    $mangaFolder = $rootPath."/uploads/".$mangaTitle;

    if (!is_dir($mangaFolder)) {
        mkdir($mangaFolder, 0777, true);
    }

    // Uploads the cover image to server
    $coverImagePath = "uploads/".$mangaTitle."/coverImg.jpg";
    move_uploaded_file($coverImage['tmp_name'], $coverImagePath);

    // Inserts author information into DB
    $author = new Author("NULL", $_SESSION['user_id'], $authorName);
    $authorId = $author->insert();

    // author not inserted???

    // Inserts manga information into DB
    $manga = new Manga("NULL", $authorId, $mangaTitle, "Ongoing", $coverImagePath, 0, 0, $mangaSummary);
    $manga->authorName = $authorName;
    $mangaId = $manga->insert();

    // Inserts genres of the manga into DB
    foreach ($genreList as $genre) {
        Genre::insert($mangaId, $genre); // BUGGED
    }

    // Inserts chapter information into DB
    $todayDate = date_create()->format("Y-m-d H:i:s");
    $totalPageNumber = count($chapterPages);
    $chapterNumber = 1;
    $chapter = new Chapter("NULL", $mangaId, $chapterTitle, $todayDate, $totalPageNumber, 0, $chapterNumber);
    $chapterId = $chapter->insert();

    $chapterFolder = $mangaFolder."/".$chapterTitle;

    var_dump($chapterFolder);

    mkdir($chapterFolder);

    // Inserts and uploads pages into server
    /* $chapterPages = The array of chapters
       $index = The index of the for loop
       $page = The object accessed from loop */
    foreach ($chapterPages as $index => $page) {
        $pagePathAbsolute = $chapterFolder."/".$index.".jpg";
        move_uploaded_file($page, $pagePathAbsolute);

        $pagePathRelative = "uploads/".$mangaTitle."/".$chapterTitle."/".$index.".jpg";

        $page = new Page("NULL", $chapterId, $index, $pagePathRelative);
        $page->insert();
    }
