<?php
    require_once "models/User.php";
    session_start();

    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        return;
    }

    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];
    $username = $_POST['displayName'];
    
    // If email is invalid..
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['register_error'] = "Invalid email address";
        header("Location: signup.php");
        return;
    }

    // If password and confirm password are different...
    if ($password != $confirm_password) {
        $_SESSION['register_error'] =  "Password and confirm password are different";
        header("Location: signup.php");
        return;
    }

    // If password is too short...
    if (strlen($password) < 8) {
        $_SESSION['register_error'] =  "Password must be longer than 8 characters";
        header("Location: signup.php");
        return;
    }

    // If email is already registered...
    if (User::isEmailUsed($email)) {
        $_SESSION['register_error'] =  "This email is already registered";
        header("Location: signup.php");
        return;
    }

    // Use string 'NULL' 
    // Do not use the magic constant NULL for SQL, it will show as empty string in the SQL statement 
    $user = new User('NULL', $email, $password, $username, 'X', '0');
    $user->insert();

    header("Location: homepage.php");
?>