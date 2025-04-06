<?php
class Db_conn {
    protected function connect() {
        $dsn = 'mysql:host=localhost;dbname=mblaser';
        try {
            return new PDO($dsn, 'mblaser', 'SdbxfxYq9SU8');
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
            exit;
        }
    }
}
?>
