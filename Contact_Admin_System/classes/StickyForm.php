<?php
class StickyForm {
    private $errors = [];
    private $formData = [];

    // Validate form based on validation rules
    public function validateForm($formData, $validation) {
        foreach ($validation as $field => $rules) {
            $value = trim($formData[$field] ?? '');

            // If required and empty
            if (!empty($rules['required']) && empty($value)) {
                $this->errors[$field][] = 'This field is required.';
            } 
            // If regex rule provided and value doesn't match
            elseif (!empty($rules['regex']) && !preg_match($rules['regex'], $value)) {
                $this->errors[$field][] = 'Invalid format.';
            }

            // Always save the form input for sticky purposes
            $this->formData[$field] = $value;
        }

        return $this->errors;
    }

    // Get sticky form data after validation
    public function getFormData() {
        return $this->formData;
    }
}
?>
