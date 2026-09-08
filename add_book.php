<?php
session_start();
include 'config.php';
if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

if(isset($_POST['add_book'])){
    $name = $_POST['book_name'];
    $author = $_POST['book_author'];
    $category = $_POST['book_category'];
    $pages = $_POST['pages'];
    $desc = $_POST['description'];
    $pdf = $_FILES['pdf_file']['name'];
    $cover = $_FILES['cover_image']['name'];
    
    move_uploaded_file($_FILES['pdf_file']['tmp_name'], "uploads/pdfs/".$pdf);
    move_uploaded_file($_FILES['cover_image']['tmp_name'], "uploads/covers/".$cover);
    
    $conn->query("INSERT INTO books (book_name, book_author, book_category, pages, description, pdf_file, cover_image) VALUES ('$name','$author','$category','$pages','$desc','$pdf','$cover')");
    
    header("Location: admin_dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Book</title>
<style>
body{background:#000;color:#FFD700;font-family:Arial;padding:15px}
form{background:#111;border:2px solid #FFD700;padding:20px;border-radius:10px;max-width:500px;margin:auto}
input,select,textarea{width:100%;padding:10px;margin:7px 0;background:#000;border:1px solid #FFD700;color:#FFD700;border-radius:5px;box-sizing:border-box}
button{width:100%;padding:12px;background:#FFD700;color:#000;font-weight:bold;border:none;border-radius:6px}
a{color:#FFD700}
</style>
</head>
<body>
<h2 style="text-align:center">Add New Book</h2>
<form method="POST" enctype="multipart/form-data">
<input type="text" name="book_name" placeholder="Book Name" required>
<input type="text" name="book_author" placeholder="Author" required>
<select name="book_category" required>
<option value="">Select Category</option>
<option value="Life Course">Life Course</option>
<option value="Biography">Biography</option>
<option value="Self Help">Self Help</option>
<option value="Education">Education</option>
<option value="Fiction">Fiction</option>
</select>
<input type="number" name="pages" placeholder="Total Pages" required>
<textarea name="description" placeholder="Description" rows="3"></textarea>
<label>PDF File:</label>
<input type="file" name="pdf_file" accept=".pdf" required>
<label>Cover Image:</label>
<input type="file" name="cover_image" accept="image/*" required>
<button type="submit" name="add_book">Add Book</button>
<br><br>
<a href="admin_dashboard.php">← Back to Dashboard</a>
</form>
</body>
</html>