<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login2.php"); // Redirect to the new login page
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
        /* Add your previous CSS code here */
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
            <a href="forum.php" class="button">Home</a>
            <a href="logout.php" class="button">Logout</a>
        </div>
    </nav>

    <!-- Main Content Section -->
    <section>
        <h2>Welcome, <?php echo $_SESSION['username']; ?>! Create a new post:</h2>
        
        <!-- New Post Form -->
        <div class="new-post">
            <h3>Create a New Post</h3>
            <input type="text" placeholder="Post Title" id="postTitle">
            <textarea placeholder="Post Content" id="postContent"></textarea>
            <button onclick="submitPost()">Submit Post</button>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Forum Page | All Rights Reserved</p>
    </footer>

    <script>
        function submitPost() {
            const title = document.getElementById('postTitle').value;
            const content = document.getElementById('postContent').value;

            if (title && content) {
                // Here you would send the data to the server (via AJAX or a form submission)
                alert("Post submitted successfully!");
            } else {
                alert("Please fill in both title and content.");
            }
        }
    </script>

</body>
</html>
