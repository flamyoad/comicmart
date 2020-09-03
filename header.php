<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/bootstrap-4.4.1-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="css/bttn.min.css">

<style>
    /* .header-container {
        background-color: gray;
    } */

    .nav-options {
        display: flex;
        flex-direction: row;
        margin: auto 0;
        /* for centering the div vertically */
        margin-right: 16px;
        /* prevent div from getting too close to neighbour div */
    }

    .nav-options li {
        font-size: 18px;
        display: inline-block;
        margin-right: 26px;
    }

    .nav-options a {
        text-decoration: none;
        color: black;
        font-weight: 620;
    }

    .nav-options a:hover {
        color: red;
    }

    .nav-options a:active {
        color: red;
    }

    .menu-item-container {
        width: 100%;
        display: flex;
        flex-direction: row;
        overflow: visible;
        padding-left: 75px;
        padding-right: 75px;
    }

    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 2;
        /* Sit on top */
        padding-top: 100px;
        /* Location of the box */
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

    /* Modal Content */
    .modal-content {
        position: relative;
        background-color: #fefefe;
        margin: 0 auto;
        padding: 10px;
        border: 1px solid #888;
        max-width: 400px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }

    .close-button {
        cursor: pointer;
        margin-left: auto;
        margin-right: 16px;
        margin-top: 8px;
        float: right;
    }

    .modal-title {
        margin-top: 6px;
        margin-left: 8px;
        float: left;
        color: gray;
        font-weight: bold;
        font-size: 24px;
    }

    .search-container {
        margin-left: 16px;
    }

    .search-container button {
        margin-left: 0px;
        height: max-content;
    }

    .search-container input[type=text] {
        padding: 6px;
        margin-top: 8px;
        font-size: 17px;
    }

    #login-dialog {
        display: flex;
        flex-direction: column;
    }

    /* #login-dialog .items {
        margin-top: 16px;
        margin-right: 32px;
        margin-left: 32px;
    } */

    .search-banner {
        background-image: url('img/kimetsu.jpg');
        opacity: 0.9;
        background-repeat: no-repeat;
        background-position: right;
        height: 120px;
        display: flex;
        margin-top: 8px;
        justify-content: center;
    }

    #search-bar {
        width: 400px;
        height: 50px;
        overflow: hidden;
        margin: auto;
        border: none;
        outline: none;
        text-align: center;
        background-image: url('icons/search.png');
        background-repeat: no-repeat;
        padding-left: 48px;
        padding-right: 26px;
        background-position: 16px;
    }

    .search-banner-container {
        display: flex;
        flex-direction: row;
        padding-top: 10px;
    }

    #search-btn {
        height: 50px;
        width: 130px;
        margin: auto;
        border: none;
        outline: none;
        cursor: pointer;
        background-color: red;
        color: white;
    }

    #search-btn:hover {
        background-color: #ff1919;
    }

    /* https://stackoverflow.com/questions/22599675/positioning-a-div-below-its-parent-position-absolute-bottom-0-not-working */
    /* Basically I need to make a circle look like it's hanging from a string. I used the basic CSS of:
    #string {
        position: relative;
    }

    #circle {
        position: absolute;
        bottom: 0;
    } */

    .avatar-container {
        margin-left: auto;
        cursor: pointer;
        position: relative;
        display: flex;
        flex-direction: row;
    }

    .avatar-container:hover .hover-container {
        display: block;
    }

    .hover-container {
        display: none;
        position: absolute;
        border: 1px solid #ededed;
        border-radius: 4px;
        box-shadow: 0 0 2px 0 rgba(0, 0, 0, 0.1);
        width: 250px;
        height: auto;
        top: 100%;
        right: 20%;
        padding: 20px;
        background-color: rgb(255, 255, 255);
        z-index: 2;
        cursor: auto;
    }

    .primary-text {
        color: black;
        font-size: 18px;
    }

    .secondary-text {
        color: #C0C0C0;
        font-size: 14px;
        /* light gray */
    }

    .profile-picture {
        float: left;
    }

    .right {
        float: right;
    }

    .vertical-center {
        display: inline-flex;
        align-items: center;
        margin-left: 6px;
    }
</style>

<?php
require_once "models/User.php";
?>

<div class="header-container">

    <div class="menu-item-container">
        <a href="homepage.php"">
                <img src=" img/logo.png" width="auto" height="50px">
        </a>

        <ul class="nav-options">
            <li>
                <a href="homepage.php">Home</a>
            </li>

            <li>
                <a href="popular.php">Popular</a>
            </li>

        </ul>

        <div class="avatar-container">
            <img id="btnLogin" src="img/default_avatar.png" width="35px" height="35px" style="margin-top: 8px;">

            <?php
            // If user has logged in, print his/her email and the logout button in the HTML.
            if (isset($_SESSION['email'])) {
                $userEmail = $_SESSION['email'];
                echo "<span class='vertical-center'>$userEmail</span>";
            }
            ?>

            <!-- Only show the <div> of dialog if user is logged in... -->
            <?php if (isset($_SESSION['loggedIn'])) :
                $user = User::getById($_SESSION['user_id']);
            ?>

                <div class="hover-container">
                    <p class="primary-text">
                        <?= $user->getDisplayName() ?>
                    </p>

                    <p class="secondary-text">
                        <?= $user->getEmail() ?>
                    </p>

                    <hr>

                    <p>
                        My Balance:
                        <span class="right"">
                            <?php echo $user->getTopupBalance(); ?>
                        </span>
                    </p>

                        <form action="topup.php" target="_blank">
                            <button type="submit" class="bttn-jelly bttn-sm bttn-warning" style="width: 100%;">
                                Top Up
                            </button>
                        </form>

                            <a href="account-settings.php" target="_blank">Account Settings
                                <a href="logout.php" class="right">Logout</a>
                            </a>
                </div>

            <?php endif; ?>

        </div>

    </div>

    <div class="search-banner">

        <form class="search-banner-container" method="GET" action="search.php">
            <input id="search-bar" name="title" type="text" placeholder="Name of the Manga, Artist" autocomplete="off"
            value="<?php
                if (isset($_GET['title'])) {
                    echo $_GET['title'];
                }
             ?>">
            <button id="search-btn">Search</button>
        </form>

    </div>

</div>

<div class="modal" id="myModal">
    <form class="modal-content" method="POST" action="LoginHandle.php">

        <!-- <span class="close">Comic Mart</span>
            <div class="close form-group">
                <img id="btnClose" src="icons/close-button.png" width="30px" height="30px" />
            </div> -->
        <div>
            <span class="modal-title">Login</span>
            <div class="close-button form-group" style="display:inline-block">
                <img id="btnClose" src="icons/close-button.png" width="30px" height="30px" />
            </div>
        </div>

        <div class="form-group">
            <input type="email" class="form-control" name="email" placeholder="Enter Email" required>
        </div>

        <div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="Password" required>
        </div>

        <small class="text-danger" id="login-error-text" style="margin-bottom: 8px; display:none;">
            Email/Password are incorrect
        </small>

        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="rememberMe"></input>
            <label class="form-check-label" for="rememberMe">Remember Me</label>
        </div>

        <button type="submit" class="btn btn-danger" style="margin: 8px 0px;">Login</button>

        <div class="form-group">
            <span>
                <a href="signup.php">Sign Up</a>
            </span>

            <span> | </span>

            <span>
                <a href="">Forgot Password</a>
            </span>
        </div>

    </form>

</div>

<script>
    var btnLogin = document.getElementById("btnLogin");

    btnLogin.onclick = function() {
        modal.style.display = "block";
    }

    var modal = document.getElementById("myModal");

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    var btnClose = document.getElementById("btnClose");
    btnClose.onclick = function() {
        modal.style.display = "none";
    }
</script>