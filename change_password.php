<?php
session_start();
include 'config.php'; // Changed from db.php to config.php

if(!isset($_SESSION['user_id'])){
    header("Location: index.php");
    exit();
}

$msg = "";
if(isset($_POST['change'])){
    $old = $_POST['old_pass'];
    $new = $_POST['new_pass'];
    $confirm = $_POST['confirm_pass'];
    
    $user_id = $_SESSION['user_id'];
    $result = mysqli_query($conn, "SELECT password FROM users WHERE id='$user_id'");
    
    if($result && mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        
        if($old == $row['password']){
            if($new == $confirm){
                mysqli_query($conn, "UPDATE users SET password='$new' WHERE id='$user_id'");
                $msg = "Password Changed Successfully!";
            }else{
                $msg = "New Password and Confirm Password do not match!";
            }
        }else{
            $msg = "Old Password is Incorrect!";
        }
    }else{
        $msg = "User not found!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Change Password - Admin</title>
<style>
body{background:#000;color:#FFD700;margin:0;font-family:Arial}
.sidebar{width:250px;background:#0a0a0a;height:100vh;position:fixed;left:0;top:0;padding:20px;border-right:2px solid #FFD700}
.sidebar h2{text-align:center;margin-bottom:30px}
.sidebar a{display:block;padding:10px 15px;margin:8px 0;background:#111;color:#FFD700;text-decoration:none;border:1px solid #FFD700;border-radius:6px;text-align:center}
.main{margin-left:270px;padding:30px}
.box{background:#0a0a0a;padding:25px;border:2px solid #FFD700;border-radius:8px;width:400px}
input{width:100%;padding:10px;margin:8px 0;background:#111;border:1px solid #FFD700;color:#FFD700;border-radius:5px}
button{padding:10px 20px;background:#FFD700;color:#000;border:none;border-radius:5px;cursor:pointer;font-weight:bold}
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
<a href="logout.php" style="color:red">Logout</a>
</div>

<div class="main">
<h1>Change Password</h1>
<div class="box">
<form method="POST">
<label>Old Password</label>
<input type="password" name="old_pass" required>
<label>New Password</label>
<input type="password" name="new_pass" required>
<label>Confirm New Password</label>
<input type="password" name="confirm_pass" required>
<button type="submit" name="change">Change Password</button>
</form>
<p class="msg"><?php echo $msg; ?></p>
</div>
</div>
</body>
</html>