<?php
require_once "../classes/CreateDbTables.php";
require_once "../classes/SignUpBackend.php";

$createUsersTable = new CreateDbTables();
$createUsersTable->createUsersTable();

$createMessageTable = new CreateDbTables();
$createMessageTable->createMessagesTable();

$signUp = new SignUpBackend();
$signUp->signUp($_POST, $_FILES);
