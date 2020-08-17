<?php
require_once 'models/User.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $loginSuccessful = User::verifyLogin($email, $password);

    if ($loginSuccessful) {

        $_SESSION['loggedIn'] = true;

        // Put user details inside the $_SESSION array
        $_SESSION['email'] = $email;

        // Retrieve other details from database
        $user = User::getByEmail($email);
        $_SESSION['user_id'] = $user->getId();
        $_SESSION['displayName'] = $user->getDisplayName();
        $_SESSION['topup_balance'] = $user->getTopupBalance();
        $_SESSION['gender'] = $user->getGender();

        // Jump to home page
        header("Location: homepage.php");
    } else {
        header("Location: homepage.php");

        $login_error_script = '
            $("#myModal").css("display", "block");
            $("#login-error-text").show();
';

        $_SESSION['loginError'] = $login_error_script;

    }
}




