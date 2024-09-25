<?php
session_start();
include 'db.php';

// Handle post submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $title = htmlspecialchars($_POST['title']);
    $content = htmlspecialchars($_POST['content']);
    $user_id = 1; // Replace with actual user ID from session
    $stmt = $pdo->prepare("INSERT INTO posts (user_id, title, content) VALUES (?, ?, ?)");
    $stmt->execute([$user_id, $title, $content]);
}

// Fetch all posts
$posts = $pdo->query("SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Forum - Zero Day Hacking Blog</title>
</head>
<body>
    <header>
        <h1>Forum</h1>
        <form method="POST">
            <input type="text" name="title" placeholder="Post Title" required>
            <textarea name="content" placeholder="Post Content" required></textarea>
            <button type="submit" name="submit">Post</button>
        </form>
    </header>

    <main>
        <h2>All Posts</h2>
        <?php foreach ($posts as $post): ?>
            <div class="post">
                <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                <p><?php echo htmlspecialchars($post['content']); ?></p>
                <p>Posted by: <?php echo htmlspecialchars($post['username']); ?> on <?php echo $post['created_at']; ?></p>
            </div>
        <?php endforeach; ?>
    </main>

    <footer>
        <p>&copy; 2024 Zero Day Hacking Blog. All rights reserved.</p>
    </footer>
</body>
</html>
