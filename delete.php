<?php
require 'Database.php';
$db = new Database();

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    if ($db->deleteBlog($_GET['id'])) {
        echo json_encode(["status" => "success", "message" => "Blog deleted successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error deleting blog."]);
    }
}
?>
