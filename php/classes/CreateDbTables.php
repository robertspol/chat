<?php
require_once "ConnectDb.php";

class CreateDbTables extends ConnectDb
{
    public function __construct()
    {
        parent::__construct();
    }

    public function createUsersTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS users (
                user_id INT AUTO_INCREMENT PRIMARY KEY,
                unique_id VARCHAR(23),
                first_name VARCHAR(255),
                last_name VARCHAR(255),
                email VARCHAR(255),
                password VARCHAR(255),
                img VARCHAR(255),
                status VARCHAR(10)
            ) CHARACTER SET utf8 COLLATE utf8_general_ci";

        $this->pdo->exec($sql);
    }

    public function createMessagesTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS messages (
                msg_id INT AUTO_INCREMENT PRIMARY KEY,
                outgoing_id VARCHAR(23),
                incoming_id VARCHAR(23),
                message VARCHAR(1000)
            ) CHARACTER SET utf8 COLLATE utf8_general_ci";

        $this->pdo->exec($sql);
    }
}
