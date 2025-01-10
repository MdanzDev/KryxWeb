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

        nav {
            background-color: #000;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        .buttons {
            display: flex;
            gap: 10px;
        }

        .button {
            background-color: red;
            color: white;
            border: none;
            padding: 10px 15px;
            font-size: 1rem;
            cursor: pointer;
            border-radius: 5px;
            text-decoration: none;
        }

        .menu-icon {
            font-size: 1.5rem;
            cursor: pointer;
            color: #fff;
            z-index: 1100;
        }

        .side-menu {
            position: fixed;
            top: 60px;
            right: -250px;
            width: 250px;
            height: calc(100% - 60px);
            background-color: #222;
            box-shadow: -2px 0 5px rgba(0, 0, 0, 0.5);
            transition: right 0.3s ease-in-out;
            z-index: 900;
        }

        .side-menu.visible {
            right: 0;
        }

        .side-menu a {
            display: block;
            padding: 15px;
            color: #f9d342;
            text-decoration: none;
            border-bottom: 1px solid #333;
        }

        .side-menu a:hover {
            background-color: #444;
        }

        section {
            padding: 50px 20px;
            text-align: center;
            margin-top: 70px;
        }

        footer {
            background-color: #000;
            color: #888;
            padding: 20px 0;
            text-align: center;
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

        .forum-post .replies {
            margin-top: 20px;
            padding-left: 20px;
        }

        .forum-post .reply {
            background-color: #444;
            margin-top: 10px;
            padding: 10px;
            border-radius: 5px;
        }

        .post-button {
            background-color: #444;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            text-decoration: none;
        }

        .post-button:hover {
            background-color: #555;
        }

        .new-post {
            margin-top: 20px;
            background-color: #222;
            padding: 20px;
            border-radius: 8px;
        }

        .new-post input,
        .new-post textarea,
        .new-post input[type="file"] {
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

        .new-post button:hover {
            background-color: #e0c336;
        }

        .image-preview {
            max-width: 100%;
            max-height: 200px;
            margin-top: 10px;
            display: none;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <header>
        <h1>Forum Page</h1>
        <p>Discuss anything and everything</p>
    </header>

    <!-- Navigation Bar -->
    <nav>
        <div class="menu-icon" onclick="toggleMenu()">☰</div>
        <div class="buttons">
            <a href="#" class="button">Home</a>
            <?php if (!$isLoggedIn): ?>
                <a href="login.php" class="button">Login</a>
                <a href="register.php" class="button">Register</a>
            <?php else: ?>
                <a href="logout.php" class="button">Logout</a>
            <?php endif; ?>
        </div>
    </nav>

    <!-- Side Menu -->
    <div id="sideMenu" class="side-menu">
        <a href="#">Forum</a>
        <a href="#">About</a>
        <a href="#">Contact</a>
    </div>

    <!-- Main Content Section -->
    <section>
        <h2>Recent Discussions</h2>

        <!-- Forum Posts -->
        <div class="forum-post">
            <h2>How to get started with coding?</h2>
            <p>This is a beginner-friendly discussion about the best resources for learning how to code. Feel free to share your tips!</p>

            <!-- Replies Section -->
            <div class="replies">
                <div class="reply">
                    <p><strong>User1:</strong> I recommend starting with Python. It's beginner-friendly!</p>
                </div>
                <div class="reply">
                    <p><strong>User2:</strong> Absolutely! Python is great for building foundational skills.</p>
                </div>
            </div>

            <!-- Reply Form (only for logged-in users) -->
            <?php if ($isLoggedIn): ?>
                <div class="new-post">
                    <h3>Reply to this post</h3>
                    <textarea placeholder="Write your reply" id="replyContent"></textarea>
                    <input type="file" id="replyImage" onchange="previewImage(event)">
                    <img id="imagePreview" class="image-preview" />
                    <button onclick="submitReply()">Submit Reply</button>
                </div>
            <?php else: ?>
                <p>You must be logged in to reply to this post.</p>
            <?php endif; ?>
        </div>

        <!-- Create New Post Form (only for logged-in users) -->
        <?php if ($isLoggedIn): ?>
            <div class="new-post">
                <h3>Clan Announcement</h3>
                <input type="text" placeholder="Post Title" id="postTitle" value="Clan Announcement" disabled>
                <textarea placeholder="Post Content" id="postContent"></textarea>
                <input type="file" id="postImage" onchange="previewPostImage(event)">
                <img id="postImagePreview" class="image-preview" />
                <button onclick="submitPost()">Submit Post</button>
            </div>
        <?php else: ?>
            <p>You must be logged in to create a new post.</p>
        <?php endif; ?>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Forum Page | All Rights Reserved</p>
    </footer>

    <!-- Script for menu toggle and handling replies/images -->
    <script>
        function toggleMenu() {
            const sideMenu = document.getElementById('sideMenu');
            sideMenu.classList.toggle('visible');
        }

        function submitPost() {
            const title = document.getElementById('postTitle').value;
            const content = document.getElementById('postContent').value;
            const image = document.getElementById('postImage').files[0];

            if (title && content) {
                const forumSection = document.querySelector('section');
                const newPost = document.createElement('div');
                newPost.classList.add('forum-post');
                newPost.innerHTML = `<h2>${title}</h2><p>${content}</p>`;
                if (image) {
                    newPost.innerHTML += `<img src="${URL.createObjectURL(image)}" alt="Post Image" style="max-width: 100%; margin-top: 10px;">`;
                }
                forumSection.insertBefore(newPost, forumSection.querySelector('.new-post'));
                document.getElementById('postTitle').value = '';
                document.getElementById('postContent').value = '';
                document.getElementById('postImage').value = '';
            }
        }

        function submitReply() {
            const replyContent = document.getElementById('replyContent').value;
            const replyImage = document.getElementById('replyImage').files[0];

            if (replyContent) {
                const forumPost = document.querySelector('.forum-post');
                const repliesSection = forumPost.querySelector('.replies');
                const newReply = document.createElement('div');
                newReply.classList.add('reply');
                newReply.innerHTML = `<p><strong>You:</strong> ${replyContent}</p>`;
                if (replyImage) {
                    newReply.innerHTML += `<img src="${URL.createObjectURL(replyImage)}" alt="Reply Image" style="max-width: 100%; margin-top: 10px;">`;
                }
                repliesSection.appendChild(newReply);
                document.getElementById('replyContent').value = '';
                document.getElementById('replyImage').value = '';
                document.getElementById('imagePreview').style.display = 'none';
            }
        }

        function previewImage(event) {
            const file = event.target.files[0];
            const reader = new FileReader();
            reader.onload = function() {
                const imagePreview = document.getElementById('imagePreview');
                imagePreview.src = reader.result;
                imagePreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }

        function previewPostImage(event) {
            const file = event.target.files[0];
            const reader = new FileReader();
            reader.onload = function() {
                const postImagePreview = document.getElementById('postImagePreview');
                postImagePreview.src = reader.result;
                postImagePreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    </script>

</body>
</html>
