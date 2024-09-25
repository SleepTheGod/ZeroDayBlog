<?php
session_start();
include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page or display an error message
    echo "You must be logged in to create a post.";
    exit;
}

// Handle post submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'], $_POST['content'])) {
    // Sanitize and validate inputs
    $title = htmlspecialchars(trim($_POST['title']));
    $content = htmlspecialchars(trim($_POST['content']));
    $user_id = $_SESSION['user_id']; // Assuming user ID is stored in the session upon login

    if (!empty($title) && !empty($content)) {
        // Insert the post into the posts table
        $stmt = $pdo->prepare("INSERT INTO posts (user_id, title, content) VALUES (?, ?, ?)");
        if ($stmt->execute([$user_id, $title, $content])) {
            // Redirect to the forum or index page after successful post submission
            header("Location: forum.php");
            exit;
        } else {
            echo "Failed to save the post. Please try again.";
        }
    } else {
        echo "Both title and content are required.";
    }
} else {
    echo "Invalid request.";
}
?>
