<?php
include 'config.php';
echo "<h2>Fixing Titles...</h2>";
$q=$conn->query("SELECT id, pdf_file, book_name FROM books");
while($r=$q->fetch_assoc()){
  $id=$r['id'];
  $pdf=$r['pdf_file'];
  // Create nice title from pdf file name
  $new_title = pathinfo($pdf, PATHINFO_FILENAME);
  $new_title = str_replace(['_', '-', '  '], ' ', $new_title);
  // Remove numbers at start like 180617...
  $new_title = preg_replace('/^[0-9]+/', '', $new_title);
  $new_title = preg_replace('/\(PDFDrive\)|\(1\)|\(Z Library\)/i', '', $new_title);
  $new_title = trim($new_title);
  if(strlen($new_title) < 3) $new_title = "Book ".$id;
  // Limit to first 6 words for clean title
  $words = explode(" ", $new_title);
  $new_title = implode(" ", array_slice($words, 0, 6));
  $new_title = $conn->real_escape_string($new_title);
  
  $conn->query("UPDATE books SET book_name='$new_title' WHERE id=$id");
  echo "✅ ID $id -> $new_title<br>";
}
echo "<h1>DONE! <a href='index.php'>Go to Library - F5</a></h1>";
?>