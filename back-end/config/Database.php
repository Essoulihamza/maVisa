<?php
class Database {
    private $host = 'localhost';
    private $dbname = 'myvisa';
    private $user = 'root';
    private $password = '';
    private $conn;

    public function connect() {
        $this->conn = NULL;
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        
        try {
            $this->conn = new PDO($dsn, $this->user, $this->password);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e;
        }

        return $this->conn;
    }
}