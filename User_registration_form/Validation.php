<?php
class Validation {
    public function name($value) {
        return preg_match("/^[a-zA-Z' ]+$/", $value);
    }

    public function email($value) {
        return preg_match("/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/", $value);
    }

    public function password($value) {
        return preg_match("/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/", $value);
    }
}
?>
