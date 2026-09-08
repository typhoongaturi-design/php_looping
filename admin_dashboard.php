<?php
session_start();
error_reporting(0);
include 'db.php';

// ADD BOOK
if(isset($_POST['add_book'])){
 $name = mysqli_real_escape_string($conn, trim($_POST['book_name'] ?? ''));
 $author = mysqli_real_escape_string($conn, trim($_POST['author'] ?? ''));
 $fileName = '';
 
 if(isset($_FILES['pdf']) && $_FILES['pdf']['error']==0 && $_FILES['pdf']['name']!=''){
   $ext = pathinfo($_FILES['pdf']['name'], PATHINFO_EXTENSION);
   $fileName = time().'_'.preg_replace('/[^a-zA-Z0-9._-]/','_', $_FILES['pdf']['name']);
   if(!is_dir('books')) mkdir('books',0777,true);
   move_uploaded_file($_FILES['pdf']['tmp_name'], 'books/'.$fileName);
 }
 
 if($name!=''){
   mysqli_query($conn,"INSERT INTO books (book_name, author, pdf_file) VALUES ('$name','$author','$fileName')");
   $newId = mysqli_insert_id($conn);
   @mysqli_query($conn,"INSERT IGNORE INTO likes (book_id,total) VALUES ($newId, 0)");
   $msg = "✅ Book added!";
 } else {
   $msg = "❌ Add book name";
 }
}

// DELETE BOOK
if(isset($_GET['del'])){
 $id=intval($_GET['del']);
 mysqli_query($conn,"DELETE FROM books WHERE id=$id");
 @mysqli_query($conn,"DELETE FROM likes WHERE book_id=$id");
 @mysqli_query($conn,"DELETE FROM comments WHERE book_id=$id");
 header("Location: admin_dashboard.php"); exit;
}

$total = @mysqli_fetch_assoc(@mysqli_query($conn,"SELECT COUNT(*) as c FROM books"))['c'] ?? 0;
$totalUsers = @mysqli_fetch_assoc(@mysqli_query($conn,"SELECT COUNT(*) as c FROM users"))['c'] ?? 12;
$totalComments = @mysqli_fetch_assoc(@mysqli_query($conn,"SELECT COUNT(*) as c FROM comments"))['c'] ?? 0;
$books = @mysqli_query($conn,"SELECT * FROM books ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>LifeCourse Admin</title>
<style>
*{box-sizing:border-box}
body{margin:0;background:#0a0a0a;color:#fff;font-family:Arial;display:flex;min-height:100vh}
.sidebar{width:240px;background:#111;border-right:1px solid #222;padding:20px;flex-shrink:0;position:sticky;top:0;height:100vh;overflow-y:auto}
.sidebar h2{color:#ffcc00;font-size:14px;margin:0;line-height:1.2;letter-spacing:1px}
.sidebar small{color:#666;font-size:10px;letter-spacing:1px}
.menu{margin-top:25px;display:flex;flex-direction:column;gap:8px}
.menu a{padding:12px 14px;background:#1a1a1a;border:1px solid #2a2a2a;border-radius:8px;color:#999;text-decoration:none;font-size:13px;display:block;transition:0.2s}
.menu a:hover{border-color:#ffcc00;color:#ffcc00}
.menu a.active{background:#ffcc00;color:#000;font-weight:bold;border-color:#ffcc00}
.main{flex:1;padding:20px;overflow-y:auto}
.stats{display:flex;gap:12px;flex-wrap:wrap;margin-bottom:20px}
.stat{background:#1a1a1a;border:1px solid #2a2a2a;padding:18px 20px;border-radius:12px;min-width:160px;flex:1}
.stat span{color:#666;font-size:11px;text-transform:uppercase;letter-spacing:1px;display:block;margin-bottom:6px}
.stat b{font-size:32px;color:#ffcc00;display:block}
.form-box{background:#151515;border:1px solid #2a2a2a;padding:20px;border-radius:12px;margin-top:20px;max-width:520px}
.form-box h3{margin-top:0;color:#d4c5a0;font-size:14px;letter-spacing:1px}
.form-box input{width:100%;padding:12px;background:#0f0f0f;border:1px solid #333;color:#fff;border-radius:8px;margin-bottom:12px;font-size:14px}
.form-box button{width:100%;padding:13px;background:#ffcc00;border:none;border-radius:8px;font-weight:bold;cursor:pointer;font-size:14px}
.msg{padding:10px;border-radius:8px;margin-bottom:12px;font-size:13px}
.msg.ok{background:#112211;border:1px solid #2a5a2a;color:#7f7}
.msg.err{background:#221111;border:1px solid #5a2a2a;color:#f77}
.book-list{margin-top:25px}
.book-item{background:#171717;border:1px solid #2a2a2a;padding:12px 14px;border-radius:10px;display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;gap:10px}
.book-item b{color:#c9b896;font-size:13px}
.book-item small{color:#666;font-size:11px;word-break:break-all}
.book-item .actions{display:flex;gap:8px;flex-shrink:0}
.btn-view{padding:6px 10px;background:#2b2620;color:#d4c5a0;border-radius:6px;text-decoration:none;font-size:11px;border:1px solid #3d352a}
.btn-del{padding:6px 10px;background:#2a1515;color:#ff7777;border-radius:6px;text-decoration:none;font-size:11px;border:1px solid #4a2a2a}
@media(max-width:700px){
 body{flex-direction:column}
 .sidebar{width:100%;height:auto;position:relative;padding:15px}
 .menu{flex-direction:row;flex-wrap:wrap}
 .menu a{flex:1;min-width:110px;text-align:center;padding:10px 8px;font-size:12px}
 .main{padding:12px}
 .stats{flex-direction:column}
}
</style>
</head>
<body>

<div class="sidebar">
<h2>LIFECOURSE LIBRARY<br>COMMAND</h2>
<small>ULTIMATE CONTROL PANEL</small>
<div class="menu">
<a class="active" href="admin_dashboard.php">📊 Dashboard</a>
<a href="#add">➕ Add New Book</a>
<a href="#manage">📚 Manage Books (<?=$total?>)</a>
<a href="index2.php" target="_blank">🌐 View Site</a>
<a href="chat.php" target="_blank">💬 View Chat</a>
<a href="logout.php">🚪 Logout</a>
</div>
</div>

<div class="main">

<div class="stats">
<div class="stat"><span>Total Books</span><b><?=$total?></b></div>
<div class="stat"><span>Total Users</span><b><?=$totalUsers?></b></div>
<div class="stat"><span>Comments</span><b><?=$totalComments?></b></div>
</div>

<?php if(isset($msg)):?><div class="msg <?=strpos($msg,'✅')!==false?'ok':'err'?>"><?=$msg?></div><?php endif;?>

<div id="add" class="form-box">
<h3>ADD NEW BOOK - NO CATEGORY</h3>
<form method="POST" enctype="multipart/form-data">
<input name="book_name" placeholder="Book Name - e.g. Single Dating Engaged Married" required>
<input name="author" placeholder="Author - e.g. Ben Stuart" required>
<label style="font-size:11px;color:#888;display:block;margin-bottom:6px">PDF File (put in /books/ folder):</label>
<input type="file" name="pdf" accept=".pdf">
<button name="add_book" type="submit">📚 Add Book to Library</button>
</form>
<small style="color:#666;font-size:11px;display:block;margin-top:10px">Tip: PDF will be saved to /books/ folder. Make sure folder exists.</small>
</div>

<div id="manage" class="book-list">
<h3 style="color:#d4c5a0">📚 Manage Books - <?=$total?> Books</h3>
<?php 
if($books){
 while($b=@mysqli_fetch_assoc($books)):
  $bname = $b['book_name'] ?? $b['title'] ?? 'Untitled';
?>
<div class="book-item">
<div style="flex:1;min-width:0">
<b><?=htmlspecialchars($bname)?></b><br>
<small><?=htmlspecialchars($b['author'] ?? 'Unknown')?> | <?=htmlspecialchars($b['pdf_file'] ?? 'no file')?></small>
</div>
<div class="actions">
<a class="btn-view" href="view.php?id=<?=$b['id']?>" target="_blank">View</a>
<a class="btn-del" href="?del=<?=$b['id']?>" onclick="return confirm('Delete <?=$bname?>?')">Delete</a>
</div>
</div>
<?php endwhile; } else echo "<p style='color:#666'>No books yet or DB error</p>"; ?>
</div>

</div>
</body>
</html>