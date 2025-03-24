<?php
require 'Database.php';
$db = new Database();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $blogname = trim($_POST['blogname']);
    $authorname = trim($_POST['authorname']);
    $body = trim($_POST['body']);

    if ($db->addBlog($blogname, $authorname, $body)) {
        echo json_encode(["status" => "success", "message" => "Blog added successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error adding blog."]);
    }
}
?>
