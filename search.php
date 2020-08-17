<?php
session_start();
?>

<head>
    <link rel="stylesheet" href="content/fontawesome-free-5.12.1-web/css/all.min.css">
    <link rel="stylesheet" href="css/bootstrap-4.4.1-dist/css/bootstrap.min.css">
    <script src="scripts/jquery-3.4.1.js"></script>
    <script src="css/bootstrap-4.4.1-dist/js/bootstrap.min.js"></script>

    <style>
        .search-bar {
            background-color: #AF002A;
        }

        .search-bar .my-container {
            display: flex;
            padding: 18px;
        }

        .search-title-input {
            flex: 50%;
            margin-left: 20px;
            text-indent: 10px;
        }

        .search-bar-right-btn {
            text-decoration: none;
            width: 150px;
            height: 36px;
            line-height: 36px;
            border-radius: 18px;
            background-color: #CD5C5C;
            font-size: 16px;
            color: #fff;
            text-align: center;
            display: inline-block;
            margin-left: 12px;
            font-weight: 400;
        }

        .search-bar-right-btn :hover {
            text-decoration: none;
            color: white;
        }

        .white-lbl {
            font-size: 16px;
            color: white;
            letter-spacing: 0;
            font-weight: 700;
            margin: 0px;
            line-height: 40px;
        }

        .filter-list {
            background-color: #F0F0F0;
            overflow: hidden;
        }

        .filter-list-line {
            margin-bottom: 6px;
        }

        .filter-list-line-title {
            font-size: 18px;
            width: 150px;
            height: 35px;
            line-height: 35px;
            text-align: right;
            font-weight: 500;
            display: inline-block;
        }

        .filter-list-line-input {
            margin-left: 12px;
            border: none;
            width: 368px;
            border: solid 1px #ccc;
            border-radius: 3px;
            text-indent: 5px;
        }

        .genre-list-container {
            display: inline-flex;
            flex-direction: column;
        }

        .genre-filter-label {
            display: inline-block;
            margin-left: 12px;
            margin-bottom: 0px;
            font-size: 12px;
            color: #a6a6a6;
            letter-spacing: 0;
            line-height: 35px
        }

        .genre-tagbox {
            padding-left: 10px;
        }

        .genre-tagbox a {
            display: inline-block;
            width: 130px;
            height: 30px;
            line-height: 30px;
            text-align: center;
            font-size: 13px;
            color: #2f2f2f;
            background-color: #fff;
            margin-right: 8px;
            margin-bottom: 10px;
            border-radius: 2px;
            text-decoration: none;
        }

        .genre-tagbox a:hover {
            text-decoration: none;
        }

        .ticked {
            background-color: #FFEBAF !important;
        }

        #rating-preferred-options {
            display: inline-block;
            margin-left: 12px;
            padding: 2px;
        }

        #rating-preferred-value {
            margin-left: 12px;
            padding: 2px;
        }

        .series-status-radiogroup {
            display: inline-block;
            margin-left: 14px;
        }

        .series-status-radiogroup label {
            margin-right: 8px;
        }

        .search-now-btn {
            color: #fff !important;
            text-transform: uppercase;
            text-decoration: none;
            background: #434343;
            padding: 14px 20px;
            border-radius: 5px;
            display: inline-block;
            border: none;
            transition: all 0.4s ease 0s;
            font-weight: 600;
            margin-left: 163px;
            margin-top: 10px;
            margin-bottom: 24px;
        }

        .search-now-btn:hover {
            text-decoration: none;
            background: #434343;
            /* letter-spacing: 1px; */
            -webkit-box-shadow: 0px 5px 40px -10px rgba(0, 0, 0, 0.57);
            -moz-box-shadow: 0px 5px 40px -10px rgba(0, 0, 0, 0.57);
            box-shadow: 5px 40px -10px rgba(0, 0, 0, 0.57);
            transition: all 0.4s ease 0s;
        }

        .search-result {
            background-color: #F7F7F7;
            list-style-type: none;
            display: flex;
            flex-flow: row wrap;
            padding: 18px;
        }

        .manga-item {
            width: 500px;
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
    </style>
</head>

<body>
    <?php
    require_once "header.php";
    require_once "models/Manga.php";
    require_once "models/Chapter.php";
    require_once "models/Genre.php";
    require_once "models/Rating.php";
    require_once "controller/SearchMangaController.php";

    $PAGINATION_LIMIT = 4;

    $pageno = 1;
    if (isset($_GET["page"])) {
        $pageno = $_GET["page"];
    }

    $paginationOffset = ($pageno - 1) * 4;

    $searchController = new SearchMangaController($paginationOffset);

    $mangaList = $searchController->search();

    $genreList = Genre::getAll();

    $totalRecords = $searchController->getTotalNumber();

    $totalPages = ceil($totalRecords / Manga::$itemPerPage);

    /*  If total pages is less than the limit specified, 
        then we don't have to paginate, just show all results starting from 1 to end */
    $paginationStart = 1;
    $paginationEnd = $totalPages;

    /*
        If total pages is more than the limit specified, paginate it
        Example: (Assume the pagination limit specified is 5)
        (1 .. 2 .. 3 .. 4 .. 5)

        If we click on link 2, it becomes like below:
        (2 .. 3 .. 4 .. 5 .. 6)

        If we click on link 3 , it becomes like this:
        (3 .. 4 .. 5 .. 6 .. 7)
    */
    if ($totalPages > $PAGINATION_LIMIT) {
        $paginationStart = $pageno;
        $paginationEnd = $pageno + $PAGINATION_LIMIT;
    }
    ?>

    <form class="filter-list" id="manga-form">

        <div class="search-bar">
            <div class="my-container">
                <p class="white-lbl">
                    SEARCH TITLE
                </p>
                <input class="search-title-input" name="title" placeholder="Name of the comic">
                <input class="search-bar-right-btn" type="submit" value="SEARCH">
            </div>
        </div>

        <div style="padding-top: 20px;">
            <div class="filter-list-line">
                <div class="filter-list-line-title">Author Name</div>
                <input class="filter-list-line-input" type="text" name="author" id="author">
            </div>

            <div class="filter-list-line" style="display: flex; flex: 20%">
                <div class="filter-list-line-title">Genres</div>

                <div class="genre-list-container" style="display: flex; flex: 80%">
                    <p class="genre-filter-label">
                        Click to include genres, click again to remove

                        <div class="genre-tagbox">
                            <?php foreach ($genreList as $genre) : ?>
                                <a href="javascript:void(0);" data-val="<?php echo $genre->getId(); ?>">
                                    <?php echo $genre->getName(); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </p>
                </div>
            </div>

            <div class="filter-list-line" style="display: none;">
                <div class="filter-list-line-title">Rating</div>
                <select id="rating-preferred-options" name="ratingOption" form="manga-form">
                    <option value="any-star">Any stars</option>
                    <option value="more-than">More than</option>
                    <option value="less-than">Less than</option>
                </select>

                <select id="rating-preferred-value" name="ratingValue" form="manga-form" style="display: none;">
                    <option value="1">1 star</option>
                    <option value="2">2 stars</option>
                    <option value="3">3 stars</option>
                    <option value="4">4 stars</option>
                    <option value="5">5 stars</option>
                </select>
            </div>

            <div class="filter-list-line">
                <div class="filter-list-line-title">Series Status</div>
                <div class="series-status-radiogroup">
                    <input type="radio" id="either" name="status" value="either" checked>
                    <label for="either">Either</label>

                    <input type="radio" id="ongoing" name="status" value="ongoing">
                    <label for="ongoing">Ongoing</label>

                    <input type="radio" id="completed" name="status" value="completed">
                    <label for="completed">Completed</label>
                </div>
            </div>

            <div class="filter-list-line">
                <input id="btnSearch" class="search-now-btn" style="width: 150px;" value="Search Now">
            </div>
        </div>
    </form>

    <!-- <button class="btnTest">Test</button> -->

    <ul class="search-result">
        <?php foreach ($mangaList as $manga) :
            $latestChapter = Chapter::getLatestChapter($manga->getId());
        ?>

            <li class="manga-item">
                <div style="display: flex;">
                    <a href="comicpage.php?id=<?php echo $manga->getId() ?>" target="_blank">
                        <img class="manga-cover" style="flex: 30%;" src="<?php echo $manga->getCoverImage() ?>">
                    </a>

                    <div class="manga-info" style="flex: 70%;">
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

</body>

<script>
    $(".genre-tagbox a").click(function() {
        var tagBox = $(this);
        if (tagBox.hasClass("ticked")) {
            tagBox.removeClass("ticked");
        } else {
            tagBox.addClass("ticked");
        }
    });

    $("#btnSearch").click(function() {
        // Getting genres selected by user
        var selectedGenres = [];
        $(".ticked").each(function() {
            selectedGenres.push($(this).attr("data-val"));
        });

        console.log(selectedGenres);

        // Append genre query parameters into form
        // it works like this ... &genre=Romance&genre=School+Life&genre=Shoujo&genre=Shounen
        selectedGenres.forEach(function(item) {
            var input = $("<input>")
               .attr("type", "hidden")
               .attr("name", "genre[]").val(item.trim());
            $("#manga-form").append(input);
        });

        // Submit the form
        $("#manga-form").submit();
    });

    $("#rating-preferred-options").change(function() {
        var option = $(this).val();
        if (option == "any-star") {
            $("#rating-preferred-value").css("display", "none");
        } else {
            $("#rating-preferred-value").css("display", "inline-block");
        }
    })
</script>