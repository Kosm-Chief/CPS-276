<?php
// Ensures the path to Db_conn.php is always correct
require_once __DIR__ . "/Db_conn.php";

class PdoMethods extends Db_conn {

    private $sth;
    private $conn;
    private $db;
    private $error;

    // SELECT with bindings
    public function selectBinded($sql, $bindings) {
        $this->error = false;

        try {
            $this->db_connection();
            $this->sth = $this->conn->prepare($sql);
            $this->createBinding($bindings);
            $this->sth->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return 'error';
        }

        $this->conn = null;
        return $this->sth->fetchAll(PDO::FETCH_ASSOC);
    }

    // SELECT without bindings
    public function selectNotBinded($sql) {
        $this->error = false;

        try {
            $this->db_connection();
            $this->sth = $this->conn->prepare($sql);
            $this->sth->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return 'error';
        }

        $this->conn = null;
        return $this->sth->fetchAll(PDO::FETCH_ASSOC);
    }

    // INSERT/UPDATE/DELETE with bindings
    public function otherBinded($sql, $bindings) {
        $this->error = false;

        try {
            $this->db_connection();
            $this->sth = $this->conn->prepare($sql);
            $this->createBinding($bindings);
            $this->sth->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return 'error';
        }

        $this->conn = null;
        return 'noerror';
    }

    // INSERT/UPDATE/DELETE without bindings
    public function otherNotBinded($sql) {
        $this->error = false;

        try {
            $this->db_connection();
            $this->sth = $this->conn->prepare($sql);
            $this->sth->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return 'error';
        }

        $this->conn = null;
        return 'noerror';
    }

    // INTERNAL: connect to DB
    private function db_connection() {
        $this->db = new Db_conn();
        $this->conn = $this->db->dbOpen();
    }

    // INTERNAL: bind parameters securely
    private function createBinding($bindings) {
        foreach ($bindings as $value) {
            switch ($value[2]) {
                case "str":
                    $this->sth->bindParam($value[0], $value[1], PDO::PARAM_STR);
                    break;
                case "int":
                    $this->sth->bindParam($value[0], $value[1], PDO::PARAM_INT);
                    break;
            }
        }
    }
}
?>
