<?php
require_once "../classes/DisplayUsers.php";

if (isset($_SESSION["unique_id"])) {
    $displayUsers = new DisplayUsers();
    $displayUsers->displayUsers();
} else {
    header("Location: ../../index.php");
}
