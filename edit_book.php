<?php
error_reporting(0);
session_start();
include 'config.php';
if(!isset($_SESSION['admin_id'])){ header("Location: admin_login.php"); exit(); }

$id = intval($_GET['id']);
$book = $conn->query("SELECT * FROM books WHERE id=$id")->fetch_assoc();

if(isset($_POST['update'])){
  $title = $conn->real_escape_string($_POST['title']);
  $pages = intval($_POST['pages']);
  $file_path = $conn->real_escape_string($_POST['file_path']);
  
  // update using actual column name that exists
  $conn->query("UPDATE books SET title='$title', pages=$pages, file_path='$file_path' WHERE id=$id");
  // try other column names too
  @$conn->query("UPDATE books SET book_title='$title' WHERE id=$id");
  @$conn->query("UPDATE books SET name='$title' WHERE id=$id");
  
  header("Location: admin_dashboard.php?tab=books");
  exit();
}

$bookTitle = $book['title'] ?? $book['book_title'] ?? $book['name'] ?? '';
$bookPages = $book['pages'] ?? 0;
$bookFile = $book['file_path'] ?? '';
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Book</title>
<style>
body{background:#000;color:#FFD700;font-family:Arial;padding:15px}
.box{border:2px solid #FFD700;border-radius:10px;padding:20px;background:#111;max-width:500px;margin:20px auto}
label{display:block;margin-top:14px}
input{width:100%;padding:11px;margin-top:6px;background:#000;border:1.5px solid #FFD700;color:#FFD700;border-radius:6px}
button{width:100%;padding:13px;margin-top:22px;background:#FFD700;color:#000;border:none;border-radius:6px;font-weight:bold;font-size:16px}
a{color:#FFD700;text-decoration:none}
</style>
</head>
<body>
<h2>✏️ Edit Book</h2>
<a href="admin_dashboard.php?tab=books">← Back to Dashboard</a>
<div class="box">
<form method="POST">
<label>Book Title:</label>
<input type="text" name="title" value="<?php echo htmlspecialchars($bookTitle); ?>" required>

<label>Pages:</label>
<input type="number" name="pages" value="<?php echo $bookPages; ?>">

<label>File Path:</label>
<input type="text" name="file_path" value="<?php echo htmlspecialchars($bookFile); ?>" required>

<button type="submit" name="update">💾 Update Book</button>
</form>
</div>
</body>
</html>