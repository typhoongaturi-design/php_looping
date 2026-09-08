<?php
include 'config.php';
mysqli_report(MYSQLI_REPORT_OFF);

echo "<h2>Importing 54 PDFs...</h2>";
$files = glob('pdfs/*.pdf');
echo "Found ".count($files)." files<br><hr>";

$added=0;
foreach($files as $f){
  $pdf_file = basename($f);
  $book_name = pathinfo($pdf_file, PATHINFO_FILENAME);
  $book_name = str_replace(['_','-'], ' ', $book_name);
  $book_name = substr($book_name, 0, 100);
  $book_name_esc = $conn->real_escape_string($book_name);
  $pdf_esc = $conn->real_escape_string($pdf_file);

  // Skip if already exists
  $check = $conn->query("SELECT id FROM books WHERE pdf_file='$pdf_esc' LIMIT 1");
  if($check && $check->num_rows > 0){ echo "Skip exists: $pdf_file<br>"; continue; }

  $sql = "INSERT INTO books (book_name, book_author, book_category, pages, cover_image, pdf_file) 
          VALUES ('$book_name_esc', 'Unknown', 'Parenting', 100, 'default.jpg', '$pdf_esc')";

  if($conn->query($sql)){
    $added++;
    echo "✅ $book_name<br>";
  } else {
    echo "❌ $pdf_file : ".$conn->error."<br>";
  }
}
echo "<h1 style='color:green'>DONE! $added Books Added!</h1>";
echo "<a href='admin_dashboard.php'><h1>CLICK HERE -> Press F5 -> You will see 56 Books!</h1></a>";
?>