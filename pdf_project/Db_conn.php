<?php
class Db_conn {
    private $conn;

    public function dbOpen() {
        $dsn = 'mysql:host=localhost;dbname=mblaser';  // <== UPDATED DB NAME
        $username = 'mblaser';
        $password = 'SdbxfxYq9SU8'; // Or use your assigned password if your prof gave you one

        try {
            $this->conn = new PDO($dsn, $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch (PDOException $e) {
            echo "Database Connection Failed: " . $e->getMessage();
            exit;
        }
    }
}
?>
