<?php
session_start();

if (!$_SESSION["unique_id"]) {
    header("Location: ../index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat - panel użytkownika</title>
    <link rel="stylesheet" href="../css/index.min.css">
</head>

<body>
    <div class="container">
        <div class="panel">
            <div class="panel__top">
                <div class="user">

                    <?php
                    require_once "classes/ConnectDb.php";

                    try {
                        $conn = new ConnectDb();

                        $stmt = $conn->pdo->prepare("SELECT * FROM  users WHERE unique_id = :unique_id");
                        $stmt->bindParam(":unique_id", $_SESSION["unique_id"]);
                        $stmt->execute();

                        if ($stmt->rowCount() > 0) {
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                        }
                    } catch (PDOException $e) {
                        echo "Błąd: " . $e->getMessage();
                    }
                    ?>

                    <img src="../img/<?php echo $row["img"] ?>" alt="photo">

                    <div class="user__info">
                        <p class="user__name"><?php echo $row["first_name"] . " " . $row["last_name"] ?></p>

                        <div class="user__is-active-wrapper">
                            <p><?php echo $row["status"] ?></p>
                            <div class="is-active online"></div>
                        </div>
                    </div>
                </div>

                <div class="panel__btns-wrapper">
                    <a href="actions/sign-out-action.php" class="panel__btn btn">Wyloguj</a>
                    <button class="panel__btn btn">Usuń konto</button>
                </div>
            </div>

            <div class="panel__bottom">
                <input type="text" class="panel__search" placeholder="Szukaj rozmówcy">

                <ul class="panel__users-list"></ul>
            </div>
        </div>
    </div>

    <script src="../js/users.js"></script>
</body>

</html>