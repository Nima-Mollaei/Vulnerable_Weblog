<?php
include 'header.php';
include 'db.php';
include 'functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input from the form
    $username = $_POST["username"];

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        $random_string = md5(generateRandomString(10));
        $sql = "UPDATE users SET `token` = '$random_string' WHERE username = '$username'";
        $update_result = mysqli_query($conn, $sql);

        // email the link
        $message = "The reset link has been sent to your email address: " . $row['email'] . "<br>";
        $message .= "http://" . $_SERVER['SERVER_NAME'] . "/reset_password.php?token=$random_string";

    }
}
?>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Index</a></li>
                <li><a href="/all_posts.php">All Posts</a></li>
                <li><a href="/user_panel.php">User Panel</a></li>
            </ul>
        </nav>
    </header>
</body>

<main>
<h1>Reset Password</h1>
<form action="forget_password.php" method="post">

    <label for="username">Username:</label>
    <input type="username" id="username" name="username" value="<?php if(array_key_exists('username', $_GET)) echo $_GET['username'];?>" required>
    <input type="submit" value="Reset"><br><br>
</form>


<?php
if (isset($message)) {
    echo "<p>$message</p>";
}
include 'footer.php';
?>