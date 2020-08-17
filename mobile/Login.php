<?php

require_once "../models/USer.php";

$email = $_POST['email'];
$password = $_POST['password'];

$loginSuccessful = User::verifyLogin($email, $password);

if ($loginSuccessful) {
    // Retrieve other details from database
    $user = User::getByEmail($email);
    echo json_encode($user);

} else {
    $fail = new User("-1", "", "", "", "", "", "");
    echo json_encode($fail);
}
