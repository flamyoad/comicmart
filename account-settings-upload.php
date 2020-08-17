<?php
session_start();

require_once "models/Manga.php";
require_once "models/Chapter.php";

$userId = $_SESSION["user_id"];

$publishedMangas = Manga::getPublishedMangas($userId);
?>

<script src="scripts/jquery-3.4.1.js"></script>

<style>
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
    }

    .content-title {
        font-size: 25px;
        font-weight: bold;
        margin-left: 80px;
        margin-top: 20px;
        color: #7b7c7c;
    }

    .row {
        display: flex;
        flex-direction: row;
        margin-bottom: 16px;
    }

    .row p {
        margin: auto 0;
        margin-right: 20px;
    }

    .fab {
        width: 70px;
        height: 70px;
        background-color: red;
        border-radius: 50%;
        box-shadow: 0 6px 10px 0 #666;
        transition: all 0.1s ease-in-out;

        font-size: 50px;
        color: white;
        text-align: center;
        line-height: 60px;

        position: fixed;
        right: 50px;
        bottom: 50px;
    }

    .fab:hover {
        box-shadow: 0 6px 14px 0 #666;
        transform: scale(1.05);
        cursor: pointer;
        text-decoration: none;
        color: white;
    }

    ul {
        list-style-type: none;
    }

    .manga-list {
        display: flex;
        flex-flow: row wrap;
    }

    .manga-item {
        width: 200px;
        padding: 16px;
    }

    .manga-item a {
        text-decoration: none;
        color: black;
    }

    .manga-item a:hover {
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

    .modalBackground {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 1;
        /* Sit on top */
        left: 0;
        top: 0;
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgb(0, 0, 0);
        /* Fallback color */
        background-color: rgba(0, 0, 0, 0.4);
        /* Black w/ opacity */
    }

    .modelWindow {
        background-color: #fefefe;
        margin: 15% auto;
        /* 15% from the top and centered */
        padding-bottom: 12px;
        border: 1px solid #888;

        border-radius: 16px;
        border-top-right-radius: 0px;
        border-top-left-radius: 0px;
        width: 80%;
        /* Could be more or less, depending on screen size */
    }

    .close-modal {
        display: block;
        float: right;
        color: black;
        font-size: 20pt;
    }

</style>

<html>

<body>
    <?php
    require "header.php";
    ?>

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
            <p class="content-title">Uploaded Works</p>
            <div class="content">

                <ul class="manga-list">
                    <!-- <li class="manga-item">
                        <a href="">
                            <img class="manga-cover" src="img/hxh.jpg">
                        </a>
                        <h3 class="manga-title">
                            <a href="">Hunter x Hunter</a>
                        </h3>
                        <p class="manga-description">Chapter 1: The beginning of adventure</p>
                    </li> -->

                    <?php foreach ($publishedMangas as $manga) : ?>
                        <li class="manga-item">
                            <a href="javascript:void(0)" onclick="openModal(<?php echo $manga->getId() ?>)">
                                <img class="manga-cover" src="<?php echo $manga->getCoverImage(); ?>">
                            </a>

                            <h3 class="manga-title">
                                <a href="javascript:void(0)" onclick="openModal(<?php echo $manga->getId() ?>)">
                                    <?php echo $manga->getTitle(); ?>
                                </a>
                            </h3>

                            <p class="manga-description">
                                <?php
                                $latestChapter = Chapter::getLatestChapter($manga->getID());
                                echo $latestChapter->getTitle();
                                ?>
                            </p>

                        </li>
                    <?php endforeach; ?>

                </ul>

                <div class="modalBackground">
                    <div class="modelWindow">
                        <a href="javascript:void(0)" class="close-modal">
                            <i class="fa fa-times" aria-hidden="true" style="color: white; margin: 15px;"></i>
                        </a>
                        <div class="modalContent">

                        </div>
                    </div>
                </div>

                <a class="fab" href="upload-works.php">+</a>

            </div>
        </div>

    </div>


</body>
<html>

<script>
    function openModal(mangaId) {
        $(".modalContent").load(("uploaded-manga-details.php?id=" + mangaId), function() {
            $(".modalBackground").css("display", "block");
        });
    }

    $(".close-modal").click(function() {
        $(".modalBackground").css("display", "none");
    });

    // Dismiss modal dialog if click on background
    // $(window).click(function(e) {
    //     $(".modalBackground").css("display", "none");
    // });
</script>