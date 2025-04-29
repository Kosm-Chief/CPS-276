<?php
// Make sure the session is started exactly once
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Protects a page by checking if the user is logged in.
 * Optionally, can restrict to a specific status ('admin' or 'staff').
 *
 * @param string|null $requiredStatus 'admin' or 'staff' or null
 */
function protectPage($requiredStatus = null) {
    // Check if user is logged in
    if (!isset($_SESSION['access']) || $_SESSION['access'] !== 'granted') {
        header("Location: index.php?page=login&error=" . urlencode("You must log in first."));
        exit();
    }

    // If a specific status is required (like admin), check it
    if ($requiredStatus !== null && (!isset($_SESSION['status']) || $_SESSION['status'] !== $requiredStatus)) {
        header("Location: index.php?page=welcome&error=" . urlencode("Access Denied."));
        exit();
    }
}
?>
