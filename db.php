<?php
$host = "localhost";
$user = "root";
$pass = ""; // leave blank
$db   = "lifecourse_library"; // <-- THIS WAS THE PROBLEM

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}
?>