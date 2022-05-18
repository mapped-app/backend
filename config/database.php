<?php

class Database
{
    public $conn;
    private $host = "db-mysql-fra1-01234-do-user-11603544-0.b.db.ondigitalocean.com:25060";
    private $database_name = "defaultdb";
    private $username = "doadmin";
    private $password = "AVNS_KlXxL4hF1Em7cZt";

    public function getConnection()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Database could not be connected: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
