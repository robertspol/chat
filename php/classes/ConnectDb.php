<?php
ini_set("display_errors", 0);

class ConnectDb
{
    private $host;
    private $user;
    private $password;

    public $pdo;

    public function __construct()
    {
        $this->host = "localhost";
        $this->user = "root";
        $this->password = "";

        $this->pdo = $this->connect();
    }

    private function connect()
    {
        try {
            $pdo = new PDO(
                "mysql:host={$this->host}; charset=utf8",
                $this->user,
                $this->password,
                [
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]
            );

            $pdo->exec("CREATE DATABASE IF NOT EXISTS chat CHARACTER SET utf8 COLLATE utf8_general_ci");
            $pdo->exec("USE chat");

            return $pdo;
        } catch (PDOException $e) {
            echo "Nie udało się nawiązać połączenia z bazą danych. Błąd: " . $e->getMessage();
        }
    }
}
