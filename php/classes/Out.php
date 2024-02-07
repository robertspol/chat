<?php
require_once "ConnectDb.php";
session_start();
ini_set("display_errors", 0);

class Out extends ConnectDb
{
    private $uniqueID;

    public function __construct()
    {
        parent::__construct();
        $this->uniqueID = $_SESSION["unique_id"];
    }

    public function signOut()
    {
        try {
            $status = "Nieaktywny";

            $stmt = $this->pdo->prepare("UPDATE users SET status=:status WHERE unique_id=:unique_id");

            $stmt->bindParam("status", $status);
            $stmt->bindParam("unique_id", $this->uniqueID);

            $stmt->execute();

            unset($_SESSION["unique_id"]);
            header("Location: ../sign-in.php");
        } catch (PDOException $e) {
            echo "Błąd: " . $e->getMessage();
        }
    }

    public function unregister()
    {
        try {
            $stmt1 = $this->pdo->prepare("SELECT img FROM users WHERE unique_id = :unique_id");
            $stmt1->bindParam(":unique_id", $this->uniqueID);
            $stmt1->execute();

            if ($stmt1->rowCount() > 0) {
                $row = $stmt1->fetch(PDO::FETCH_ASSOC);

                if (file_exists("../../img/{$row['img']}")) {
                    unlink("../../img/{$row['img']}");
                }
            }

            $stmt2 = $this->pdo->prepare("DELETE FROM users WHERE unique_id = :unique_id");
            $stmt2->bindParam(":unique_id", $this->uniqueID);
            $stmt2->execute();

            $stmt3 = $this->pdo->prepare("DELETE FROM messages WHERE outgoing_id = :unique_id1 OR incoming_id = :unique_id2");

            $stmt3->bindParam(":unique_id1", $this->uniqueID);
            $stmt3->bindParam(":unique_id2", $this->uniqueID);

            $stmt3->execute();

            session_unset();
            session_destroy();

            header("Location: ../../index.php");
        } catch (PDOException $e) {
            echo "Błąd: " . $e->getMessage();
        }
    }
}
