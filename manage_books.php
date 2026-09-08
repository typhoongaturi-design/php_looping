<?php
session_start();
include 'config.php';

if(!isset($_SESSION['user_id'])){
    header("Location: index.php");
    exit();
}

// Delete book
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM books WHERE id='$id'");
    header("Location: manage_books.php");
}

// Get all books
$result = mysqli_query($conn, "SELECT * FROM books ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
<title>Manage Books - Admin</title>
<style>
body{background:#000;color:#FFD700;margin:0;font-family:Arial}
.sidebar{width:250px;background:#0a0a0a;height:100vh;position:fixed;left:0;top:0;padding:20px;border-right:2px solid #FFD700}
.sidebar h2{text-align:center;margin-bottom:30px}
.sidebar a{display:block;padding:10px 15px;margin:8px 0;background:#111;color:#FFD700;text-decoration:none;border:1px solid #FFD700;border-radius:6px;text-align:center}
.sidebar a:hover{background:#FFD700;color:#000}
.main{margin-left:270px;padding:30px}
h1{margin-bottom:20px}
.btn{background:#FFD700;color:#000;padding:10px 15px;text-decoration:none;border-radius:5px;font-weight:bold;margin-right:10px;display:inline-block}
table{width:100%;background:#0a0a0a;border:1px solid #FFD700;border-collapse:collapse;margin-top:20px}
th,td{padding:12px;border:1px solid #FFD700;text-align:left}
th{background:#111}
a.del{color:red}
a.edit{color:#00FF00}
</style>
</head>
<body>
<div class="sidebar">
<h2>LifeCourse</h2>
<a href="admin_dashboard.php">Dashboard</a>
<a href="manage_users.php">Manage Users</a>
<a href="add_book.php">Add New Book</a>
<a href="manage_books.php">Manage Books</a>
<a href="category.php">Manage Categories</a>
<a href="change_password.php">Change Password</a>
<a href="logout.php" style="color:red">Logout</a>
</div>

<div class="main">
<h1>📚 Manage Books</h1>
<a href="add_book.php" class="btn">+ Add New Book</a>

<table>
<tr>
    <th>ID</th>
    <th>Title</th>
    <th>Author</th>
    <th>Category</th>
    <th>Action</th>
</tr>
<?php while($row = mysqli_fetch_assoc($result)){ ?>
<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['title'] ?? $row['book_name'] ?? $row['name'] ?? 'N/A'; ?></td>
    <td><?php echo $row['author'] ?? 'N/A'; ?></td>
    <td><?php echo $row['category'] ?? $row['cat'] ?? 'N/A'; ?></td>
    <td>
        <a href="edit_book.php?id=<?php echo $row['id']; ?>" class="edit">Edit</a> | 
        <a href="manage_books.php?delete=<?php echo $row['id']; ?>" class="del" onclick="return confirm('Delete?')">Delete</a>
    </td>
</tr>
<?php } ?>
</table>
</div>
</body>
</html>