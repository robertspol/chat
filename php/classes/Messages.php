<?php
require_once "ConnectDb.php";

class Messages extends ConnectDb
{
    private $outgoingID;
    private $incomingID;
    private $message;

    public function __construct($outgoingID, $incomingID, $message = null)
    {
        parent::__construct();

        $this->outgoingID = $outgoingID;
        $this->incomingID = $incomingID;
        $this->message = $message;
    }

    public function insertMessage()
    {
        if (!empty($this->message)) {
            $stmt = $this->pdo->prepare("INSERT INTO messages (outgoing_id, incoming_id, message) VALUES (:outgoing_id, :incoming_id, :message)");

            $stmt->bindValue(":outgoing_id", $this->outgoingID);
            $stmt->bindValue(":incoming_id", $this->incomingID);
            $stmt->bindValue(":message", $this->message);

            $stmt->execute();
        }
    }

    public function getMessage()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM messages WHERE outgoing_id = :outgoing_id AND incoming_id = :incoming_id OR outgoing_id = :incoming_id2 AND incoming_id = :outgoing_id2 ORDER BY msg_id");

        $stmt->bindValue(":outgoing_id", $this->outgoingID);
        $stmt->bindValue(":incoming_id", $this->incomingID);
        $stmt->bindValue(":incoming_id2", $this->incomingID);
        $stmt->bindValue(":outgoing_id2", $this->outgoingID);

        $stmt->execute();

        $output = "";

        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if ($row["outgoing_id"] === $this->outgoingID) {
                    $output .= '<div class="chat-window__outgoing">
                                    <p>' . $row["message"] . '</p>
                                </div>';
                } else {
                    $output .= '<div class="chat-window__incoming">
                                    <p>' . $row["message"] . '</p>
                                </div>';
                }
            }
        }

        echo $output;
    }
}
