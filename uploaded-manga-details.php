<link rel="stylesheet" href="css/bootstrap-4.4.1-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="css/image-uploader.css">
<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="css/jquery-confirm-v3.3.4/css/jquery-confirm.css">
<script src="scripts/jquery-3.4.1.js"></script>
<script src="css/bootstrap-4.4.1-dist/js/bootstrap.bundle.min.js"></script>
<script src="scripts/image-uploader.js"></script>
<script src="css/jquery-confirm-v3.3.4/js/jquery-confirm.js"></script>


<?php
require_once "models/Manga.php";
require_once "models/Chapter.php";
$mangaId = $_GET["id"];

$manga = Manga::getById($mangaId);
$chapterList = Chapter::getAllChapters($mangaId);
?>

<head>
    <style>
        .tab {
            margin-bottom: 5px;
            background-color: #37474F;
            box-shadow: 0 0 5px #444;
        }

        .tab-btn {
            border: none;
            background-color: #37474F;
            font-size: 16pt;
            color: gray;
            margin: 14px 30px;
            font-weight: bold;
        }

        .tab-btn:focus {
            outline: none;
        }

        .active {
            border: none;
            color: white;
            font-size: 16pt;
        }

        .tab-content {
            padding: 16px;
        }

        .cover-image {
            display: block;
            margin: 0 auto;
            border-radius: 10px;
            box-shadow: 0 0 2px #444;
        }

        #chapter-list table {
            width: 100%;
            border: 1px solid black;
            border-collapse: collapse;
            margin-top: 24px;
        }

        #chapter-list td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        .submitBtn {
            display: block;
            margin: 0 auto;
        }

        p[contenteditable="true"] {
            border: 2px solid skyblue;
        }
    </style>
</head>

<body>
    <div class="tab">
        <button class="tab-btn active" onclick="openTab(this, '#chapter-list')">Chapter List</button>
        <button class="tab-btn" onclick="openTab(this, '#upload-chapters')">Upload New Chapter</button>
    </div>

    <div class="tab-content" id="chapter-list">

        <img class="cover-image" src="<?php echo $manga->getCoverImage() ?>" width="200">

        <table>
            <tr>
                <th>Chapter Name</th>
                <th>Pages</th>
                <th>Date Uploaded</th>
                <th>Price</th>
            </tr>

            <?php foreach ($chapterList as $chapter) : ?>
                <tr id="<?php echo $chapter->getId() ?>">

                    <td>
                        <div>
                            <p class="chapter-list-title" style="display: inline;">
                                <?php echo $chapter->getTitle() ?>
                            </p>
                            <img class="delete-chapter-button" onclick="deleteRow(this)" style="float: right;" src="icons/trash.svg" width="30" height="20" data-toggle="tooltip" data-placement="top" title="Delete Chapter">
                            <img class="title-edit-button" style="float: right;" src="icons/pencil.svg" width="30" height="20" data-toggle="tooltip" data-placement="top" title="Edit Title">
                        </div>
                    </td>

                    <td style="color:grey;">
                        <div>
                            <p style="display: inline;"> <?php echo $chapter->getTotalPageNumber() ?></p>
                        </div>
                    </td>

                    <td style="color:grey;"> <?php echo $chapter->getDateUploaded() ?> </td>

                    <td style="color:grey;">
                        <div>
                            <p class="chapter-list-price" style="display: inline;"> <?php echo $chapter->getPrice() ?> </p>
                            <img class="title-edit-price" style="float: right;" src="icons/euro.svg" width="30" height="25">
                        </div>
                    </td>

                </tr>
            <?php endforeach ?>

        </table>
    </div>

    <div class="tab-content" id="upload-chapters" style="display:none;">
        <form id="uploadForm" method="POST" action="UploadChapterHandle.php" enctype="multipart/form-data">
            <input name="chapterTitle" class="form-control" type="text" placeholder="Chapter Title">
            <input name="mangaId" type="hidden" value=<?php echo $mangaId ?>>
            <div class="input-images"></div>
            <input class="submitBtn" type="submit" value="Upload Chapter">
        </form>
    </div>
</body>

<script>
    // Initialize image uploader library
    $(".input-images").imageUploader();

    /* Initialize Bootstrap's tooltip. 
       Tooltips are opt-in for performance reasons, so you must initialize them yourself. 
    */
    $('[data-toggle="tooltip"]').tooltip()


    function openTab(buttonObject, tabName) {
        // Get all tabs and hide them
        $(".tab-content").each(function() {
            $(this).css("display", "none");
        });

        // Get all tab buttons and remove the class "active"
        $(".tab-btn").each(function() {
            $(this).removeClass("active");
        });

        // Show the current tab, and add an "active" class to the button that opened the tab
        $(tabName).css("display", "block");
        $(buttonObject).addClass("active");
    }

    // Toggles edit button icon from "Start Editing" to "Finish Editing"
    $(".title-edit-button").click(function(event) {
        var chapterTitle = $(this).parent().find(".chapter-list-title");

        // The user has finished editing. Change attr "contenteditable" to false
        if ($(this).hasClass("isBeingEdited")) {

            // If the input consists of empty string, tell user to give a correct input
            if (chapterTitle.text().trim().length == 0) {
                chapterTitle.tooltip({
                    title: "Empty text is not allowed!",
                    placement: "top",
                    trigger: "manual",
                    delay: {
                        show: 0,
                        hide: 3000
                    }
                });

                // Show the tooltip
                chapterTitle.tooltip("show");

                // Hide the tooltip after 2 second
                setTimeout(function() {
                    chapterTitle.tooltip("hide");
                }, 1000);
                return;
            }

            editChapterTitle(this);

            event.preventDefault();

            // The user has started editing. Change attr "contenteditable" to true
        } else {
            $(this).addClass("isBeingEdited");
            $(this).attr("src", "icons/tick.svg")
            chapterTitle.attr("contenteditable", "true");
        }
    });

    function editChapterTitle(thisObject) {
        var chapterId = $(thisObject).closest("tr").attr("id");
        var chapterTitle = $(thisObject).parent().find(".chapter-list-title");
        var newTitle = chapterTitle.text().trim();

        console.log(newTitle);

        chapterTitle.attr("contenteditable", "false");
        $(thisObject).attr("src", "icons/loading-spinner.svg")

        $.ajax({
            url: "EditChapterNameHandle.php",
            type: "POST",
            data: {
                chapterId: chapterId,
                newTitle: newTitle
            }
        }).done(function() {


        }).fail(function() {
            // toast "failed"

        }).always(function() {
            // Make the textfield non-editable 
            $(thisObject).removeClass("isBeingEdited");
            $(thisObject).attr("src", "icons/pencil.svg")
            chapterTitle.attr("contenteditable", "true");
        });
    }

    $(".title-edit-price").click(function(event) {
        var chapterPrice = $(this).parent().find(".chapter-list-price");
        var chapterId = $(this).closest("tr").attr("id");

        // The user has finished editing. Change attr "contenteditable" to false
        if ($(this).hasClass("isBeingEdited")) {

            var currency = formatCurrency(chapterPrice.text());

            var invalidCurrency = Number.isNaN(currency);

            if (invalidCurrency) {
                chapterPrice.tooltip({
                    title: "Invalid currency",
                    placement: "top",
                    trigger: "manual",
                    delay: {
                        show: 0,
                        hide: 3000
                    }
                });

                // Show the tooltip
                chapterPrice.tooltip("show");

                // Hide the tooltip after 2 second
                setTimeout(function() {
                    chapterPrice.tooltip("hide");
                }, 1000);
                return;
            }

            editChapterPrice(this, currency);

            // Prevent clicking more than once before finishing the SQL query
            event.preventDefault();

            // The user has started editing. Change attr "contenteditable" to true
        } else {
            $(this).addClass("isBeingEdited");
            $(this).attr("src", "icons/tick.svg")
            chapterPrice.attr("contenteditable", "true");
        }
    });

    function editChapterPrice(thisObject, newPrice) {
        var chapterPrice = $(thisObject).parent().find(".chapter-list-price");
        var chapterId = $(thisObject).closest("tr").attr("id");

        chapterPrice.attr("contenteditable", "false");
        $(thisObject).attr("src", "icons/loading-spinner.svg")

        $.ajax({
            url: "EditChapterPriceHandle.php",
            type: "POST",
            data: {
                chapterId: chapterId,
                newPrice: newPrice
            }
        }).done(function() {
            // no need to do anything :)

        }).fail(function() {
            // toast "failed"

        }).always(function() {
            // Make the textfield non-editable 
            $(thisObject).removeClass("isBeingEdited");
            $(thisObject).attr("src", "icons/euro.svg")
            chapterPrice.attr("contenteditable", "true");
        });
    }

    function formatCurrency(input) {
        var trimmedInput = input.trim();
        var roundedUpValue = Number(Math.round(trimmedInput + 'e2') + 'e-2');
        return roundedUpValue;
    }


    function deleteRow(thisObject) {
        var chapterId = $(thisObject).closest("tr").attr("id");
        var chapterName = $(thisObject).parent().find(".chapter-list-title").text().trim();

        // Open a dialog box to ask for confirmation 
        $.confirm({
            title: "",
            content: "Confirm deletion of chapter <i>" + chapterName + "<i> ?",
            backgroundDismiss: true,
            buttons: {
                confirm: function() {
                    // Replaces the "$.confirm" dialog box with spinning indicator to show the process is being run
                    var dialog = $.confirm({
                        animation: "none",
                        content: function() {
                            var self = this;
                            return $.ajax({
                                url: "DeleteChapterHandle.php",
                                type: "POST",
                                data: {
                                    id: chapterId
                                }

                            }).done(function(response) {
                                // Remove row from the table
                                $("#" + chapterId).remove();
                                dialog.close();

                            }).fail(function(response) {
                                self.title = "Error deleting the chapter";
                            })
                        }
                    })
                },

                cancel: function() {
                    // Close the dialog by doing nothing
                }
            }
        });
    }
</script>