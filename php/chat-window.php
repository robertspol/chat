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
    <title>Chat - okno rozmowy</title>
    <link rel="stylesheet" href="../css/index.min.css">
    <script src="https://kit.fontawesome.com/83b6ac67d9.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <div class="chat-window">
            <div class="user user--chat-window">
                <a href="panel.php">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>

                <?php
                require_once "classes/ConnectDb.php";

                if (isset($_GET["user_id"])) {
                    $diffUserUniqueID = $_GET["user_id"];
                    $uniqueID = $_SESSION["unique_id"];

                    $conn = new ConnectDb();

                    $stmt = $conn->pdo->prepare("SELECT * FROM users WHERE unique_id = :user_id");
                    $stmt->bindParam(":user_id", $diffUserUniqueID);
                    $stmt->execute();

                    if ($stmt->rowCount() > 0) {
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    }
                }
                ?>

                <img src="../img/<?php echo $row["img"] ?>" alt="photo">

                <div class="user__info">
                    <p class="user__name"><?php echo $row["first_name"] . " " . $row["last_name"] ?></p>

                    <div class="user__is-active-wrapper">
                        <p><?php echo $row["status"] ?></p>
                        <div class="is-active <?php echo $row["status"] === "Aktywny" ? "online" : "" ?>"></div>
                    </div>
                </div>
            </div>

            <div class="chat-window__messages"></div>

            <form class="chat-window__form">
                <input type="text" name="outgoing_id" value="<?php echo $uniqueID ?>" hidden>
                <input type="text" name="incoming_id" value="<?php echo $diffUserUniqueID ?>" hidden>

                <div class="chat-window__msg-and-btn">
                    <input type="text" class="chat-window__message-field" name="message" placeholder="Wpisz wiadomość">

                    <button class="chat-window__send-btn">
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="../js/chat.js"></script>
</body>

</html>