<?php
session_start();
include 'db.php';

// Handle shoutbox submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['shout'])) {
    $username = htmlspecialchars($_POST['username']);
    $message = htmlspecialchars($_POST['message']);
    $stmt = $pdo->prepare("INSERT INTO shoutbox (username, message) VALUES (?, ?)");
    $stmt->execute([$username, $message]);
}

// Fetch shoutbox messages
$shouts = $pdo->query("SELECT * FROM shoutbox ORDER BY created_at DESC LIMIT 10")->fetchAll(PDO::FETCH_ASSOC);

// Fetch recent posts
$posts = $pdo->query("SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id ORDER BY created_at DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Zero Day Hacking Blog</title>
</head>
<body>
    <header>
        <div class="shoutbox">
            <h2>Shoutbox</h2>
            <form method="POST">
                <input type="text" name="username" placeholder="Username" required>
                <textarea name="message" placeholder="Message" required></textarea>
                <button type="submit" name="shout">Send</button>
            </form>
            <div class="shouts">
                <?php foreach ($shouts as $shout): ?>
                    <div class="shout">
                        <strong><?php echo htmlspecialchars($shout['username']); ?>:</strong>
                        <p><?php echo htmlspecialchars($shout['message']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </header>

    <main>
        <h1>Recent Posts</h1>
        <?php foreach ($posts as $post): ?>
            <div class="post">
                <h2><?php echo htmlspecialchars($post['title']); ?></h2>
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
