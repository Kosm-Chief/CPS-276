<?php
require_once 'Db_conn.php';

class Pdo_methods extends Db_conn {

    public function selectBinded($sql, $bindings) {
        $this->connect();  // <--- Connect first!!
        $stmt = $this->pdo->prepare($sql);

        foreach($bindings as $binding) {
            $stmt->bindParam($binding['name'], $binding['value'], $binding['type']);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function otherBinded($sql, $bindings) {
        $this->connect(); // <--- Connect first!!
        $stmt = $this->pdo->prepare($sql);

        foreach($bindings as $binding) {
            $stmt->bindParam($binding['name'], $binding['value'], $binding['type']);
        }

        try {
            $stmt->execute();
            return 'Success';
        } catch (PDOException $e) {
            return 'Error: ' . $e->getMessage();
        }
    }
}
?>
