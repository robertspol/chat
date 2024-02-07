<?php
require_once "ConnectDb.php";
session_start();
ini_set("display_errors", 0);

class SignInBackend extends ConnectDb
{
    public function __construct()
    {
        parent::__construct();
    }

    public function signIn($formData)
    {
        $email = $formData["email"];
        $password = $formData["password"];

        try {
            $stmt1 = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt1->bindParam(":email", $email);
            $stmt1->execute();

            if ($stmt1->rowCount() > 0) {
                $row = $stmt1->fetch(PDO::FETCH_ASSOC);

                if (password_verify($password, $row["password"])) {
                    try {
                        $status = "Aktywny";

                        $stmt2 = $this->pdo->prepare("UPDATE users SET status = :status WHERE unique_id = :unique_id");

                        $stmt2->bindParam(":status", $status);
                        $stmt2->bindParam(":unique_id", $row["unique_id"]);

                        $stmt2->execute();

                        $_SESSION["unique_id"] = $row["unique_id"];

                        unset($_SESSION["entered_first_name"]);
                        unset($_SESSION["entered_last_name"]);
                        unset($_SESSION["entered_email"]);
                        unset($_SESSION["entered_password"]);

                        header("Location: ../panel.php");
                        exit();
                    } catch (PDOException $e) {
                        echo "Błąd: " . $e->getMessage();
                    }
                } else {
                    $_SESSION["err_password"] = "<p>Nieprawidłowe hasło</p>";
                }
            } else {
                $_SESSION["err_email"] = "<p>Nieprawidłowy email</p>";
            }
        } catch (PDOException $e) {
            echo "Błąd: " . $e->getMessage();
        }

        header("Location: ../sign-in.php");
    }
}
