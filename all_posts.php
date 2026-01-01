<?php
session_start();
include 'header.php';
include 'db.php';

###############################
$no_result = false;

if(isset($_GET['search'])){
    $search = $_GET['search'];

 
    $user_q = mysqli_query($conn, "SELECT * FROM users WHERE username='$search' OR first_name='$search' OR last_name='$search'");
    $user = mysqli_fetch_assoc($user_q);

    if($user){
        $evil_condition = $user['first_name'];

        
        if(preg_match('/(OR|AND|=|--|\(|\))/i', $evil_condition)) {

            $sql = "SELECT * FROM posts WHERE author_id = $evil_condition";
        } else {
            $sql = "SELECT * FROM posts WHERE is_private = 0 AND author_id = " . $user['user_id'];
        }

    } else {
        $sql = "SELECT * FROM posts WHERE is_private = 0";
        $no_result = true;
    }

} else {
    $sql = "SELECT * FROM posts WHERE is_private = 0";
}

################################
function author_id_to_name($conn, $id) {
    $result = mysqli_query($conn, "SELECT * FROM `users` where `user_id` = " . $id);
    $author = mysqli_fetch_assoc($result);
    return $author['username'];
}

function category_id_to_name($conn, $id) {
    $result = mysqli_query($conn, "SELECT * FROM `categories` where `category_id` = " . $id);
    $author = mysqli_fetch_assoc($result);
    return $author['category_name'];
}

/*
if (array_key_exists('author_id', $_GET)) {
    # unsafe query led to SQLi vulnerability:
    $sql = "SELECT * FROM `posts` where author_id = " . $_GET['author_id'];
    # safe query:
    #$sql = "SELECT * FROM `posts` where author_id = " . intval($_GET['author_id']);
} else {
    $sql = "SELECT * FROM `posts`";
}
*/

$result = mysqli_query($conn, $sql);

$rows = array();

while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
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

        <form method="GET" action="">
            <input type="text" name="search" placeholder="Search by username / first name / last name">
            <button type="submit">Search</button>
        </form>

    </header>

    <main>
        <section>
            <h1>All blog posts</h1>

            <?php if($no_result): ?>
                <p style="color:red; font-weight:bold;">
                    No matching user found… Showing all posts instead.
                </p>
            <?php endif; ?>

            <?php foreach ($rows as $row) { ?>
            <p>
                - <a href="/show.php?post_id=<?php echo $row['post_id']; ?>">
                    <?php echo $row['title']; ?>
                </a>,
                published in <?php echo $row['publication_date']; ?>
                in <b><?php echo category_id_to_name($conn, $row['category_id']); ?></b>
                by
                <a href="all_posts.php?author_id=<?php echo $row['author_id']; ?>">
                    <?php echo author_id_to_name($conn, $row['author_id']);?>
                </a>
            </p>
            <?php } ?>
        </section>

<footer>
    <p> UPVEX Weblog </p>
    <p> tell_id:@nima_mollaee</p>
</footer>
</body>
</html>
