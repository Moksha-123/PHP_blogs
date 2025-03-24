<?php
require 'Database.php';
$db = new Database();

$result = $db->getBlogs();
$output = "";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $output .= "
            <div class='col' id='blog-{$row['id']}'>
                <div class='card h-100 shadow-sm'>
                    <div class='card-body'>
                        <h5 class='card-title'>{$row['blog_name']}</h5>
                        <h6 class='card-subtitle text-muted'>By {$row['author_name']}</h6>
                        <p class='card-text'>{$row['body']}</p>
                        <button class='btn btn-sm btn-warning' onclick='editBlog({$row['id']})'>Edit</button>
                        <button class='btn btn-sm btn-danger' onclick='deleteBlog({$row['id']})'>Delete</button>
                    </div>
                </div>
            </div>
        ";
    }
} else {
    $output = "<p class='fs-3 text-muted'>No blogs available.</p>";
}

echo $output;
?>
