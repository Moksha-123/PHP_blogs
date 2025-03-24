<?php
class Database {
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $database = "php-test2";
    private $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->database);
        if ($this->conn->connect_error) {
            die("Database connection failed: " . $this->conn->connect_error);
        }
    }

    public function addBlog($blogname, $authorname, $body) {
        $stmt = $this->conn->prepare("INSERT INTO blogs (blog_name, author_name, body) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $blogname, $authorname, $body);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function getBlogs() {
        $sql = "SELECT * FROM blogs ORDER BY id DESC";
        return $this->conn->query($sql);
    }

    public function getBlogById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM blogs WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_assoc();
    }

    public function updateBlog($id, $blogname, $authorname, $body) {
        $stmt = $this->conn->prepare("UPDATE blogs SET blog_name=?, author_name=?, body=? WHERE id=?");
        $stmt->bind_param("sssi", $blogname, $authorname, $body, $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function deleteBlog($id) {
        $stmt = $this->conn->prepare("DELETE FROM blogs WHERE id=?");
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
}
?>
