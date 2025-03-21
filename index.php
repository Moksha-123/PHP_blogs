<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "php-test2";

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogs</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="text-center fs-1 text-dark">Blogs</h2>

        <!-- Success & Error Messages -->
        <div id="successMessage" class="alert alert-success d-none"></div>
        <div id="errorMessage" class="alert alert-danger d-none"></div>

        <!-- Blog Form -->
        <form id="blogForm" class="bg-white p-4 shadow-sm rounded mt-4">
            <input type="hidden" id="blog_id" name="blog_id">
            <div class="mb-3">
                <label>Enter Blog Name</label>
                <input type="text" id="blogname" name="blogname" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Enter Author Name</label>
                <input type="text" id="authorname" name="authorname" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Body</label>
                <textarea id="body" name="body" class="form-control" rows="2" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <!-- Blog List -->
        <div id="blogList" class="row mt-4"></div>
    </div>

    <!-- JavaScript -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            fetchBlogs();

            document.getElementById("blogForm").addEventListener("submit", function (e) {
                e.preventDefault();
                let formData = new FormData(this);

                fetch("add.php", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    showMessage(data.message, data.status);
                    fetchBlogs();
                    this.reset();
                })
                .catch(() => showMessage("Error adding blog.", "error"));
            });
        });

        function fetchBlogs() {
            fetch("get.php")
                .then(response => response.text())
                .then(data => {
                    document.getElementById("blogList").innerHTML = data;
                });
        }

        function deleteBlog(id) {
            if (confirm("Are you sure you want to delete this blog?")) {
                fetch(`delete.php?id=${id}`)
                    .then(response => response.json())
                    .then(data => {
                        showMessage(data.message, data.status);
                        fetchBlogs();
                    });
            }
        }

        function showMessage(message, type) {
    let messageElement = document.createElement("p");
    messageElement.innerText = message;
    messageElement.className = `alert ${type === "success" ? "alert-success" : "alert-danger"} text-center fw-bold`;
    messageElement.style.position = "fixed";
    messageElement.style.top = "10px";
    messageElement.style.left = "50%";
    messageElement.style.transform = "translateX(-50%)";
    messageElement.style.zIndex = "1050";
    messageElement.style.padding = "10px";
    messageElement.style.width = "auto";
    messageElement.style.maxWidth = "80%";

    document.body.appendChild(messageElement);

    setTimeout(() => {
        messageElement.remove();
    }, 3000);
}

    </script>
</body>
</html>
