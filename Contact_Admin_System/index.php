<?php
// Start session and set proper error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
error_log("Index.php - Session started. Session data: " . print_r($_SESSION, true));

require_once 'includes/security.php';
require_once 'routes/router.php';
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Contact Admin System</title>
		<!-- Bootstrap CSS -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
		<!-- Custom CSS -->
		<style>
			.nav { margin-bottom: 20px; }
			.nav-link { color: #0d6efd; text-decoration: none; margin-right: 15px; }
			.nav-link:hover { color: #0a58ca; }
			.table { margin-top: 20px; }
			.btn { margin-top: 10px; }
		</style>
	</head>

	<body>
		<div class="container mt-4">
			<?php 
			if (isset($content)) {
				echo $content;
			}
			?>
		</div>
	</body>
</html> 