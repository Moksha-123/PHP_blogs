<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "php-test2";

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database connection failed."]));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $blogname = trim($_POST['blogname']);
    $authorname = trim($_POST['authorname']);
    $body = trim($_POST['body']);

    if (empty($blogname) || empty($authorname) || empty($body)) {
        echo json_encode(["status" => "error", "message" => "All fields are required!"]);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO blogs (blog_name, author_name, body) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $blogname, $authorname, $body);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Blog added successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error adding blog."]);
    }

    $stmt->close();
    $conn->close();
}
?>
