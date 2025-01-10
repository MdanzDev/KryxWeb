<?php
session_start();

// Connect to the SQLite database
$db = new PDO('sqlite:forum.db');

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_post'])) {
    $title = $_POST['postTitle'];
    $content = $_POST['postContent'];
    $stmt = $db->prepare("INSERT INTO posts (title, content) VALUES (:title, :content)");
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':content', $content);
    $stmt->execute();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_reply'])) {
    $postId = $_POST['postId'];
    $replyContent = $_POST['replyContent'];
    $stmt = $db->prepare("INSERT INTO replies (post_id, content) VALUES (:post_id, :content)");
    $stmt->bindParam(':post_id', $postId);
    $stmt->bindParam(':content', $replyContent);
    $stmt->execute();
}
?>
<?php
// Fetch posts from the database
$posts = $db->query("SELECT * FROM posts ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #111;
            color: #fff;
            overflow-x: hidden;
        }

        header {
            background: url('https://files.fm/u/ay64ch9d5h') no-repeat center center/cover;
            text-align: center;
            padding: 100px 20px;
        }

        header h1 {
            font-size: 3rem;
            margin: 0;
            color: #f9d342;
        }

        header p {
            font-size: 1.5rem;
            margin-top: 10px;
            color: #ddd;
        }

        section {
            padding: 50px 20px;
            text-align: center;
            margin-top: 70px;
        }

        .forum-post {
            background-color: #333;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
            text-align: left;
        }

        .forum-post h2 {
            margin-top: 0;
            color: #f9d342;
        }

        .forum-post p {
            color: #ddd;
        }

        .replies {
            margin-top: 20px;
            padding-left: 20px;
        }

        .reply {
            background-color: #444;
            margin-top: 10px;
            padding: 10px;
            border-radius: 5px;
        }

        .new-post {
            margin-top: 20px;
            background-color: #222;
            padding: 20px;
            border-radius: 8px;
        }

        .new-post input,
        .new-post textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 5px;
        }

        .new-post button {
            background-color: #f9d342;
            color: #000;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <header>
        <h1>Forum Page</h1>
        <p>Discuss anything and everything</p>
    </header>

    <!-- Main Content Section -->
    <section>
        <h2>Recent Discussions</h2>

        <!-- Display Forum Posts -->
        <?php foreach ($posts as $post): ?>
            <div class="forum-post">
                <h2><?= htmlspecialchars($post['title']); ?></h2>
                <p><?= htmlspecialchars($post['content']); ?></p>

                <!-- Display Replies -->
                <div class="replies">
                    <?php
                    $postId = $post['id'];
                    $replies = $db->query("SELECT * FROM replies WHERE post_id = $postId ORDER BY created_at ASC")->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($replies as $reply): ?>
                        <div class="reply">
                            <p><?= htmlspecialchars($reply['content']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Reply Form (Visible if logged in) -->
                <?php if ($isLoggedIn): ?>
                    <div class="new-post">
                        <h3>Reply to this post</h3>
                        <form method="POST">
                            <textarea name="replyContent" placeholder="Write your reply" required></textarea>
                            <input type="hidden" name="postId" value="<?= $post['id']; ?>">
                            <button type="submit" name="submit_reply">Submit Reply</button>
                        </form>
                    </div>
                <?php else: ?>
                    <p>You must be logged in to reply to this post.</p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

        <!-- New Post Form (Visible if logged in) -->
        <?php if ($isLoggedIn): ?>
            <div class="new-post">
                <h3>Create a New Post</h3>
                <form method="POST">
                    <input type="text" name="postTitle" placeholder="Post Title" required>
                    <textarea name="postContent" placeholder="Post Content" required></textarea>
                    <button type="submit" name="submit_post">Submit Post</button>
                </form>
            </div>
        <?php else: ?>
            <p>You must be logged in to create a new post.</p>
        <?php endif; ?>
    </section>

</body>
</html>
