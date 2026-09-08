<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'config.php';

echo "<h2>Checking Tables</h2>";

// Check books
$r = $conn->query("SELECT * FROM books LIMIT 1");
if($r){
  echo "Books OK - Columns: ";
  print_r($r->fetch_assoc());
} else {
  echo "Books Error: " . $conn->error;
}

echo "<hr>";

// Check users
$r = $conn->query("SELECT * FROM users LIMIT 1");
if($r){
  echo "Users OK - Columns: ";
  print_r($r->fetch_assoc());
} else {
  echo "Users Error: " . $conn->error . "<br>";
  echo "Creating users table now...<br>";
  $conn->query("CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255),
    password VARCHAR(255),
    status VARCHAR(20) DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
  )");
  echo "Users table created! Now refresh admin_dashboard";
}

echo "<hr>";
echo "<h3>Total Users: ";
$c = $conn->query("SELECT COUNT(*) as c FROM users");
if($c) echo $c->fetch_assoc()['c'];
echo "</h3>";
?>
<br><br>
<a href="admin_dashboard.php?tab=users">Go to Users Tab</a>