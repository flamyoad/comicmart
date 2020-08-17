<?php
session_start();
?>

<link rel="stylesheet" href="css/bootstrap-4.4.1-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="css/image-uploader.css">
<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<script src="scripts/jquery-3.4.1.js"></script>
<script src="css/bootstrap-4.4.1-dist/js/bootstrap.min.js"></script>
<script src="scripts/image-uploader.js"></script>

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

    ul {
        list-style: none;
    }

    /* Hide all steps by default: */
    .tab {
        display: none;
    }

    /* Make circles that indicate the steps of the form: */
    .step {
        height: 15px;
        width: 15px;
        margin: 0 2px;
        background-color: red;
        border: none;
        border-radius: 50%;
        display: inline-block;
        opacity: 0.5;
    }

    /* Mark the active step: */
    .active {
        opacity: 1;
    }

    .flexrow {
        display: flex;
        flex-direction: row;
    }

    .flexcol {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    #coverPreview {
        height: 170px;
        width: 150px;
        object-fit: cover;
    }
</style>

<body>
    <?php
    require_once "header.php";
    require_once "models/Genre.php";
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
                    <a href="javascript:void(0)">
                        <i class="fa fa-book nav-icons" aria-hidden="true"></i>
                        <span>Library</span>
                    </a>
                </li>

                <li>
                    <a href="javascript:void(0)">
                        <i class="fa fa-credit-card nav-icons" aria-hidden="true"></i>
                        <span>Wallet</span>
                    </a>
                </li>

                <li>
                    <a href="account-settings-upload.php">
                        <i class="fa fa-upload nav-icons" aria-hidden="true"></i>
                        <span>Upload Works</span>
                    </a>
                </li>

            </ul>
        </nav>

        <div>
            <p class="content-title">Upload New Works</p>
            <div class="content">

                <div>
                    <form id="uploadForm" method="POST" action="UploadMangaHandle.php" enctype="multipart/form-data">
                        <!-- First tab -->
                        <div class="tab">
                            <div class="flexcol">

                                <div class="flexcol" style="justify-content: center; align-items: center;">
                                    <img id="coverPreview" alt="Your cover image" />
                                    <input name="coverImage" style="width: 150px;" type="file" onchange="readImage(this)" accept="image/png, image/jpeg" />
                                </div>

                                <div class="form-group  flexcol" style="margin-bottom: 16px;">
                                    <input id="authorName" name="authorName" class="form-control" type="text" placeholder="Author's Name" style="margin-top: 20px;">
                                    <input id="mangaTitle" name="mangaTitle" class="form-control" type="text" placeholder="Your Title" style="margin-top: 20px;">
                                    <textarea id="mangaSummary" name="mangaSummary" class="form-control" placeholder="Your Summary" rows="7" style="margin-top: 20px;"></textarea>
                                </div>

                                <h5 style="margin-top: 10px;">Genres</h5>

                                <div class="form-group">
                                    <?php foreach (Genre::getAll() as $genre) : ?>
                                        <div class="custom-control custom-checkbox" style="display: inline-block; width: 49%;">
                                            <input type="checkbox" class="custom-control-input" name="genres[]" value=<?php echo $genre->getId(); ?> id=<?php echo $genre->getId(); ?>>
                                            <label class="custom-control-label" for="<?php echo $genre->getId(); ?>">
                                                <?php echo $genre->getName(); ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <!--Second tab -->
                        <div class="tab" style="margin-bottom: 16px;">
                            <input id="chapterTitle" name="chapterTitle" class="form-control" type="text" placeholder="Chapter Title">
                            <div class="input-images"></div>
                        </div>


                        <!--Next and previous buttons -->
                        <div style="overflow:auto;">
                            <div style="float:right;">
                                <button class="btn btn-light" type="button" id="prevBtn">Previous</button>
                                <button class="btn btn-dark" type="button" id="nextBtn">Next</button>
                            </div>
                        </div>

                        <!-- Circles which indicates the steps of the form: -->
                        <div style="text-align:center;margin-top:40px;">
                            <span class="step"></span>
                            <span class="step"></span>
                        </div>

                    </form>

                </div>

            </div>
        </div>

    </div>

</body>

<script>
    $(".input-images").imageUploader();
    var currentTab = 0;
    showTab(currentTab);

    $("#prevBtn").click(function() {
        if (currentTab > 0) {
            currentTab--;
            showTab(currentTab);

            // Scroll the page to the top left instantly
            window.scrollTo(0, 0);
        }
    });

    $("#nextBtn").click(function() {
        var numberOfTabs = $(".step").length;
        if (currentTab < numberOfTabs - 1) {
            currentTab++;
            showTab(currentTab);

            // Scroll the page to the top left instantly
            window.scrollTo(0, 0);
        } else {
            var authorName = $("#authorName").val();
            var mangaTitle = $("#mangaTitle").val();
            var mangaSummary = $("#mangaSummary").val();
            var chapterTitle = $("#chapterTitle").val();

            // not working
            // var coverPhoto = $("coverPreview").files.length;

            if (!authorName || !mangaTitle || !mangaSummary || !chapterTitle) {
                alert("Please fill in all fields!");
                return;

            } else {
                $("#uploadForm").submit();
            }

        }
    });

    function showTab(index) {
        var tabs = $(".tab");

        // Show the tab indicated by index argument and hide other tabs
        for (i = 0; i < tabs.length; i++) {
            if (i == index) {
                // //eq() method instead of get(), which returns a jquery object instead of original HTMLElement.       
                tabs.eq(i).show();
            } else {
                tabs.eq(i).hide();
            }
        }

        // Hide the "Previous" button on first tab
        if (index == 0) {
            $("#prevBtn").hide();
        } else {
            $("#prevBtn").show();
        }

        // Change the "Next" button to "Submit" on last tab
        if (index == tabs.length - 1) {
            $("#nextBtn").html("Submit");

        } else {
            $("#nextBtn").html("Next")
        }

        // ... and run a function that displays the correct step indicator:
        fixStepIndicator(index)
    }

    function fixStepIndicator(currentIndex) {

        $(".step").each(function(i, value) {
            if (i == currentIndex) {
                $(this).addClass("active");
            } else {
                $(this).removeClass("active");
            }
        });
    }

    function readImage(input) {
        if (input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $("#coverPreview").attr("src", e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>