<?php
class Db_conn {
    private $host = 'localhost';  // <-- your server
    private $db = 'mblaser'; // <-- your database
    private $user = 'mblaser';    // <-- your username
    private $pass = 'SdbxfxYq9SU8';    // <-- your password
    protected $pdo; // <-- THIS is critical (protected, not private!)

    public function connect() {
        try {
            $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->db", 
                                 $this->user, 
                                 $this->pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->pdo;
        } catch (PDOException $e) {
            echo 'Connection Failed: ' . $e->getMessage();
            exit();
        }
    }
}
?>
