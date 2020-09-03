<?php
session_start();
require_once "models/User.php";
require_once "models/Manga.php";
require_once "models/Chapter.php";
require_once "models/Page.php";
require_once "models/ReadHistory.php";

function findChapter($chapterList, $chapterId)
{
    foreach ($chapterList as $chapter) {
        if ($chapter->getId() == $chapterId) {
            return $chapter;
        }
    }
    return null;
}

$currentChapterId = $_GET["id"];

if (isset($_SESSION["user_id"])) {
    $userId = $_SESSION["user_id"];
} else {
    $userId = 0;
}

if ($userId == 0) {
    $user = null;
} else {
    $user = User::getById($userId);
}

$chapterAvailability = Chapter::checkChapterAvailability($currentChapterId, $userId);

$currentChapter = Chapter::getById($currentChapterId);
$manga = Manga::getById($currentChapter->getMangaId());

$chapterList = Chapter::getAllChapters($manga->getId());
$prevChapter = findChapter($chapterList, $currentChapterId - 1);
$nextChapter = findChapter($chapterList, $currentChapterId + 1);

$prevChapterLink = "javascript:void(0)";
if ($prevChapter != null) {
    $prevChapterLink = $prevChapter->getLink();
}

$nextChapterLink = "javascript:void(0)";
if ($nextChapter != null) {
    $nextChapterLink = $nextChapter->getLink();
}

$pageList = Page::getChapterPages($currentChapterId);

// Store read history if user is logged in
if (isset($_SESSION['user_id'])) {

    $userId = $_SESSION['user_id'];
    $mangaId = $manga->getId();

    ReadHistory::insert($userId, $mangaId, $currentChapterId);
}

// Increment view count
Manga::incrementViewCount($currentChapter->getId());
?>

<html>

<head>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bttn.min.css">
    <link rel="stylesheet" href="css/bootstrap-4.4.1-dist/css/bootstrap.min.css">
    <script src="scripts/jquery-3.4.1.js"></script>
    <script src="css/bootstrap-4.4.1-dist/js/bootstrap.bundle.min.js"></script>

    <style>
        a {
            text-decoration: none;
            color: white;
        }

        a:hover {
            text-decoration: none;
            color: white;
        }

        body {
            margin: 0px;
            padding-bottom: 40px;

            /* Same as header height */
            padding-top: 30px;

            background-color: #F8F8F8;
        }

        .header {
            display: flex;
            flex-direction: row;
            /* height: 30px; */
            background-color: #AF002A;

            position: fixed;
            top: 0;
            width: 100%;
            transition: top 0.2s ease-in-out;

            padding-top: 10px;
            padding-bottom: 10px;
        }

        .header div {
            display: inline-block;
        }

        .header-title {
            font-size: 15pt;
            margin-left: 20px;
        }

        .header-start a {
            margin-right: 20px;
        }

        .header-end {
            margin-left: auto;
            margin-top: 2px;
        }

        .header-end a,
        select {
            margin-right: 20px;
        }

        .chapter-selector {
            height: 25px;
        }

        .chapter-indicator {
            background-color: #EFDECD;
            border: #EFDECD solid 1px;
            border-radius: 10px;
            margin: 30px 5px;
            padding: 12px;
        }

        .chapter-indicator a {
            color: #AF002A;
            margin-right: 10px;
        }

        .chapter-indicator a:hover {
            text-decoration: underline;
        }

        .chapter-indicator span {
            color: gray;
            margin-right: 10px;
        }

        .comic-strip {
            margin-bottom: 30px;
        }

        .comic-strip img {
            display: block;
            margin: 0 auto;
            margin-bottom: 10px;
        }

        .footer {
            width: 40%;
            margin: 0 auto;
            padding-bottom: 50px;
        }

        .footer span {
            font-size: 10pt;
            margin-right: 10px;
            color: #AF002A;
            font-weight: bold;
        }

        .back-to-top-text {
            width: 10%;
            margin: 0 auto;
            color: gray;
            font-weight: bold;
        }

        .back-to-top-text:hover {
            cursor: pointer;
        }

        .paywall-header-title {
            font-size: 18px;
            font-weight: bold;
            color: black;
            color: rgb(220, 53, 69);
        }

        .paywall-header-text {
            font-family: sans-serif;
            font-size: 20pt;
            color: rgb(220, 53, 69);
        }

        .gray-border {
            background-color: lightgray;
            border: lightgray solid 1px;
            border-radius: 10px;
        }

        .small-text {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10pt;
            margin-top: 2px;
            margin-left: 4px;
        }

        .account-balance {
            display: inline-block;
            color: darkslategrey;
            font-size: 10pt;
        }

        .topup-link {
            border: solid rgb(220, 53, 69) 1px;
            padding: 2px 5px;
            background-color: rgb(220, 53, 69);
            color: white;
            font-size: 10pt;
            margin-left: 10px;
            margin-bottom: 4px;
        }

        .topup-error-text {
            color: rgb(220, 53, 69);
            font-size: 11pt;
            display: none;
        }

        #loading-indicator {
            display: none;
        }

        #success-indicator {
            display: none;
        }

        #btn-close-dialog {
            display: none;
            float: right;
            color: #1B1E23;
            line-height: 1.2;
            font-size: 24px;
        }

        #btn-close-dialog:hover {
            cursor: pointer;
            color: black;
        }
    </style>

</head>

<body>

    <!-- Paywall dialog -->
    <div id="paywallModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">

                <div class="modal-body">

                    <p class="paywall-header-title">
                        Wait just a minute...
                        <i id="btn-close-dialog" class="fa fa-times" aria-hidden="true"></i>
                    </p>

                    <hr />

                    <div class="gray-border">
                        <p class="small-text">Subscribe to this chapter to read!</p>
                        <ul style="padding-left: 14px; margin: 0px;">
                            <li class="small-text">You can also pay monthly to gain access to all content by this author</li>
                        </ul>
                    </div>

                    <p class="paywall-header-text" style="margin-top: 12px; margin-bottom: 6px;">Choose Plan</p>

                    <div>
                        <div style="margin: 0px;">
                            <input style="margin-right: 4px;" type="radio" id="individual" value="individual" name="subscriptionType" />
                            <label style="margin: 0px; font-size: 10pt;" for="individual">Purchase this chapter</label>
                            <span style="float: right; font-weight: bold;">
                                <?php echo $currentChapter->getPrice() ?> MPoints
                            </span>
                        </div>

                        <hr style="margin: 2px;" />
                        <div>
                            <input style="margin-right: 4px;" type="radio" id="monthlySubscription" value="monthlySubscription" name="subscriptionType" />
                            <label style="margin: 0px; font-size: 10pt;" for="monthlySubscription">Monthly Subscription</label>
                            <span style="float: right; font-weight: bold;">RM 50/mo</span>
                        </div>

                        <hr style="border-top: dotted 1px;" />

                        <span class="account-balance">Current balance for this account:
                            <span style="color: rgb(220, 53, 69); margin-left: 4px;">
                                <?php echo $user == null ? "0" : $user->getTopupBalance() ?>
                            </span>
                            <span>MPoints</span>
                            <a class="btn btn-danger topup-link" href="topup.php" target="_blank">
                                TOPUP
                                <i class="fa fa-angle-double-right" style="color: white; margin-left: 5px;" aria-hidden="true"></i>
                            </a>
                        </span>

                        <p class="topup-error-text">
                            <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                            <span>You do not have enough points! Please topup before proceeding</span>
                        </p>


                        <div id="loading-indicator" style="margin-top: 20px;">
                            <div style="margin: 0 auto; width: 10%; margin-top: 10px;">
                                <img src="icons/loading.gif" width="50" height="50" />
                            </div>
                            <p style="text-align: center; font-size: 10pt; margin-top: 4px;">
                                Processing... Please wait a minute
                            </p>
                        </div>

                        <div id="success-indicator" style="margin-top: 20px;">
                            <div style="margin: 0 auto; width: 10%; margin-top: 10px;">
                                <i class="fa fa-check" aria-hidden="true" style="color:green; font-size: 30pt;"></i>
                            </div>
                            <p style="text-align: center; font-size: 12pt; margin-top: 4px; font-weight: bold;">
                                Thank you for purchasing!
                            </p>
                        </div>

                        <a id="btn-pay" class="btn btn-danger" onclick="processPayment()" style="margin-top: 40px; float: right; padding: 10px 50px;" href="javascript:void(0)">
                            Continue
                        </a>

                    </div>

                </div>

                <a style="margin-top: 10px; border-top-left-radius: 0px; border-top-right-radius: 0px;" class="btn btn-dark" href="<?php echo 'comicpage.php?id=' . $manga->getId(); ?>">
                    Return to Library
                </a>

            </div>

        </div>
    </div>

    <div class="header">

        <div class="header-start">
            <a href="<?php echo $manga->getLink() ?>" class="header-title">
                <?php echo $manga->getTitle() ?>
            </a>

            <a href="homepage.php">
                <i class="fa fa-home" style="color: white; margin-right: 5px; font-size: 15pt;" aria-hidden="true"></i>
                Back to home
            </a>
        </div>

        <div class="header-end">
            <a href="<?php echo $prevChapterLink ?>">
                <i class="fa fa-chevron-left" style="color: white; margin-right: 10px;" aria-hidden="true"></i>
                Previous Chapter
            </a>

            <select class="chapter-selector" onchange="location = this.value;">

                <?php foreach ($chapterList as $index => $chapter) :
                    $chapterNumber = $index + 1;
                    $chapterTitle = "Chapter " . $chapterNumber; ?>

                    <option value=<?php echo "comicreader.php?id=" . $chapter->getId() ?> <?php if ($chapter->getId() == $currentChapterId) {
                                                                                                echo 'selected';
                                                                                            } ?>>
                        <?php echo $chapterTitle ?>
                    </option>

                <?php endforeach ?>
            </select>

            <a href="<?php echo $nextChapterLink ?>">
                Next Chapter
                <i class="fa fa-chevron-right" style="color: white; margin-left: 10px;" aria-hidden="true"></i>
            </a>
        </div>
    </div>

    <div class="chapter-indicator">
        <a href="homepage.php" target="_blank">Home</a>

        <span>/</span>

        <a href=<?php echo $manga->getLink() ?>>
            <?php echo $manga->getTitle() ?>
        </a>

        <span>/</span>

        <a href="">
            <?php echo "Chapter " . $currentChapter->getChapterNumber(); ?>
        </a>

    </div>

    <div class="comic-strip">
        <?php foreach ($pageList as $index => $page) : ?>
            <img src=" <?php echo $page->getImageLocation() ?> ">
        <?php endforeach; ?>
    </div>

    <div class="footer">
        <span>Chapter</span>

        <select style="display: inline; margin-right: 0px;" onchange="location = this.value; ">
            <?php foreach ($chapterList as $index => $chapter) :
                $chapterNumber = $index + 1;
                $chapterTitle = "Chapter " . $chapterNumber . " " . $chapter->getTitle(); ?>

                <option value=<?php echo "comicreader.php?id=" . $chapter->getId() ?> <?php if ($chapter->getId() == $currentChapterId) {
                                                                                            echo 'selected';
                                                                                        } ?>>
                    <?php echo $chapterTitle ?>
                </option>

            <?php endforeach ?>
        </select>

        <a href="<?php echo $prevChapterLink ?>">
            <i class="fa fa-arrow-left" style="color: #AF002A; margin-left: 10px;" aria-hidden="true"></i>
        </a>

        <a href="<?php echo $nextChapterLink ?>">
            <i class="fa fa-arrow-right" style="color: #AF002A; margin-left: 5px;" aria-hidden="true"></i>
        </a>

    </div>

    <p class="back-to-top-text">[ Back to top ]</p>

</body>

</html>

<script>
    // Constants for AJAX response type
    const INSUFFICIENT_BALANCE = <?php echo json_encode(Chapter::INSUFFICIENT_BALANCE) ?>;
    const PURCHASE_FAILED = <?php echo json_encode(Chapter::PURCHASE_FAILED) ?>;
    const PURCHASE_SUCCESS = <?php echo json_encode(Chapter::PURCHASE_SUCCESS) ?>;

    var chapterIsAvailable = <?php echo json_encode($chapterAvailability); ?>;
    var userNotLoggedIn = <?php echo json_encode($user == null); ?>;

    var userId = <?php echo json_encode($userId); ?>;
    var chapterId = <?php echo json_encode($currentChapterId); ?>;

    if (!chapterIsAvailable) {
        $("#paywallModal").modal();
    }

    $("#btn-close-dialog").click(function() {
        $("#paywallModal").modal("hide");
    });

    function processPayment() {
        if (userNotLoggedIn) {
            alert("Please log in first!");

        } else {
            // Show the loading indicator
            $("#loading-indicator").css("display", "block");

            var topupErrorBox = $(".topup-error-text");
            var topupErrorText = topupErrorBox.find("span");

            topupErrorBox.css("display", "none");

            $.ajax({
                    url: "PurchaseChapterHandle.php",
                    type: "POST",
                    data: {
                        "userId": userId,
                        "chapterId": chapterId
                    }
                })
                .always(function(response) {
                    var status = response.message;

                    switch (status) {
                        case INSUFFICIENT_BALANCE:
                            // Show the error indicator
                            topupErrorText.text = "You do not have enough points! Please topup before proceeding";
                            topupErrorBox.css("display", "block");
                            break;

                        case PURCHASE_FAILED:
                            // Show the error indicator
                            topupErrorText.text = "Error purchasing. Please try again.";
                            topupErrorBox.css("display", "block");
                            break;

                        case PURCHASE_SUCCESS:
                            // Hide the payment button & previous error indicator if shown, 
                            $("#btn-pay").css("display", "none");
                            topupErrorBox.css("display", "none");

                            // then show the success indicator & close button
                            $("#btn-close-dialog").css("display", "block");
                            $("#success-indicator").css("display", "block");
                            break;
                    }

                    $("#loading-indicator").css("display", "none");
                })
                .fail(function(response) {
                    // HTTP Errorrs go here
                });
        }
    }
</script>