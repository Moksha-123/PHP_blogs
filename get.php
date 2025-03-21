<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "php-test2";

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Database connection failed.");
}

$sql = "SELECT id, blog_name, author_name, body FROM blogs ORDER BY id DESC";
$result = $conn->query($sql);

$output = "";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $output .= "
        <div class='col-md-4'>
            <div class='card shadow-sm mb-3'>
                <div class='card-body'>
                    <h5 class='card-title text-primary'>{$row['blog_name']}</h5>
                    <h6 class='card-subtitle mb-2 text-muted'>by {$row['author_name']}</h6>
                    <p class='card-text'>{$row['body']}</p>
                    <button class='btn btn-danger btn-sm' onclick='deleteBlog({$row['id']})'>Delete</button>
                </div>
            </div>
        </div>";
    }
} else {
    $output = "<p class='text-center fs-3'>No blogs found.</p>";
}

echo $output;
$conn->close();
?>
