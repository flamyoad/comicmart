<link rel="stylesheet" href="css/bootstrap-4.4.1-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="css/image-uploader.css">
<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<script src="scripts/jquery-3.4.1.js"></script>
<script src="css/bootstrap-4.4.1-dist/js/bootstrap.min.js"></script>
<script src="scripts/image-uploader.js"></script>

<style>
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
    <div class="container">
        <form enctype="multipart/form-data">
            <div class="tab">
                <div class="flexcol">

                    <div class="flexcol" style="justify-content: center; align-items: center;">
                        <img id="coverPreview" alt="Your cover image" />
                        <input style="width: 150px;" type="file" onchange="readImage(this)" accept="image/png, image/jpeg" />
                    </div>

                    <div class="form-group  flexcol">
                        <input class="form-control" type="text" placeholder="Your Title" style="margin-top: 20px;">
                        <textarea class="form-control" placeholder="Your Summary" rows="7" style="margin-top: 20px;"></textarea>
                    </div>
                </div>
            </div>

            <div class="tab">
                <input class="form-control" type="text" placeholder="Chapter Title">
                <div class="input-images"></div>
            </div>


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
</body>

<script>
    $('.input-images').imageUploader();

    var currentTab = 0;
    showTab(currentTab);

    $("#prevBtn").click(function() {
        if (currentTab > 0) {
            currentTab--;
            showTab(currentTab);
        }
    });

    $("#nextBtn").click(function() {
        var numberOfTabs = $(".step").length;
        if (currentTab < numberOfTabs - 1) {
            currentTab++;
            showTab(currentTab);
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
        if (index == (tabs.length - 1)) {
            $("#nextBtn").html("Submit");
        } else {
            $("#nextBtn").html("Next");
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