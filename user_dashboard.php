<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: index.php");
    exit();
}
include 'db.php';

// Get stats
$total_books = $conn->query("SELECT COUNT(*) as total FROM books")->fetch_assoc()['total'];
$total_categories = $conn->query("SELECT COUNT(*) as total FROM categories")->fetch_assoc()['total'];
$total_users = $conn->query("SELECT COUNT(*) as total FROM users")->fetch_assoc()['total'];

// Get recent books
$books = $conn->query("SELECT b.*, c.category_name FROM books b LEFT JOIN categories c ON b.category_id = c.category_id ORDER BY b.book_id DESC LIMIT 5");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - LifeCourse</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <div class="sidebar">
        <h2>LifeCourse</h2>
        <a href="admin_dashboard.php" class="sidebar-btn active">Dashboard</a>
        <a href="manage_users.php" class="sidebar-btn">Manage Users</a>
        <a href="add_book.php" class="sidebar-btn">Add New Book</a>
        <a href="manage_books.php" class="sidebar-btn">Manage Books</a>
        <a href="logout.php" class="sidebar-btn">Logout</a>
    </div>

    <div class="main-content">
        <h1>Dashboard</h1>

        <div class="stats-grid">
            <div class="stats-card">
                <h3><?php echo $total_books; ?></h3>
                <p>Total Books</p>
            </div>
            <div class="stats-card">
                <h3><?php echo $total_categories; ?></h3>
                <p>Categories</p>
            </div>
            <div class="stats-card">
                <h3><?php echo $total_users; ?></h3>
                <p>Total Users</p>
            </div>
        </div>

        <div class="table-container">
            <h2>Recent Books</h2>
            <table>
                <tr>
                    <th>Book Title</th>
                    <th>Author</th>
                    <th>Category</th>
                </tr>
                <?php while($row = $books->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['author']; ?></td>
                    <td><?php echo $row['category_name']; ?></td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>

</body>
</html>