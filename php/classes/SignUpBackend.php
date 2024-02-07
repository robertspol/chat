<?php
require_once "ConnectDb.php";
session_start();
ini_set("display_errors", 0);

class SignUpBackend extends ConnectDb
{
    public function __construct()
    {
        parent::__construct();
    }

    public function signUp($formData, $formFile)
    {
        if (isset($formData["first_name"])) {
            $allCorrect = true;

            $firstName = $formData["first_name"];
            $lastName = $formData["last_name"];

            $email = $formData["email"];

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $allCorrect = false;
                $_SESSION["err_email"] = "<p>Niepoprawny email</p>";
            }

            try {
                $stmt = $this->pdo->prepare("SELECT email FROM users WHERE email = :email");
                $stmt->bindParam(":email", $email);
                $stmt->execute();
            } catch (PDOException $e) {
                echo "Błąd: " . $e->getMessage();
            }

            if ($stmt->rowCount() > 0) {
                $allCorrect = false;
                $_SESSION["err_email"] = "<p>Użytkownik z takim e-mailem już istnieje</p>";
            }

            $password = $formData["password"];

            if (strlen($password) < 5 || strlen($password) > 20) {
                $allCorrect = false;
                $_SESSION["err_password"] = "<p>Hasło musi zawierać od 5 do 20 znaków</p>";
            }

            $passwordHashed = password_hash($password, PASSWORD_DEFAULT);

            if (isset($formFile["img"])) {
                $imgName = $formFile["img"]["name"];
                $tmpName = $formFile["img"]["tmp_name"];

                $imgExplode = explode(".", $imgName);
                $imgExt = end($imgExplode);

                $extensions = ["jpg", "jpeg", "png"];

                if (in_array($imgExt, $extensions)) {
                    $time = time();
                    $newImgName = $time . $imgName;

                    if (!move_uploaded_file($tmpName, "../../img/" . $newImgName)) {
                        echo "Nie udało się przekazać pliku";
                        exit();
                    }
                } else {
                    $allCorrect = false;
                    $_SESSION["err_img"] = "<p>Plik musi posiadać rozszerzenie jpg, jpeg lub png</p>";
                }
            } else {
                $allCorrect = false;
                $_SESSION["err_img"] = "<p>Wybierz zdjęcie</p>";
            }

            if ($allCorrect) {
                $randomID = uniqid("", true);
                $status = "Nieaktywny";

                try {
                    $stmt2 = $this->pdo->prepare("INSERT INTO users (unique_id, first_name, last_name, email, password, img, status) VALUES (:unique_id, :first_name, :last_name, :email, :password, :img, :status)");

                    $stmt2->bindParam(":unique_id", $randomID);
                    $stmt2->bindParam(":first_name", $firstName);
                    $stmt2->bindParam(":last_name", $lastName);
                    $stmt2->bindParam(":email", $email);
                    $stmt2->bindParam(":password", $passwordHashed);
                    $stmt2->bindParam(":img", $newImgName);
                    $stmt2->bindParam(":status", $status);

                    $stmt2->execute();

                    header("Location: ../sign-in.php");
                    exit();
                } catch (PDOException $e) {
                    echo "Błąd: " . $e->getMessage();
                    exit();
                }
            }

            $_SESSION["entered_first_name"] = $firstName;
            $_SESSION["entered_last_name"] = $lastName;
            $_SESSION["entered_email"] = $email;
            $_SESSION["entered_password"] = $password;
        }

        header("Location: ../../index.php");
    }
}
