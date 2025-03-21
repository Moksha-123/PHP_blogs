<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "php-test2";

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database connection failed."]));
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM blogs WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Blog deleted successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error deleting blog."]);
    }

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid blog ID."]);
}

$conn->close();
?>
