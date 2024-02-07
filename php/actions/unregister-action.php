<?php
session_start();
require_once "../classes/Out.php";

if (isset($_SESSION["unique_id"])) {
    $out = new Out();
    $out->unregister();
} else {
    header("Location: ../../index.php");
}
