<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat - rejestracja</title>
    <link rel="stylesheet" href="css/index.min.css">
</head>

<body>
    <div class="container">
        <form action="php/actions/sign-up-action.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="first_name" placeholder="Imię" value=<?php
                                                                            if (isset($_SESSION["entered_first_name"])) {
                                                                                echo $_SESSION["entered_first_name"];
                                                                                unset($_SESSION["entered_first_name"]);
                                                                            }
                                                                            ?>>
            <input type="text" name="last_name" placeholder="Nazwisko" value=<?php
                                                                                if (isset($_SESSION["entered_last_name"])) {
                                                                                    echo $_SESSION["entered_last_name"];
                                                                                    unset($_SESSION["entered_last_name"]);
                                                                                }
                                                                                ?>>
            <input type="email" name="email" placeholder="E-mail" value=<?php
                                                                        if (isset($_SESSION["entered_email"])) {
                                                                            echo $_SESSION["entered_email"];
                                                                            unset($_SESSION["entered_email"]);
                                                                        }
                                                                        ?>>

            <?php
            if (isset($_SESSION["err_email"])) {
                echo $_SESSION["err_email"];
                unset($_SESSION["err_email"]);
            }
            ?>

            <input type="password" name="password" placeholder="Hasło" value=<?php
                                                                                if (isset($_SESSION["entered_password"])) {
                                                                                    echo $_SESSION["entered_password"];
                                                                                    unset($_SESSION["entered_password"]);
                                                                                }
                                                                                ?>>

            <?php
            if (isset($_SESSION["err_password"])) {
                echo $_SESSION["err_password"];
                unset($_SESSION["err_password"]);
            }
            ?>

            <input type="file" name="img">

            <?php
            if (isset($_SESSION["err_img"])) {
                echo $_SESSION["err_img"];
                unset($_SESSION["err_img"]);
            }
            ?>

            <button type="submit" class="btn">Załóż konto</button>
        </form>

        <div class="sign-wrapper">
            <p>Jeśli masz już konto - zaloguj się</p>
            <a href="php/sign-in.php" class="btn">Zaloguj się</a>
        </div>
    </div>
</body>

</html>