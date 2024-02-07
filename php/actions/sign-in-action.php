<?php
require_once "../classes/SignInBackend.php";

if (isset($_POST["email"])) {
    $signIn = new SignInBackend();
    $signIn->signIn($_POST);
} else {
    header("Location: ../sign-in.php");
}
