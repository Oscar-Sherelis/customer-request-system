<?php
// Input validation class

class Validator {
    private $errors = [];
    
    public function validateRequest($data) {
        $this->errors = [];
        
        // Client name - required, max 100 chars
        if (empty($data['fullname'])) {
            $this->errors['fullname'] = 'Client name is required';
        } elseif (strlen($data['fullname']) > 100) {
            $this->errors['fullname'] = 'Client name must not exceed 100 characters';
        }
        
        // Email - required, valid format, max 255 chars
        if (empty($data['email'])) {
            $this->errors['email'] = 'Email address is required';
        } elseif (strlen($data['email']) > 255) {
            $this->errors['email'] = 'Email must not exceed 255 characters';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'Please enter a valid email address';
        }
        
        // Subject - required, max 255 chars
        if (empty($data['subject'])) {
            $this->errors['subject'] = 'Subject is required';
        } elseif (strlen($data['subject']) > 255) {
            $this->errors['subject'] = 'Subject must not exceed 255 characters';
        }
        
        // Description - required, min 10 chars
        if (empty($data['description'])) {
            $this->errors['description'] = 'Description is required';
        } elseif (strlen($data['description']) < 10) {
            $this->errors['description'] = 'Description must be at least 10 characters';
        }
        
        // Priority - required, must be valid value
        $validPriorities = ['low', 'normal', 'high'];
        if (empty($data['priority'])) {
            $this->errors['priority'] = 'Priority is required';
        } elseif (!in_array($data['priority'], $validPriorities)) {
            $this->errors['priority'] = 'Invalid priority value';
        }
        
        return empty($this->errors);
    }
    
    public function getErrors() {
        return $this->errors;
    }
    
    public function sanitize($data) {
        if (is_array($data)) {
            return array_map([$this, 'sanitize'], $data);
        }
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }
}