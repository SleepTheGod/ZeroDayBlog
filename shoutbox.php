<?php
// shoutbox.php
session_start();
include 'db.php';

// Handle shoutbox submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['shout'])) {
    $username = htmlspecialchars($_POST['username']);
    $message = htmlspecialchars($_POST['message']);

    // Insert shout into the database
    $stmt = $pdo->prepare("INSERT INTO shoutbox (username, message) VALUES (?, ?)");
    $stmt->execute([$username, $message]);
}

// Fetch shoutbox messages
$shouts = $pdo->query("SELECT * FROM shoutbox ORDER BY created_at DESC LIMIT 10")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Shoutbox - Zero Day Hacking Blog</title>
</head>
<body>
    <header>
        <h1>Shoutbox</h1>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <textarea name="message" placeholder="Message" required></textarea>
            <button type="submit" name="shout">Send</button>
        </form>
    </header>

    <main>
        <h2>Recent Shouts</h2>
        <div class="shouts">
            <?php foreach ($shouts as $shout): ?>
                <div class="shout">
                    <strong><?php echo htmlspecialchars($shout['username']); ?>:</strong>
                    <p><?php echo htmlspecialchars($shout['message']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Zero Day Hacking Blog. All rights reserved.</p>
    </footer>
</body>
</html>
