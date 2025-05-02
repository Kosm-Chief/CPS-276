<?php
class Pdo_methods {
    private $pdo;

    public function __construct() {
        $db = new Db_conn();
        $this->pdo = $db->connect();
    }

    public function selectBinded($sql, $bindings) {
        try {
            $stmt = $this->pdo->prepare($sql);
            
            if (is_array($bindings)) {
                foreach ($bindings as $key => $value) {
                    if (is_array($value)) {
                        $stmt->bindValue($value[0], $value[1], $this->getPdoParamType($value[2]));
                    } else {
                        $stmt->bindValue($key + 1, $value);
                    }
                }
            }
            
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function otherBinded($sql, $bindings) {
        try {
            $stmt = $this->pdo->prepare($sql);
            
            foreach($bindings as $value) {
                $stmt->bindValue($value[0], $value[1], $this->getPdoParamType($value[2]));
            }
            
            $stmt->execute();
            return "noerror";
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return "error";
        }
    }

    private function getPdoParamType($type) {
        switch($type) {
            case 'int': return PDO::PARAM_INT;
            case 'str': return PDO::PARAM_STR;
            default: return PDO::PARAM_STR;
        }
    }
} 