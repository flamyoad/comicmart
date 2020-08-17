<?php
session_start();
?>

<head>
    <link rel="stylesheet" href="content/fontawesome-free-5.12.1-web/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap-4.4.1-dist/css/bootstrap.min.css">
    <script src="css/bootstrap-4.4.1-dist/css/bootstrap.min.js"></script>
    <script src="scripts/jquery-3.4.1.js"></script>


    <style>
        .title {
            text-align: center;
            font-size: 30px;
        }

        .left-image {
            display: block;
            margin: 0 auto;
            padding-bottom: 8dp;
        }

        .submit-btn {
            margin-top: 16px;
        }
    </style>

</head>

<?php
require "header.php"
?>

<div class="container" style="margin-top: 30px;">

    <h1 class="title">
        Create a new account
    </h1>

    <div class="row" style="margin-top: 32px;">
        <div class="col-sm-5 float-left">
            <img class="left-image" src="img/usa.png" />
        </div>

        <div class="col-sm-5 float-right">
            <form action="SignupHandle.php" method="POST">

                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Enter Email" name="email" required />
                </div>
                
                <div>
                    <input class="form-control" style="width: 200px; display:inline-block;" type="password" id="password" name="password" placeholder="Enter Password" required />
                    <input class="form-control" style="width: 200px; display:inline-block;" type="password" id="confirm-password" name="confirm-password" placeholder="Confirm Password" required />
                    <p style="display:inline-block">
                        <i id="password-toggle-icon" class="fas fa-eye-slash" style="height:18px; margin:8px;"></i>
                    </p>
                </div>

                <input type="text" class="form-control" name="displayName" placeholder="Enter username" required />

                <?php if(isset($_SESSION['register_error'])): ?>

                    <small class="text-danger">
                        <?php echo $_SESSION['register_error'] ?>
                        <?php unset($_SESSION['register_error']); ?>
                    </small> 
                    
                    <br>

                <?php endif; ?>

                <input type="submit" class="btn btn-primary submit-btn" value="Sign Up" />

                <div style="margin-top: 8px">
                    <span>Already have an account? </span>
                    <span><a href>Login here</a></span>
                </div>
            </form>
        </div>

    </div>

</div>

<script>
    $('#password-toggle-icon').click(function() {

        /* Notice the empty space between 'fa-eye' and 'fa-eye-slash' in the method argument
           One or more class names (separated by spaces) to be toggled for each element in the matched set. 
        */
        $(this).toggleClass('fa-eye fa-eye-slash');

        var passwordField = document.getElementById('password');
        var confirmPasswordField = document.getElementById('confirm-password');

        // Toggle the visibility of password fields
        if (passwordField.type === "password" && confirmPasswordField.type === "password") {
            passwordField.type = "text";
            confirmPasswordField.type = "text";
        } else {
            passwordField.type = "password";
            confirmPasswordField.type = "password";
        }

    });
</script>