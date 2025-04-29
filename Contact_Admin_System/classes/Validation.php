<?php
class Validation {

    private $errors = [];

    public function checkFormat($value, $regex, $customError = null) {
        $patterns = [
            'name' => "/^[A-Za-z\s\-']+$/",
            'address' => "/^[0-9]+\s+[A-Za-z\s]+$/",
            'city' => "/^[A-Za-z\s]+$/",
            'zip' => "/^\d{5}$/",
            'phone' => "/^\d{3}\.\d{3}\.\d{4}$/",
            'email' => "/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/",
            'dob' => "/^(0?[1-9]|1[0-2])\/(0?[1-9]|[12][0-9]|3[01])\/(19|20)\d{2}$/",
            'password' => "/^.{8,}$/"
        ];

        if (!isset($patterns[$regex])) {
            $this->errors[$regex] = $customError ?? "Invalid validation rule.";
            return false;
        }

        if (!preg_match($patterns[$regex], $value)) {
            $this->errors[$regex] = $customError ?? "Invalid format for $regex.";
            return false;
        }
        return true;
    }

    public function getErrors() {
        return $this->errors;
    }
}
?>
