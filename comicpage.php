<?php
session_start();
?>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="css/star-rating.css">
    <link rel="stylesheet" href="css/bttn.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap-4.4.1-dist/css/bootstrap.min.css">
    <script src="scripts/jquery-3.4.1.js"></script>
    <script src="css/bootstrap-4.4.1-dist/js/bootstrap.min.js"></script>

    <style>
        body {
            height: 1000px;
        }

        a {
            text-decoration: none;
            color: black;
        }

        a:hover {
            text-decoration: none;
            color: black;
        }

        .banner-container {
            background-color: #f2f0f0;

        }

        .banner-bg {
            background-color: #f2f0f0;
            width: 100%;
            height: 75px;
        }

        .banner-details {
            display: flex;
            flex-flow: row wrap;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
            background-color: white;
            z-index: 1;
            margin-top: 20px;
            margin-left: 10px;
            margin-right: 10px;
        }

        .banner-image-container {
            margin-top: -60px;
            margin-right: 25px;
            margin-left: 60px;
            margin-bottom: 12px;
        }

        .banner-image-container img {
            max-width: 190;
            max-height: 260;
            border-radius: 10px;
            box-shadow: 0 0 5px #444;
        }

        .banner-text {
            width: 70%;
            margin-left: 25px;
            margin-top: 10px;
        }

        .genre-list a {
            margin-right: 6px;
            text-decoration: none;
            color: #4c4c4c;
            font-size: 10pt;
            border: 1px #4c4c4c solid;
            border-radius: 10px;
            padding: 5px;
        }

        .genre-list a:hover {
            text-decoration: none;
            color: black;
        }

        .btn-startReading {
            text-decoration: none;
            color: white;
            background-color: #ff1919;
            padding: 12px;
            border-radius: 5px;
            font-weight: 500;
            margin-right: 18px;
        }

        .btn-startReading:hover {
            text-decoration: none;
            color: white;
            background-color: red;
        }

        .btn-bookmark {
            background-color: #ffc240;
            padding: 12px;
            border-radius: 5px;
        }

        .btn-bookmark a {
            text-decoration: none;
            color: black;
            font-weight: 500;
        }

        .btn-bookmark a:hover {
            text-decoration: none;
            color: black;
        }

        .main-content {
            display: flex;
        }

        .chapter-container {
            width: 80%;
            background-color: white;
            padding-left: 50px;
        }

        .total-chapters {
            color: #a6a6a6;
            margin-left: 12px;
            font-weight: 400;
        }

        .chapter-label {
            text-decoration: none;
            color: black;
            font-weight: 500;
            font-size: 14pt;
        }

        .chapter-label:hover {
            text-decoration: none;
            color: #ffc240;
        }

        .chapter-list {
            list-style-type: none;
            padding: 0px;
            margin-top: 20px;
        }

        .chapter-list li {
            background-color: #f6f6f6;
            padding: 10px;
            margin-bottom: 15px;
            margin-right: 20px;
        }

        .chapter-list li:hover {
            background-color: wheat;
        }

        .chapter-list a {
            display: flex;
            text-decoration: none;
            color: black;
        }

        .chapter-item-tags {
            margin-bottom: 0px;
        }

        .chapter-list a:hover {
            text-decoration: none;
            color: #875800;
        }

        .right-sidebar {
            background-color: white;
            width: 20%;
        }

        .uploader-details {
            border: solid lightgray 1px;
            margin-left: 10px;
            margin-right: 20px;
            padding-top: 20px;
        }

        .center {
            display: block;
            margin: 0 auto;
        }

        .top-manga-label {
            border: solid lightgray 1px;
            border-bottom: none;
            margin-left: 10px;
            margin-right: 20px;
            margin-bottom: 0px;
            text-align: center;
        }

        .sidebar-top-manga {
            border: solid lightgray 1px;
            list-style-type: none;
            margin-left: 10px;
            margin-right: 20px;
            padding: 0px;
        }

        .sidebar-top-manga li {
            min-height: 120px;
            margin-top: 12px;
            border-bottom: dashed lightgray 1px;
        }

        .sidebar-top-manga:last-child {
            border-bottom: none;
        }

        .block-with-text {
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .title-with-rating {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .rate-btn {
            display: inline-block;
            padding: 0.46em 1.6em;
            border: 0.1em solid #000000;
            margin: 0 0.2em 0.2em 0;
            border-radius: 1em;
            box-sizing: border-box;
            text-decoration: none;
            font-family: 'Roboto', sans-serif;
            font-weight: 300;
            color: #000000;
            text-shadow: 0 0.04em 0.04em rgba(0, 0, 0, 0.35);
            background-color: #FFFFFF;
            text-align: center;
            transition: all 0.15s;
            margin-top: 10px;
        }

        .rate-btn:hover {
            color: red;
            border-color: red;
        }

        .rate-btn:active {
            color: #BBBBBB;
            border-color: #BBBBBB;
        }

        .rating-text {
            font-size: 28pt;
            font-weight: 500;
            margin-right: 6px;
        }
    </style>
</head>

<body>
    <?php
    require_once "header.php";
    require_once "models/Manga.php";
    require_once "models/Genre.php";
    require_once "models/Author.php";
    require_once "models/Chapter.php";
    require_once "models/Bookmark.php";
    require_once "models/Rating.php";

    $id = $_GET['id'];
    $manga = Manga::getById($id);
    $authorId = $manga->getAuthorId();
    $chapterList = Chapter::getAllChapters($manga->getId());

    $userId = "";
    $bookmarkStatus = "";
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];
        $bookmarkStatus = Bookmark::checkStatus($manga->getId(), $userId);
    }
    $averageRating = Rating::getRating($id);
    ?>

    <!-- Modal -->
    <div id="rating-modal" class="modal fade" data-backdrop="false">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header text-center">
                    <div class="w-100">
                        <span>How would you rate</span>
                        <span style="font-weight: bold">
                            <?php echo $manga->getTitle() ?>
                        </span>
                        <span>?</span>

                    </div>
                </div>

                <div class="modal-body">
                    <section class='rating-widget'>

                        <!-- Rating Stars Box -->
                        <div class='rating-stars text-center'>
                            <ul id='stars'>
                                <li class='star' title='Poor' data-value='1'>
                                    <i class='fa fa-star fa-fw'></i>
                                </li>

                                <li class='star' title='Fair' data-value='2'>
                                    <i class='fa fa-star fa-fw'></i>
                                </li>

                                <li class='star' title='Good' data-value='3'>
                                    <i class='fa fa-star fa-fw'></i>
                                </li>

                                <li class='star' title='Excellent' data-value='4'>
                                    <i class='fa fa-star fa-fw'></i>
                                </li>

                                <li class='star' title='WOW!!!' data-value='5'>
                                    <i class='fa fa-star fa-fw'></i>
                                </li>
                            </ul>
                        </div>

                        <div class='success-box'>
                            <div class='clearfix'></div>
                            <!-- <img alt='tick image' width='32' src='data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeD0iMHB4IiB5PSIwcHgiIHZpZXdCb3g9IjAgMCA0MjYuNjY3IDQyNi42NjciIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDQyNi42NjcgNDI2LjY2NzsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHdpZHRoPSI1MTJweCIgaGVpZ2h0PSI1MTJweCI+CjxwYXRoIHN0eWxlPSJmaWxsOiM2QUMyNTk7IiBkPSJNMjEzLjMzMywwQzk1LjUxOCwwLDAsOTUuNTE0LDAsMjEzLjMzM3M5NS41MTgsMjEzLjMzMywyMTMuMzMzLDIxMy4zMzMgIGMxMTcuODI4LDAsMjEzLjMzMy05NS41MTQsMjEzLjMzMy0yMTMuMzMzUzMzMS4xNTcsMCwyMTMuMzMzLDB6IE0xNzQuMTk5LDMyMi45MThsLTkzLjkzNS05My45MzFsMzEuMzA5LTMxLjMwOWw2Mi42MjYsNjIuNjIyICBsMTQwLjg5NC0xNDAuODk4bDMxLjMwOSwzMS4zMDlMMTc0LjE5OSwzMjIuOTE4eiIvPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K' /> -->
                            <div class='rating-message'>
                                Please rate it!
                            </div>
                            <div class='clearfix'></div>
                        </div>


                        <button id="btn-set-rating" type="button" class="btn btn-danger" style="width: 100%;">
                            Confirm
                        </button>

                    </section>

                </div>

                <div class="modal-footer">
                    <button style="width: 100%;" type="button" class="btn btn-default" data-dismiss="modal">
                        Close
                    </button>
                </div>

            </div>

        </div>
    </div>

    <div class="banner-container">
        <div class="banner-bg"></div>

        <div class="banner-details">
            <div class="banner-image-container">
                <img src="<?php echo $manga->getCoverImage() ?>">
            </div>
            <div class="banner-text">

                <div class="title-with-rating">

                    <div class="big-title">
                        <h3>
                            <?php echo $manga->getTitle() ?>
                        </h3>

                        <p>
                            <span>
                                Author:
                                <a href="">
                                    <?php
                                    $author = Author::getById($authorId);
                                    echo $author->getName();
                                    ?>
                                </a>
                            </span>
                        </p>
                    </div>

                    <div class="rating">
                        <div>
                            <span class="rating-text">
                                <?php echo $averageRating ?>
                            </span>

                            <?php if (is_numeric($averageRating)) : ?>
                                <span>Rating</span>
                            <?php else : ?>
                                <span>No rating yet</span>
                            <?php endif; ?>

                        </div>

                        <button class="rate-btn" data-toggle="modal" data-target="#rating-modal">Rate this Comic!</button>
                    </div>
                </div>

                <p>
                    <span>
                        Status: <span> <?php echo $manga->getStatus(); ?> </span>
                    </span>
                </p>

                <p class="genre-list">
                    <?php foreach (Genre::getMangaGenres($manga->getId()) as $genre) : ?>
                        <a href="">
                            <?php echo $genre->getName(); ?>
                        </a>
                    <?php endforeach; ?>

                </p>

                <p style="margin-bottom: 32px;">
                    <?php echo $manga->getSummary(); ?>
                </p>

                <p>
                    <a class="btn-startReading" href="">Start Reading</a>

                    <span class="btn-bookmark">
                        <a href="javascript:void(0)">
                            <i class="fa fa-bookmark-o" aria-hidden="true" style="color: black; margin-right: 10px;"></i>
                            <span id="bookmark-status">Bookmark</span>
                        </a>
                    </span>
                </p>
            </div>
        </div>

        <div class="main-content">

            <div class="chapter-container">
                <div>
                    <a class="chapter-label" href="javascript:void(0)">CHAPTERS</a>
                    <span class="total-chapters">
                        <?php echo count($chapterList) ?>
                    </span>
                </div>

                <hr>

                <div>
                    <ul class="chapter-list">
                        <?php foreach ($chapterList as $chapter) :
                            $numberedChapterTitle = "Ch " . $chapter->getChapterNumber() . " " . $chapter->getTitle();
                            $hasPaywall = $chapter->getPrice() > 0;
                        ?>

                            <li>
                                <a href=<?php echo "comicreader.php?id=" . $chapter->getId() ?>>

                                    <p class="chapter-item-tags"> <?php echo $numberedChapterTitle ?> </p>

                                    <p class="chapter-item-tags" style="margin-left: auto;">

                                        <?php if ($hasPaywall): ?>
                                            <i class="fa fa-lock" aria-hidden="true" style="color: red; margin-right: 16px; line-height: 20px;"></i>
                                        <?php endif; ?>

                                        <?php echo $chapter->getDateUploaded() ?>
                                    </p>

                                </a>
                            </li>

                        <?php endforeach ?>
                    </ul>
                </div>

            </div>

            <div class="right-sidebar">
                <div class="uploader-details">
                    <p style="text-align: center;">Uploaded By</p>
                    <img class="center" style="margin-bottom: 8px;" src="img/default_avatar.png" width="40" height="40">
                    <p style="text-align: center;">flamyoad</p>
                </div>

                <div style="margin-top: 20px;">
                    <p class="top-manga-label">Top Comic</p>
                    <ul class="sidebar-top-manga">
                        <li>
                            <img src="img/hxh.jpg" style="float: left; object-fit:contain" width="100" height="100">
                            <p style="font-size: 10pt; font-weight:500;">Hunter x Hunter</p>
                            <p class="block-with-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vulputate urna diam, vitae blandit mauris faucibus id. Integer sit amet tempor arcu, vitae rutrum elit. Maecenas ultrices at ante et congue. Etiam viverra imperdiet libero quis tincidunt. Suspendisse potenti. Vestibulum eu ante tortor. Sed eleifend tellus et nunc fermentum, ac porta ex euismod. Mauris ante massa, pellentesque at eros vel, varius ullamcorper neque. Maecenas pretium ex quis dui dapibus mollis. Donec quam enim, maximus interdum consectetur nec, tempor sed magna. Nulla accumsan justo sed enim gravida, feugiat suscipit turpis viverra. Nunc vitae iaculis erat. Duis vestibulum, massa consectetur porta cursus, est turpis sodales quam, non egestas ex augue vel quam.</p>
                        </li>

                        <li>
                            <img src="img/hxh.jpg" style="float: left; object-fit:contain" width="100" height="100">
                            <p style="font-size: 10pt; font-weight:500;">Hunter x Hunter</p>
                            <p class="block-with-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vulputate urna diam, vitae blandit mauris faucibus id. Integer sit amet tempor arcu, vitae rutrum elit. Maecenas ultrices at ante et congue. Etiam viverra imperdiet libero quis tincidunt. Suspendisse potenti. Vestibulum eu ante tortor. Sed eleifend tellus et nunc fermentum, ac porta ex euismod. Mauris ante massa, pellentesque at eros vel, varius ullamcorper neque. Maecenas pretium ex quis dui dapibus mollis. Donec quam enim, maximus interdum consectetur nec, tempor sed magna. Nulla accumsan justo sed enim gravida, feugiat suscipit turpis viverra. Nunc vitae iaculis erat. Duis vestibulum, massa consectetur porta cursus, est turpis sodales quam, non egestas ex augue vel quam.</p>
                        </li>

                        <li>
                            <img src="img/hxh.jpg" style="float: left; object-fit:contain" width="100" height="100">
                            <p style="font-size: 10pt; font-weight:500;">Hunter x Hunter</p>
                            <p class="block-with-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vulputate urna diam, vitae blandit mauris faucibus id. Integer sit amet tempor arcu, vitae rutrum elit. Maecenas ultrices at ante et congue. Etiam viverra imperdiet libero quis tincidunt. Suspendisse potenti. Vestibulum eu ante tortor. Sed eleifend tellus et nunc fermentum, ac porta ex euismod. Mauris ante massa, pellentesque at eros vel, varius ullamcorper neque. Maecenas pretium ex quis dui dapibus mollis. Donec quam enim, maximus interdum consectetur nec, tempor sed magna. Nulla accumsan justo sed enim gravida, feugiat suscipit turpis viverra. Nunc vitae iaculis erat. Duis vestibulum, massa consectetur porta cursus, est turpis sodales quam, non egestas ex augue vel quam.</p>
                        </li>


                        <li>
                            <img src="img/hxh.jpg" style="float: left; object-fit:contain" width="100" height="100">
                            <p style="font-size: 10pt; font-weight:500;">Hunter x Hunter</p>
                            <p class="block-with-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vulputate urna diam, vitae blandit mauris faucibus id. Integer sit amet tempor arcu, vitae rutrum elit. Maecenas ultrices at ante et congue. Etiam viverra imperdiet libero quis tincidunt. Suspendisse potenti. Vestibulum eu ante tortor. Sed eleifend tellus et nunc fermentum, ac porta ex euismod. Mauris ante massa, pellentesque at eros vel, varius ullamcorper neque. Maecenas pretium ex quis dui dapibus mollis. Donec quam enim, maximus interdum consectetur nec, tempor sed magna. Nulla accumsan justo sed enim gravida, feugiat suscipit turpis viverra. Nunc vitae iaculis erat. Duis vestibulum, massa consectetur porta cursus, est turpis sodales quam, non egestas ex augue vel quam.</p>
                        </li>


                        <li>
                            <img src="img/hxh.jpg" style="float: left; object-fit:contain" width="100" height="100">
                            <p style="font-size: 10pt; font-weight:500;">Hunter x Hunter</p>
                            <p class="block-with-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vulputate urna diam, vitae blandit mauris faucibus id. Integer sit amet tempor arcu, vitae rutrum elit. Maecenas ultrices at ante et congue. Etiam viverra imperdiet libero quis tincidunt. Suspendisse potenti. Vestibulum eu ante tortor. Sed eleifend tellus et nunc fermentum, ac porta ex euismod. Mauris ante massa, pellentesque at eros vel, varius ullamcorper neque. Maecenas pretium ex quis dui dapibus mollis. Donec quam enim, maximus interdum consectetur nec, tempor sed magna. Nulla accumsan justo sed enim gravida, feugiat suscipit turpis viverra. Nunc vitae iaculis erat. Duis vestibulum, massa consectetur porta cursus, est turpis sodales quam, non egestas ex augue vel quam.</p>
                        </li>


                    </ul>
                </div>
            </div>

        </div>

    </div>

</body>


</html>

<script>
    var hasBeenBookmarked = "<?php echo $bookmarkStatus ?>";
    var mangaId = <?php echo $manga->getId() ?>;
    var userId = "<?php echo $userId ?>";

    $(document).ready(function() {
        console.log(hasBeenBookmarked);
        if (hasBeenBookmarked == true) {
            $(".btn-bookmark").addClass("bookmarked");
            $("#bookmark-status").text("Bookmarked");
        }

        $(".btn-bookmark").click(function() {
            if ($(".btn-bookmark").hasClass("bookmarked")) {
                removeBookmark();
            } else {
                addBookmark();
            }
        });

        /* 1. Visualizing things on Hover - See next part for action on click */
        $('#stars li').on('mouseover', function() {
            var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on

            // Now highlight all the stars that's not after the current hovered star
            $(this).parent().children('li.star').each(function(e) {
                if (e < onStar) {
                    $(this).addClass('hover');
                } else {
                    $(this).removeClass('hover');
                }
            });

        }).on('mouseout', function() {
            $(this).parent().children('li.star').each(function(e) {
                $(this).removeClass('hover');
            });
        });


        /* 2. Action to perform on click */
        $('#stars li').on('click', function() {
            var onStar = parseInt($(this).data('value'), 10); // The star currently selected
            var stars = $(this).parent().children('li.star');

            for (i = 0; i < stars.length; i++) {
                $(stars[i]).removeClass('selected');
            }

            for (i = 0; i < onStar; i++) {
                $(stars[i]).addClass('selected');
            }

            var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);

            var message = "Rating ";
            if (ratingValue == 1) {
                message += " 1 star";
            } else {
                message += (ratingValue + " stars");
            }
            $(".rating-message").text(message);
        });


        $("#btn-set-rating").on('click', function() {
            if (userId == false) {
                alert("Please log in first!");
            } else {
                var rating = parseInt($('#stars li.selected').last().data('value'), 10);
                sendRating(rating);
            }
        })
    });

    function addBookmark() {
        // Render button unclickable
        $(".btn-bookmark").find("i")
            .removeClass("fa fa-bookmark-o")
            .addClass("fa fa-spinner")

        $.ajax({
                url: "AddBookmarkHandle.php",
                type: "POST",
                data: {
                    "mangaId": mangaId,
                    "userId": userId
                }
            })
            .always(function(response) {
                $(".btn-bookmark").find("i")
                    .removeClass("fa fa-spinner")
                    .addClass("fa fa-bookmark-o");
            })
            .fail(function(response) {

            })
            .done(function(response) {
                $(".btn-bookmark").addClass("bookmarked");
                $("#bookmark-status").text("Bookmarked");
            })
    }

    function removeBookmark() {
        $(".btn-bookmark").find("i")
            .removeClass("fa fa-bookmark-o")
            .addClass("fa fa-spinner")

        $.ajax({
                url: "RemoveBookmarkHandle.php",
                type: "POST",
                data: {
                    mangaId: mangaId,
                    userId: userId
                }
            })
            .always(function(response) {
                $(".btn-bookmark").find("i")
                    .removeClass("fa fa-spinner")
                    .addClass("fa fa-bookmark-o");
            })
            .fail(function(response) {
                // Log.d failed
            })
            .done(function(response) {
                $(".btn-bookmark").removeClass("bookmarked");
                $("#bookmark-status").text("Bookmark");
            })
    }

    function sendRating(ratedValue) {
        console.log(ratedValue);
        $.ajax({
                url: "SendRatingHandle.php",
                type: "POST",
                data: {
                    mangaId: mangaId,
                    userId: userId,
                    ratedValue: ratedValue
                }
            })
            .always(function(response) {
                $('#rating-modal').modal('hide');
            })
            .fail(function(response) {
                // Log.d failed
            })
    }
</script>