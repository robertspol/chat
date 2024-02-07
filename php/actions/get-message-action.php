<?php
session_start();
require_once "../classes/Messages.php";

$jsonData = file_get_contents("php://input");

if (!empty($jsonData)) {
    $data = json_decode($jsonData);

    $messages = new Messages($data->outgoing_id, $data->incoming_id);
    $messages->getMessage();
} else {
    header("Location: ../../index.php");
}
