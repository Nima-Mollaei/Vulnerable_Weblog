<?php
include 'db.php';
session_start();


if (!isset($_SESSION['is_logged'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}


if (!isset($_GET['user_id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing user_id']);
    exit;
}

$user_id = $_GET['user_id'];


$sql = "SELECT post_id, title, content FROM posts WHERE author_id = $user_id";
$result = mysqli_query($conn, $sql);

$posts = [];
while($row = mysqli_fetch_assoc($result)) {
    $posts[] = $row;
}

header('Content-Type: application/json');
echo json_encode($posts);

