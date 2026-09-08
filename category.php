<?php
session_start();
include 'config.php';

if(!isset($_SESSION['user_id'])){
    header("Location: index.php");
    exit();
}

$msg = "";

// Add Category
if(isset($_POST['add'])){
    $cat_name = $_POST['cat_name'];
    if(!empty($cat_name)){
        mysqli_query($conn, "INSERT INTO categories (name) VALUES ('$cat_name')");
        $msg = "Category Added!";
    }
}

// Delete Category
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM categories WHERE id='$id'");
    $msg = "Category Deleted!";
}

$result = mysqli_query($conn, "SELECT * FROM categories ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
<title>Manage Categories - Admin</title>
<style>
body{background:#000;color:#FFD700;margin:0;font-family:Arial}
.sidebar{width:250px;background:#0a0a0a;height:100vh;position:fixed;left:0;top:0;padding:20px;border-right:2px solid #FFD700}
.sidebar h2{text-align:center;margin-bottom:30px;text-shadow:0 0 10px #FFD700}
.sidebar a{display:block;padding:10px 15px;margin:8px 0;background:#111;color:#FFD700;text-decoration:none;border:1px solid #FFD700;border-radius:6px;text-align:center;transition:0.3s}
.sidebar a:hover{background:#FFD700;color:#000}
.sidebar a.logout{color:red;border-color:red}
.main{margin-left:270px;padding:30px}
h1{margin-bottom:20px;text-shadow:0 0 10px #FFD700}
.box{background:#0a0a0a;padding:20px;border:1px solid #FFD700;border-radius:8px;margin-bottom:20px}
input{padding:10px;background:#111;border:1px solid #FFD700;color:#FFD700;border-radius:5px}
button{padding:10px 20px;background:#FFD700;color:#000;border:none;border-radius:5px;cursor:pointer;font-weight:bold}
button:hover{box-shadow:0 0 10px #FFD700}
table{width:100%;background:#0a0a0a;border:1px solid #FFD700;border-collapse:collapse;margin-top:20px}
th,td{padding:12px;border:1px solid #FFD700;text-align:left}
th{background:#111}
a.del{color:red;text-decoration:none}
.msg{color:#00FF00;margin:10px 0}
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
<a href="logout.php" class="logout">Logout</a>
</div>

<div class="main">
<h1>Manage Categories</h1>

<div class="box">
<form method="POST">
<input type="text" name="cat_name" placeholder="New Category Name" required>
<button name="add">Add Category</button>
</form>
<p class="msg"><?php echo $msg; ?></p>
</div>

<table>
<tr>
    <th>ID</th>
    <th>Category Name</th>
    <th>Action</th>
</tr>
<?php while($row = mysqli_fetch_assoc($result)){ ?>
<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['name']; ?></td>
    <td><a href="category.php?delete=<?php echo $row['id']; ?>" class="del" onclick="return confirm('Delete this category?')">Delete</a></td>
</tr>
<?php } ?>
</table>

</div>
</body>
</html>