<?php
session_start();

$outgoing_id = $_SESSION["unique_id"];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $sql = "SELECT * FROM messages WHERE (outgoing_id = :unique_id1 OR incoming_id = :unique_id2) AND (outgoing_id = :outgoing_id1 OR incoming_id = :outgoing_id2) ORDER BY msg_id DESC LIMIT 1";

    $stmt2 = $this->pdo->prepare($sql);

    $stmt2->bindParam(":unique_id1", $row["unique_id"]);
    $stmt2->bindParam(":unique_id2", $row["unique_id"]);
    $stmt2->bindParam(":outgoing_id1", $outgoing_id);
    $stmt2->bindParam(":outgoing_id2", $outgoing_id);

    $stmt2->execute();

    $row2 = null;

    if ($stmt2->rowCount() > 0) {
        $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
        $res = $row2["message"];
    } else {
        $res = "Brak wiadomości";
    }

    (strlen($res) > 23) ? $msg = substr($res, 0, 23) . "..." : $msg = $res;

    $you = "";

    if (isset($row2)) {
        $outgoing_id === $row2["outgoing_id"] ? $you = "Ty: " : $you = "";
    }

    ($row["status"] === "Aktywny") ? $online = "online" : $online = "";

    $output .= '<li class="panel__list-item">
                    <a href="chat-window.php?user_id=' . $row["unique_id"] . '" class="panel__users-link">
                    <div class="panel__users-img-and-info">
                        <div class="user">
                            <img src="../img/' . $row["img"] . '" alt="photo">

                            <div class="user__info">
                                <p class="user__name">' . $row["first_name"] . " " . $row["last_name"] . '</p>
                                <p>' . $you . $msg . '</p>
                            </div>
                        </div>
                    </div>
                
                    <div class="is-active is-active--users ' . $online . '"></div>
                    
                    </a>
                </li>';
}
