<?php
class Db_conn {
    private $conn;
    private $host;
    private $username;
    private $password;
    private $database;

    public function __construct() {
        $this->host = 'localhost';
        $this->username = 'mblaser';
        $this->password = 'SdbxfxYq9SU8';
        $this->database = 'mblaser';
    }

    public function connect() {
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->database", 
                                 $this->username, 
                                 $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch(PDOException $e) {
            error_log("Connection failed: " . $e->getMessage());
            return false;
        }
    }
} 