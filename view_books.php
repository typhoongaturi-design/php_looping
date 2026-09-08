<?php 
session_start();
include 'config.php'; 

// DELETE BOOK
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $conn->query("DELETE FROM books WHERE id=$id");
    header("Location: view_books.php?msg=deleted");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin - All Books</title>
    <style>
        body{background:#000;color:gold;font-family:Arial;padding:20px}
        h2{text-align:center}
        .book{border:2px solid gold;padding:15px;margin:15px;border-radius:10px;background:#111;overflow:auto}
        .book img{
            width:120px;
            height:160px;
            object-fit:cover; 
            float:left;
            margin-right:15px;
            border:1px solid gold;
            border-radius:5px;
        }
        a{color:gold;text-decoration:none;font-weight:bold}
        .btn{display:inline-block;margin:5px;padding:8px 15px;border-radius:5px;font-weight:bold}
        .download{background:gold;color:#000}
        .read{background:#333;color:gold;border:1px solid gold}
        .edit{background:orange;color:#000}
        .delete{background:red;color:#fff}
        p{word-wrap: break-word;} /* FIXES THE higgggggg problem */
    </style>
</head>
<body>
<h2>📚 Admin - Manage Books</h2>
<a href="admin_dashboard.php">← Back to Dashboard</a> | 
<a href="add_book.php">+ Add New Book</a>

<hr style="border-color:gold">

<?php
$result = $conn->query("SELECT * FROM books ORDER BY id DESC");
while($row = $result->fetch_assoc()){
    echo "<div class='book'>";
    echo "<img src='uploads/".$row['cover']."'>";
    echo "<h3>".$row['book_title']."</h3>";
    echo "<p><b>Author:</b> ".$row['author']."</p>";
    echo "<p><b>Description:</b> ".$row['description']."</p>";
    echo "<div>";
    echo "<a class='btn download' href='uploads/".$row['file']."' download>📥 Download</a>";
    echo "<a class='btn read' href='uploads/".$row['file']."' target='_blank'>📖 Read Online</a>";
    echo "<a class='btn edit' href='edit_book.php?id=".$row['id']."'>✏️ Edit</a>";
    echo "<a class='btn delete' href='view_books.php?delete=".$row['id']."' onclick=\"return confirm('Delete this book?')\">🗑️ Delete</a>";
    echo "</div>";
    echo "</div>";
}
$conn->close();
?>
</body>
</html>