<?php
session_start();
$_SESSION['admin_id'] = 1;
$_SESSION['admin_name'] = 'admin';
echo "Admin logged in! Now go to admin.php";
header("Location: admin.php?tab=books");
?>