<?php
session_start();
?>

<head>
    <link rel="stylesheet" href="content/fontawesome-free-5.12.1-web/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap-4.4.1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="library/OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="library/OwlCarousel2-2.3.4/dist/assets/owl.theme.default.min.css">
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
    <link rel="stylesheet" href="css/top-ranking-logo.css">
    <script src="scripts/jquery-3.4.1.js"></script>
    <script src="css/bootstrap-4.4.1-dist/js/bootstrap.min.js"></script>
    <script src="library/OwlCarousel2-2.3.4/dist/owl.carousel.min.js"></script>

</head>

<style>
    .background {
        background-color: #F7F7F7;
    }

    .after-carousel {
        padding: 18px;
        display: flex;
    }

    .latest-released-icon {
        margin-top: 8px;
        font-size: 32px;
        color: #b30000;
    }

    .left {
        flex: 6;
    }

    .right {
        flex: 3;
        padding-left: 20px;
    }

    .latest-released-banner {
        display: flex;
        flex-direction: row;
        padding-left: 16px;
        padding-top: 16px;
    }

    .banner-title {
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        font-weight: 550;
        font-size: 24px;
        margin-left: 20px;
        margin-top: 6px;
    }

    .see-more {
        margin-left: auto;
    }

    .see-more a {
        text-decoration: none;
        color: black;
    }

    .see-more a:hover {
        text-decoration: none;
        color: black;
    }

    .manga-list {
        list-style-type: none;
        display: flex;
        flex-flow: row wrap;
        padding: 0px;
    }

    .manga-item {
        width: 200px;
        padding-top: 16px;
        padding-bottom: 16px;
        margin-left: 20px;
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
        width: auto;
        height: 200px;
        object-fit: cover;
        background-size: cover;
    }

    .manga-title {
        font-size: 20px;
        font-weight: 600;
        text-overflow: ellipsis;
        margin-bottom: 4px;
        margin-top: 10px;
    }

    .manga-description {
        color: gray;
        font-size: 14px;
        text-overflow: ellipsis;
    }

    .top-manga-text {
        font-size: 16px;
        color: #2f2f2f;
        letter-spacing: 0;
        font-weight: 700;
        margin-bottom: 12px;
    }

    .top-manga-list {
        list-style-type: none;
    }

    .top-manga-list li {
        border-bottom: 1px dotted #d8d8d8;
        position: relative;
    }

    .top-manga-list-title {
        margin-top: 8px;
    }

    .top-manga-list-title a {
        font-size: 14px;
        color: #222;
        letter-spacing: 0;
    }

    .top-manga-list-sub {
        margin-bottom: 4px;
    }

    .top-manga-list-sub a {
        font-size: 12px;
        color: #a6a6a6;
        margin-top: 8px;
        letter-spacing: 0;
    }

    .genre-table {
        border-collapse: collapse;
        width: 100%;
    }

    /* .genre-table tr:nth-child(even) {
        background-color: #f2f2f2;
    } */

    .genre-table tr:nth-child(odd) {
        background-color: rgb(249, 245, 242);
    }

    */ .genre-table tr {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
    }

    .genre-link {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        font-size: 10pt;
        color: black;
    }

    .genre-link:hover {
        text-decoration: none;
        color: coral;
    }

    .btn-more {
        width: 100%;
        font: 300 16px/43px Open Sans, Tahoma, Geneva, sans-serif;
        color: white;
        text-align: center;
        background: rgb(219, 80, 55) url(icons/circle-arrow.png) 60% center no-repeat;
        cursor: pointer;
        margin-right: 70px;
        transition: 0.5s;
    }

    .btn-more:hover {
        background-color: firebrick;
        color: white;
        opacity: 1;
        text-decoration: none;
    }

    .carousel-prev-btn,
    .carousel-next-btn {
        height: 40;
        width: 40;

        /* To remove the gaps between both buttons. These two attributes are necessary */
        display: block;
        float: left;
        /*                                                                             */

        /* Remove default CSS of <button> */
        outline: none;
        border: none;
        background: rgb(128, 128, 128, 0.7);
    }

    .carousel-prev-btn:hover,
    .carousel-next-btn:hover {
        background: rgb(219, 80, 55, 0.7);
    }

    .carousel-nav {
        position: absolute;
        top: 24;
        left: 32;
        z-index: 2;
    }

    .carousel-manga-caption {
        position: absolute;
        bottom: 0;
        width: 100%;
        background: rgba(0, 0, 0, 0.8);
        padding-left: 10px;
        padding-top: 4px;
        padding-bottom: 4px;
    }

    .carousel-manga-title {
        color: white;
        font: 12px Open Sans, Tahoma, Geneva, sans-serif;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .carousel-manga-title:hover {
        color: white;
    }

    .carousel-chapter-title {
        color: #C7C6C1;
        font: 12px Open Sans, Tahoma, Geneva, sans-serif;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .carousel-chapter-title:hover {
        color: #C7C6C1;
    }

    .carousel-manga-image {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }

    .owl-item {
        width: 180px;
    }
</style>

<html>

<body>

    <?php
    require_once "header.php";
    require_once "models/Manga.php";
    require_once "models/Chapter.php";
    require_once "models/Genre.php";
    ?>

    <div class="background">
        <div class="container">

            <div class="latest-released-banner" style="margin-left: 16px;">
                <i class="far fa-clock latest-released-icon"></i>
                <span class="banner-title">Popular Releases</span>

            </div>

            <div class="owl-carousel owl-theme owl-loaded" style="padding: 24px 32px 0px 32px;">
                <div class="carousel-nav">
                    <button class="carousel-prev-btn"><i style="color: white;" class='fa fa-long-arrow-left'></i></button>
                    <button class="carousel-next-btn"><i style="color: white;" class='fa fa-long-arrow-right'></i></button>
                </div>

                <div class="owl-stage-outer">
                    <div class="owl-stage">

                        <?php foreach (Manga::getPopularManga() as $manga) :
                            $mangaChapter = Chapter::getLatestChapter($manga->getId())
                        ?>
                            <div class="owl-item">
                                <div>
                                    <img class="carousel-manga-image" src="<?php echo $manga->getCoverImage() ?>">
                                </div>
                                <div class="carousel-manga-caption">
                                    <h3>
                                        <a class="carousel-manga-title" href="<?php echo $manga->getLink() ?>">
                                            <?php echo $manga->getTitle() ?>
                                        </a>
                                    </h3>
                                    <a class="carousel-chapter-title" href="<?php echo $mangaChapter->getLink() ?>">
                                        <?php echo $mangaChapter->getTitle() ?>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>

                    </div>

                </div>

            </div>

            <div class="after-carousel">

                <div class="left">
                    <div class="latest-released-banner">
                        <i class="far fa-clock latest-released-icon"></i>
                        <span class="banner-title">Latest Releases</span>

                    </div>

                    <div style="margin-top: 10px;">
                        <ul class="manga-list">

                            <?php foreach (Manga::getLatestManga(12) as $manga) : ?>
                                <li class="manga-item">
                                    <a href="comicpage.php?id=<?php echo $manga->getId() ?>" target="_blank">
                                        <img class="manga-cover" src="<?php echo $manga->getCoverImage() ?>">
                                    </a>

                                    <h3 class="manga-title">
                                        <a href="comicpage.php?id=<?php echo $manga->getId() ?>" target="_blank">
                                            <?php echo $manga->getTitle() ?>
                                        </a>
                                    </h3>

                                    <p class="manga-description">
                                        <i class="fa fa-angle-right" style="margin-right: 4px;" aria-hidden="true"></i>

                                        <?php
                                            $latestChapter = Chapter::getLatestChapter($manga->getId());
                                            echo $latestChapter->getTitle();
                                        ?>
                                    </p>

                                </li>
                            <?php endforeach; ?>

                            <a class="btn-more" href="search.php">More</a>

                        </ul>

                    </div>

                </div>

                <div class="right">
                    <div class="top-manga-text">
                        Top Ranking
                        <a style="float: right;" href="">More</a>
                    </div>

                    <ul class="top-manga-list">
                        <li>
                            <span class="logo-1">1</span>
                            <p class="top-manga-list-title" style="margin-bottom: 5px;">
                                <a href="">A Story About Female Knights</a>
                            </p>
                            <p class="top-manga-list-sub">
                                <a href="">Chapter 111</a>
                            </p>
                        </li>

                        <li>
                            <span class="logo-2">2</span>
                            <p class="top-manga-list-title" style="margin-bottom: 5px;">
                                <a href="">A Story About Female Knights</a>
                            </p>
                            <p class="top-manga-list-sub">
                                <a href="">Chapter 111</a>
                            </p>
                        </li>

                        <li>
                            <span class="logo-3">3</span>
                            <p class="top-manga-list-title" style="margin-bottom: 5px;">
                                <a href="">A Story About Female Knights</a>
                            </p>
                            <p class="top-manga-list-sub">
                                <a href="">Chapter 111</a>
                            </p>
                        </li>

                        <li>
                            <span class="logo-more-than-3">4</span>
                            <p class="top-manga-list-title" style="margin-bottom: 5px;">
                                <a href="">A Story About Female Knights</a>
                            </p>
                            <p class="top-manga-list-sub">
                                <a href="">Chapter 111</a>
                            </p>
                        </li>

                    </ul>

                    <div class="top-manga-text">
                        Genres
                    </div>

                    <table class="genre-table">
                        <tr>
                            <?php foreach (Genre::getAll() as $index => $genre) :
                                // Echo new </tr> tag after 3 items... Skip echo for index == 0
                                if ($index % 3 == 0 && $index > 0) {
                                    echo "</tr>";
                                    echo "<tr>";
                                }
                            ?>

                                <td style="padding-bottom: 7px; padding-top: 7px;" align="center">
                                    <a class="genre-link" href="<?php echo $genre->getLink(); ?>">
                                        <?php echo $genre->getName(); ?>
                                    </a>
                                </td>

                            <?php endforeach; ?>
                    </table>
                </div>
            </div>

        </div>
    </div>

</body>
<html>

<script>
    $(document).ready(function() {
        $(".owl-carousel").owlCarousel({
            items: 8,
            rewind: true,
            autoplay: true,
            autoplayHoverPause: true,
            margin: 3
        });

        var owl = $('.owl-carousel');

        $(".carousel-prev-btn").click(function() {
            // With optional speed parameter
            // Parameters has to be in square bracket '[]'
            owl.trigger('prev.owl.carousel', [300]);
        })

        $(".carousel-next-btn").click(function() {
            owl.trigger('next.owl.carousel');
        })

        <?php if(isset($_SESSION['loginError'])) {
            echo $_SESSION['loginError'];
            unset($_SESSION['loginError']);
        } ?>

    });



</script>