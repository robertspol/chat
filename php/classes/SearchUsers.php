<?php
session_start();
require_once "ConnectDb.php";

class SearchUsers extends ConnectDb
{
    public function __construct()
    {
        parent::__construct();
    }

    public function searchUsers($searchValue)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE NOT unique_id = :unique_id AND (REPLACE(LOWER(CONCAT(first_name, ' ', last_name)), ' ', '') LIKE REPLACE(LOWER(:search_value), ' ', ''))");

        $searchValueWithWildcards = "%" . $searchValue . "%";

        $stmt->bindParam(":unique_id", $_SESSION["unique_id"]);
        $stmt->bindParam(":search_value", $searchValueWithWildcards);

        $stmt->execute();

        $output = "";

        if ($stmt->rowCount() > 0) {
            include "../users-data.php";
        } else {
            $output .= "<p>Nie ma takiego użytkownika</p>";
        }

        echo $output;
    }
}
