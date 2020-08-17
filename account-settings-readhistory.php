<?php
session_start();
require_once "models/ReadHistory.php";

$userId = $_SESSION["user_id"];
$readHistory = ReadHistory::getAll($userId);
?>

<html>

<head>
    <style>
        /* */
        .my-container {
            display: grid;
            grid-template-columns: min-content 1fr;
            font-family: system-ui, sans-serif;
            background-color: #f7f8f9;
            height: 1000px;
        }

        nav {
            background-color: #37474F;
            box-shadow: 7px 5px 5px silver;
        }

        nav ul {
            list-style: none;
            position: sticky;
            top: 0;
            padding: 0px;
        }

        nav ul li {
            display: flex;
            flex-direction: row;
        }

        nav ul li a {
            display: block;
            padding-left: 36px;
            padding-right: 36px;
            padding-top: 20px;
            padding-bottom: 20px;
            width: 100%;
            text-decoration: none;
            white-space: nowrap;
            color: white;
            font-family: Arial, Helvetica, sans-serif;
        }

        nav ul li a:hover {
            background-color: #56707c;
            text-decoration: none;
            color: white;
        }

        .nav-icons {
            margin: auto 0;
            margin-right: 10px;
            color: white;
        }

        .content {
            border-style: solid;
            border-width: 1px;
            border-color: white;
            border-radius: 10px;
            margin-left: 80px;
            margin-right: 8px;
            margin-top: 20px;
            background-color: white;
            padding: 32px;
            padding-top: 16px;
        }

        .content-title {
            font-size: 25px;
            font-weight: bold;
            margin-left: 80px;
            margin-top: 20px;
            color: #7b7c7c;
        }

        /* Until here is the CSS for navbar */

        ul {
            list-style-type: none;
        }

        .manga-list {
            display: flex;
            flex-flow: row wrap;
            padding: 0px;
        }

        .manga-item {
            width: 200px;
            padding-top: 16px;
        }

        .manga-cover {
            height: 170px;
            background-size: cover;
        }

        .manga-title a {
            text-decoration: none;
            color: black;
        }

        .manga-title a:hover {
            text-decoration: none;
            color: red;
        }

        .manga-cover {
            height: 170px;
            background-size: cover;
        }

        .manga-title {
            font-size: 20px;
            text-overflow: ellipsis;
            margin-bottom: 4px;
            margin-top: 8px;
        }

        .manga-description {
            color: gray;
            font-size: 14px;
            text-overflow: ellipsis
        }

        .manga-label {
            color: #606060;
            margin-right: 10px;
            font-size: 10pt;
            font-family: Arial, Helvetica, sans-serif;
            white-space: pre;
        }

        .read-link {
            color: black;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10pt;
        }

        .read-link:hover {
            color: #606060;
            text-decoration: none;
        }

        .latest-link {
            color: #d21404;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10pt;
        }

        .latest-link:hover {
            color: red;
            text-decoration: none;
        }

        .topbar-links {
            color: #7b7c7c;
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
        }

        .topbar-links:hover {
            text-decoration: none;
            color: black;
        }

        .active {
            color: #1C1C1C;
        }
    </style>
</head>

<body>
    <?php require_once "header.php" ?>

    <div class="my-container">

        <nav id="sidebar">
            <ul>

                <li>
                    <a href="account-settings.php">
                        <i class="fa fa-user-o nav-icons" aria-hidden="true"></i>
                        <span>User Profile</span>
                    </a>
                </li>

                <li>
                    <a href="account-settings-library.php">
                        <i class="fa fa-book nav-icons" aria-hidden="true"></i>
                        <span>Library</span>
                    </a>
                </li>

                <li>
                    <a href="account-settings-topuphistory.php"">
                        <i class="fa fa-credit-card nav-icons" aria-hidden="true"></i>
                        <span>Wallet</span>
                    </a>
                </li>

                <li>
                    <a href="account-settings-upload.php">
                        <i class="fa fa-upload nav-icons" aria-hidden="true"></i>
                        <span>Uploaded Works</span>
                    </a>
                </li>

            </ul>
        </nav>

        <div>
            <p class="content-title">Library</p>

            <div class="content">
                <div class="topbar">
                    <a class="topbar-links" href="account-settings-library.php">
                        <i class="fa fa-bookmark" style="margin-right: 5px;" aria-hidden="true"></i>
                        Bookmark
                    </a>

                    <a class="topbar-links active" style="margin-left: 50px;" href="account-settings-readhistory.php">
                        <i class="fa fa-history" style="margin-right: 5px;" aria-hidden="true"></i>
                        Read History
                    </a>
                </div>

                <hr>

                <ul class="manga-list">
                    <?php foreach ($readHistory as $index => $row) :
                        $mangaLink = "comicpage.php?id=" . $row->getMangaId();

                        $latestChapter = $row->getLatestChapter();
                        $latestChapterName = "Chapter " . $latestChapter->getChapterNumber();
                        $latestChapterLink = "comicreader.php?id=" . $latestChapter->getId();

                        $readChapter = $row->getReadChapter();
                        $readChapterName = "Chapter " . $readChapter->getChapterNumber();
                        $readChapterLink = "comicreader.php?id=" . $readChapter->getId();
                    ?>

                        <li class="manga-item">
                            <a href="<?php echo $mangaLink ?>" target="_blank">
                                <img class="manga-cover" src="<?php echo $row->getCoverImage() ?>">
                            </a>
                            <h3 class="manga-title">
                                <a href="<?php echo $mangaLink ?> target="_blank"">
                                    <?php echo $row->getTitle(); ?>
                                </a>
                            </h3>
                            <div>
                                <span class="manga-label">Read </span>
                                <a class="read-link" href="<?php echo $readChapterLink ?>" target="_blank">
                                    <?php echo $readChapterName ?>
                                </a>
                            </div>
                            <div>
                                <span class="manga-label">Latest</span>
                                <a class="latest-link" href="<?php echo $latestChapterLink ?>" target="_blank"">
                                    <?php echo $latestChapterName ?>
                                </a>
                            </div>
                        </li>

                    <?php endforeach ?>
                </ul>

            </div>
        </div>

</body>

</html>