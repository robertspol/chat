<?php
session_start();
require_once "ConnectDb.php";

class DisplayUsers extends ConnectDb
{
    public function __construct()
    {
        parent::__construct();
    }

    public function displayUsers()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE NOT unique_id = :unique_id");
        $stmt->bindParam(":unique_id", $_SESSION["unique_id"]);
        $stmt->execute();

        $output = "";

        if ($stmt->rowCount() === 0) {
            $output = "Brak innych użytkowników";
        } else {
            include "../users-data.php";
        }

        echo $output;
    }
}
