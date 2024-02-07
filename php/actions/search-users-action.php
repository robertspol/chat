<?php
require_once "../classes/SearchUsers.php";

$searchUsers = new SearchUsers();
$searchUsers->searchUsers($_POST["search_value"]);
