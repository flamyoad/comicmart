<?php
session_start();
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


    .upload-btn {
        color: white;
        margin: auto 0;
        margin-left: 20px;
    }

    .gender-radiogroup input {
        margin-left: 10px;
    }
</style>

<html>

<body>
    <?php
    require "header.php";
    require_once "models/User.php";

    $userId = $_SESSION['user_id'];
    $user = User::getById($userId);
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
                        <i class=" fa fa-credit-card nav-icons" aria-hidden="true"></i>
                        <span>Wallet</span>
                    </a>
                </li>

                <li>
                    <a href="account-settings-upload.php">
                        <i class="fa fa-upload nav-icons" aria-hidden="true"></i>
                        <span>Uploaded Works</span>
                    </a>
                </li>

                <li>
                    <a href="account-settings-earnings.php">
                        <i class="fa fa-dollar nav-icons" aria-hidden="true"></i>
                        <span>Earnings</span>
                    </a>
                </li>

            </ul>
        </nav>

        <div>
            <p class="content-title">My Profile</p>
            <div class="content">
                <div class="row">
                    <img src="img/default_avatar.png" width="70px" height="70px" style="margin-top: auto 0;">
                    <button class="btn btn-primary upload-btn">Upload a photo</button>
                </div>

                <div class="row">
                    <p>Email Address</p>
                    <input class="form-control" type="text" value="yizake1820@gmail.com" disabled>
                </div>

                <form method="POST" action="EditUserNameHandle.php">
                    <div class="form-group">
                        <div class="row">
                            <p>Display Name</p>
                            <input class="form-control" type="text" name="name" required
                            value="<?php echo $user->getDisplayName() ?>">
                        </div>

                        <div class="row">
                            <p>Introduction</p>
                            <textarea class="md-textarea form-control" type="text"></textarea>
                        </div>

                        <div class="row">
                            <p style="margin: 0 20px 0 0">Gender</p>

                            <div class="gender-radiogroup">
                                <input type="radio" id="male" name="gender" value="male">
                                <label for="male">Male</label>

                                <input type="radio" id="female" name="gender" value="female">
                                <label for="female">Female</label>

                                <input type="radio" id="unspecified" name="gender" value="unspecified">
                                <label for="unspecified">Unspecified</label>
                            </div>
                        </div>

                        <div class="row">
                            <input class="btn btn-primary" type="submit" value="Save Changes" />
                        </div>

                    </div>

                </form>
            </div>
        </div>

    </div>


</body>
<html>

<script>

</script>