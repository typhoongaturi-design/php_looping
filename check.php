<?php
include 'config.php';
mysqli_report(MYSQLI_REPORT_OFF);
$r=$conn->query("SHOW COLUMNS FROM books");
echo "<h2>Your books table columns:</h2>";
while($row=$r->fetch_assoc()){ echo $row['Field']."<br>"; }
?>