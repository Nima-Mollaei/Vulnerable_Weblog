<?php
ob_start();
include 'header.php';
include 'db.php';
include 'functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input from the form
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "UPDATE users set password = '$password' where username = '$username'";
    $result = mysqli_query($conn, $sql);

    if ($result === true){
        $sql = "UPDATE users SET `token` = NULL WHERE username = '$username'";
        $token_null = mysqli_query($conn, $sql);

        header("Location: login.php?msg=The new password has been set successfully");
    }
}

if (array_key_exists('token', $_GET)) {
    $token = $_GET['token'];

    $sql = "SELECT * FROM users where token = '$token'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $token_result = true;
    }
}

if (isset($token_result) === true) { ?>

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
<form action="reset_password.php" method="post">

    <label for="password">New password:</label>
    <input type="password" id="password" name="password" required><br>
    <input type="hidden" id="username" name="username" value="<?php echo $row['username']; ?>">


    <input type="submit" value="Reset the password"><br>
</form>

<?php } else {
    echo 'The provided token is not valid or expired, <a href="/login.php">go back</a>';
}

include 'footer.php';
ob_end_flush();
?>