<head>
    <link rel="stylesheet" href="content/fontawesome-free-5.12.1-web/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap-4.4.1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="library/OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="library/OwlCarousel2-2.3.4/dist/assets/owl.theme.default.min.css">
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
    <script src="scripts/jquery-3.4.1.js"></script>
    <script src="css/bootstrap-4.4.1-dist/js/bootstrap.min.js"></script>

    <style>
        .background {
            background-color: #F7F7F7;
        }

        .latest-released-banner {
            display: flex;
            flex-direction: row;
            padding-left: 16px;
            padding-top: 16px;
        }

        .latest-released-icon {
            margin-top: 8px;
            font-size: 32px;
            color: #b30000;
        }

        .banner-title {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-weight: 550;
            font-size: 24px;
            margin-left: 20px;
            margin-top: 6px;
        }

        .manga-item {
            width: 1000px;
            padding-top: 16px;
            padding-bottom: 16px;
            margin-left: 20px;
        }

        .manga-info {
            margin-left: 20px;
        }

        .manga-cover {
            width: auto;
            height: 240px;
            object-fit: cover;
            background-size: cover;
        }

        .manga-title {
            font-size: 20px;
            font-weight: 600;
            text-overflow: ellipsis;
            margin-bottom: 4px;
            margin-top: 10px;
            text-decoration: none;
            color: black;
        }

        .manga-title :hover {
            text-decoration: none;
            color: red;
        }

        .manga-description {
            color: gray;
            font-size: 14px;
            margin-top: 20px;
        }

        .chapter-title {
            font-weight: 500;
            margin-left: 5px;
            color: #ff3f60;
        }

        .manga-summary {
            display: -webkit-box;
            max-width: 100%;
            margin: 0 auto;
            -webkit-line-clamp: 2;
            /* autoprefixer: off */
            -webkit-box-orient: vertical;
            /* autoprefixer: on */
            overflow: hidden;
            text-overflow: ellipsis;
            color: gray;
        }

        .genre-list {
            display: flex;
            flex-wrap: wrap;
            margin-top: 16px;
        }

        .genre-list a {
            margin-right: 6px;
            margin-bottom: 5px;
            text-decoration: none;
            color: #4c4c4c;
            font-size: 10pt;
            border: 1px #4c4c4c solid;
            border-radius: 10px;
            padding: 5px 10px;
        }

        .logo-1 {
            left: -30px;
            height: 30px;
            width: 50px;
            padding-top: 5px;
            margin-right: 12px;
            border-radius: 2px;
            line-height: 20px;
            text-align: center;
            color: #fff;
            font-size: 16px;
            background: #ff2c2c;
        }

        .logo-2 {
            left: -30px;
            height: 30px;
            width: 50px;
            padding-top: 5px;
            margin-right: 12px;
            border-radius: 2px;
            line-height: 20px;
            text-align: center;
            color: #fff;
            font-size: 16px;
            background: #ffb328;
        }

        .logo-3 {
            left: -30px;
            height: 30px;
            width: 50px;
            padding-top: 5px;
            margin-right: 12px;
            border-radius: 2px;
            line-height: 20px;
            text-align: center;
            color: #fff;
            font-size: 16px;
            background: #ffd628;
        }

        .logo-more-than-3 {
            left: -30px;
            height: 30px;
            width: 50px;
            padding-top: 5px;
            margin-right: 12px;
            border-radius: 2px;
            line-height: 20px;
            text-align: center;
            color: #fff;
            font-size: 16px;
            background: #a6a6a6;
        }
    </style>

<body>
    <?php
    require_once "header.php";
    require_once "models/Manga.php";
    require_once "models/Chapter.php";
    require_once "models/Genre.php";
    require_once "models/Rating.php";

    $mangaList = Manga::getPopularManga(30);
    ?>

    <div class="background">
        <div class="container">
            <div class="latest-released-banner" style="margin-left: 16px;">
                <i class="far fa-clock latest-released-icon"></i>
                <span class="banner-title">Popular Rankings</span>
            </div>

            <ul style="list-style-type: none;">
                <?php foreach ($mangaList as $index => $manga) :
                    $latestChapter = Chapter::getLatestChapter($manga->getId());
                    $rankingNumber = $index + 1;

                    if ($rankingNumber <= 3) {
                        $logoName = "logo-" . $rankingNumber;
                    } else {
                        $logoName = "logo-more-than-3";
                    }
                ?>

                    <li class="manga-item">
                        <div style="display: flex;">
                            <p class="<?php echo $logoName ?>">
                                <?php echo $rankingNumber ?>
                            </p>

                            <a href="comicpage.php?id=<?php echo $manga->getId() ?>" target="_blank">
                                <img class="manga-cover" style="flex: 10%;" src="<?php echo $manga->getCoverImage() ?>">
                            </a>

                            <div class="manga-info" style="flex: 100%;">
                                <h3 class="manga-title-container">
                                    <a class="manga-title" href="comicpage.php?id=<?php echo $manga->getId() ?>" target="_blank">
                                        <?php echo $manga->getTitle() ?>
                                    </a>
                                </h3>

                                <div>
                                    <?php
                                    $stars = Rating::getRating($manga->getId());

                                    for ($i = 0; $i < 5; $i++) {

                                        if ($stars > 0.5) {
                                            // Output full star
                                            echo '<i class="fa fa-star" style="color: red; margin-right:2px;" aria-hidden="true"></i>';
                                        } else if ($stars > 0) {
                                            // Output half star
                                            echo '<i class="fa fa-star-half-o" style="color: red; margin-right:2px;" aria-hidden="true"></i>';
                                        } else {
                                            // Output empty star
                                            echo '<i class="fa fa-star-o" style="color: red; margin-right:2px;" aria-hidden="true"></i>';
                                        }
                                        $stars = $stars - 1;
                                    }
                                    ?>
                                </div>

                                <div class="manga-description" style="color: #252525">
                                    Latest:
                                    <a class="chapter-title" href="<?php echo $latestChapter->getLink() ?>">
                                        <?php echo $latestChapter->getTitle(); ?>
                                    </a>
                                </div>

                                <div class="manga-description" style="color: #252525">
                                    View count:
                                    <a class="chapter-title">
                                        <?php echo $manga->getViewCount(); ?>
                                    </a>
                                </div>

                                <div class="manga-description" style="color: #252525">
                                    Summary:
                                    <span class="manga-summary">
                                        <?php echo $manga->getSummary() ?>
                                    </span>
                                </div>

                                <div class="genre-list">
                                    <?php foreach (Genre::getMangaGenres($manga->getId()) as $genre) : ?>
                                        <a href="">
                                            <?php echo $genre->getName(); ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>

                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>

        </div>
    </div>
</body>

</head>