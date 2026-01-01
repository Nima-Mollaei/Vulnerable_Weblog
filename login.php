<?php
ob_start();
session_start();
include 'header.php';
include 'db.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get user input from the form
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['is_logged'] = true;
        $_SESSION['username'] = $row['username'];
        $_SESSION['user_id'] = $row['user_id'];
        header("Location: user_panel.php"); // Redirect to a welcome page or dashboard
    } else {
        // Authentication failed
        $message = "Invalid username or password, If you cannot remember your password <a href='forget_password.php?username=$username'>click here</a>";
        $username = $_POST["username"];
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
<h1>Login</h1>
<form action="login.php" method="post">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br>

    <input type="submit" value="Login"><br><br>
    <a href='register.php'>Need a registration?</a><br>
</form>
<?php
if (array_key_exists('msg', $_GET)) {
    $message = $_GET['msg'];
}
if (isset($message)) {
    echo "<p>$message</p>";
}
include 'footer.php';
ob_end_flush();
?>
