<?php
include 'db.php';
$id = intval($_GET['id'] ?? 0);
mysqli_query($conn, "INSERT INTO likes (book_id,total) VALUES ($id,1) ON DUPLICATE KEY UPDATE total=total+1");
$row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT total FROM likes WHERE book_id=$id"));
echo $row['total'];