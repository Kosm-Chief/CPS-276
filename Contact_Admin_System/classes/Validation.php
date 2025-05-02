<?php
class Validation {
    private $errors = [];

    // Check format based on regex type and set custom error message if provided
    public function checkFormat($value, $type, $customErrorMsg = null) {
        $patterns = [
            'name' => '/^[a-zA-Z\s\-\']{1,50}$/',
            'phone' => '/^\d{3}\.\d{3}\.\d{4}$/',
            'address' => '/^\d+\s+[a-zA-Z0-9\s,.\'-]{1,100}$/',
            'city' => '/^[a-zA-Z\s]{1,50}$/',
            'state' => '/^[A-Z]{2}$/',
            'zip' => '/^\d{5}(-\d{4})?$/',
            'email' => '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            'dob' => '/^(0[1-9]|1[0-2])\/(0[1-9]|[12][0-9]|3[01])\/\d{4}$/',
            'none' => '/.*/'
        ];

        // Use a generic default pattern if the type is not defined
        $pattern = $patterns[$type] ?? '/.*/';

        if (!preg_match($pattern, $value)) {
            $errorMessage = $customErrorMsg ?? "Invalid $type format.";
            $this->errors[$type] = $errorMessage;
            return false;
        }
        return true;
    }

    // Specific validation methods used in controllers
    public function checkName($name) {
        return $this->checkFormat($name, 'name', 'Name must contain only letters, hyphens, apostrophes, and spaces');
    }
    
    public function checkAddress($address) {
        return $this->checkFormat($address, 'address', 'Address must start with a number followed by letters and spaces');
    }
    
    public function checkCity($city) {
        return $this->checkFormat($city, 'city', 'City must contain only letters and spaces');
    }
    
    public function checkState($state) {
        return $this->checkFormat($state, 'state', 'State must be a valid two-letter code');
    }
    
    public function checkZip($zip) {
        return $this->checkFormat($zip, 'zip', 'ZIP code must be in format 12345 or 12345-6789');
    }
    
    public function checkPhone($phone) {
        return $this->checkFormat($phone, 'phone', 'Phone must be in format 999.999.9999');
    }
    
    public function checkEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'Please enter a valid email address';
            return false;
        }
        return true;
    }
    
    public function checkDOB($dob) {
        if (!$this->checkFormat($dob, 'dob')) {
            $this->errors['dob'] = 'Date of birth must be in format mm/dd/yyyy';
            return false;
        }
        
        // Additional date validation
        $parts = explode('/', $dob);
        if (count($parts) === 3) {
            if (!checkdate($parts[0], $parts[1], $parts[2])) {
                $this->errors['dob'] = 'Please enter a valid date';
                return false;
            }
        }
        return true;
    }

    // Get all validation errors
    public function getErrors() {
        return $this->errors;
    }

    // Check if there are any errors
    public function hasErrors() {
        return !empty($this->errors);
    }

    // Clear all errors
    public function clearErrors() {
        $this->errors = [];
    }
}
?>