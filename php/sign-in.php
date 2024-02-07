<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat - logowanie</title>
    <link rel="stylesheet" href="../css/index.min.css">
</head>

<body>
    <div class="container">
        <form action="actions/sign-in-action.php" method="POST">
            <input type="email" name="email" placeholder="E-mail">

            <?php
            if (isset($_SESSION["err_email"])) {
                echo $_SESSION["err_email"];
                unset($_SESSION["err_email"]);
            }
            ?>

            <input type="password" name="password" placeholder="Hasło">

            <?php
            if (isset($_SESSION["err_password"])) {
                echo $_SESSION["err_password"];
                unset($_SESSION["err_password"]);
            }
            ?>

            <button class="btn">Zaloguj się</button>
        </form>

        <div class="sign-wrapper">
            <p>Jeśli nie masz konta - załóż je</p>
            <a href="../index.php" class="btn">Zarejestruj się</a>
        </div>
    </div>
</body>

</html>