<?php
class Db_conn {
    private $host = "localhost";       // or 127.0.0.1
    private $dbname = "mblaser"; // <-- change this to your actual database name
    private $username = "mblaser";   // <-- change this to your DB username
    private $password = "SdbxfxYq9SU8";   // <-- change this to your DB password
    private $pdo;

    public function connect() {
        try {
            $this->pdo = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8",
                $this->username,
                $this->password
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->pdo;
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
}
?>
