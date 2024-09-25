<?php
// db.php
$host = 'localhost'; // Database host
$db = 'hacking_blog'; // Database name
$user = 'root'; // Your MySQL username
$pass = ''; // Your MySQL password

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    
    // Set PDO attributes for error mode and character set
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Handle connection errors
    echo "Connection failed: " . htmlspecialchars($e->getMessage());
    exit; // Stop further execution
}
?>
