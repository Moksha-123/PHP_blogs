<?php require 'Database.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5 mb-5">
        <h2 class="text-center fs-1 text-primary">Blogs</h2>

        <form id="blogForm" class="bg-white p-4 shadow-sm rounded mt-4">
            <input type="hidden" id="blog_id" name="blog_id">
            <div class="mb-3">
                <label class="form-label">Enter Blog Name</label>
                <input type="text" id="blogname" name="blogname" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Enter Author Name</label>
                <input type="text" id="authorname" name="authorname" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Body</label>
                <textarea id="body" name="body" class="form-control" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <div id="messageBox"></div>
        <div id="blogList" class="row row-cols-1 row-cols-md-3 g-4 mt-2"></div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
    fetchBlogs();

    document.getElementById("blogForm").addEventListener("submit", function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        let isEditing = document.getElementById("blog_id").value;
        let url = isEditing ? "edit.php" : "add.php";

        fetch(url, {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            showMessage(data.message, data.status);

            if (isEditing) {
                updateBlogInUI(data);  // Update UI without reload
            } else {
                fetchBlogs();  // Fetch new blogs if adding
            }

            this.reset();
            document.getElementById("blog_id").value = "";
        })
        .catch(() => showMessage("Error processing request.", "error"));
    });
});

// Fetch and display all blogs
function fetchBlogs() {
    fetch("get.php")
        .then(response => response.text())
        .then(data => {
            document.getElementById("blogList").innerHTML = data;
        });
}

// Fetch a blog and populate form for editing
function editBlog(id) {
    fetch(`edit.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById("blog_id").value = data.id;
            document.getElementById("blogname").value = data.blog_name;
            document.getElementById("authorname").value = data.author_name;
            document.getElementById("body").value = data.body;
            document.querySelector("button[type='submit']").textContent = "Update";
        });
}

// Update the blog UI dynamically
function updateBlogInUI(data) {
    let blogCard = document.getElementById(`blog-${data.id}`);
    if (blogCard) {
        blogCard.innerHTML = `
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">${data.blog_name}</h5>
                    <h6 class="card-subtitle text-muted">By ${data.author_name}</h6>
                    <p class="card-text">${data.body}</p>
                    <button class="btn btn-sm btn-warning" onclick="editBlog(${data.id})">Edit</button>
                    <button class="btn btn-sm btn-danger" onclick="deleteBlog(${data.id})">Delete</button>
                </div>
            </div>
        `;
    }
}

// Delete a blog from the database and UI
function deleteBlog(id) {
    if (confirm("Are you sure you want to delete this blog?")) {
        fetch(`delete.php?id=${id}`)
            .then(response => response.json())
            .then(data => {
                showMessage(data.message, "error");
                document.getElementById(`blog-${id}`).remove(); // Remove deleted blog from UI
            });
    }
}

// Show messages
function showMessage(message, type) {
    let messageBox = document.getElementById("messageBox");
    messageBox.innerHTML = `<p class="alert ${type === 'success' ? 'alert-success' : 'alert-danger'} text-center fw-bold">${message}</p>`;
    setTimeout(() => messageBox.innerHTML = "", 3000);
}

    </script>
</body>
</html>
