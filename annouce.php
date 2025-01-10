<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum Page</title>
    <style>
        /* Your existing styles go here */
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

</body>
</html>
