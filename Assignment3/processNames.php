<?php

session_start(); // Start the session to persist names

function addClearNames() {
    require_once 'sessionHandler.php'; // Require session handler if needed

    if (!isset($_SESSION['names'])) {
        $_SESSION['names'] = [];
    }

    if (isset($_POST['addName'])) {
        $fullName = trim($_POST['nameInput']);
        
        if (!empty($fullName)) {
            $nameParts = explode(" ", $fullName, 2);
            
            if (count($nameParts) == 2) {
                $formattedName = "{$nameParts[1]}, {$nameParts[0]}";
                array_push($_SESSION['names'], $formattedName);
            }
        }
    }

    if (isset($_POST['clearNames'])) {
        $_SESSION['names'] = [];
    }

    sort($_SESSION['names']);
    
    return implode("\n", $_SESSION['names']);
}

?>
