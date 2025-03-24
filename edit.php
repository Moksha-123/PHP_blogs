<?php
require 'Database.php';
$db = new Database();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['blog_id'];
    $blogname = trim($_POST['blogname']);
    $authorname = trim($_POST['authorname']);
    $body = trim($_POST['body']);

    if ($db->updateBlog($id, $blogname, $authorname, $body)) {
        echo json_encode([
            "status" => "success",
            "message" => "Blog updated successfully!",
            "id" => $id,
            "blog_name" => $blogname,
            "author_name" => $authorname,
            "body" => $body
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error updating blog."]);
    }
} elseif (isset($_GET['id'])) {
    $blog = $db->getBlogById($_GET['id']);
    echo json_encode($blog);
}
?>
