<?php
include 'config.php';
$id=intval($_GET['id']);
$row=$conn->query("SELECT * FROM books WHERE id=$id")->fetch_assoc();
if(!$row){ die("Book not found"); }

$pdf_file = $row['pdf_file'] ?? $row['book_file'] ?? '';
// Find file in possible folders
$possible_paths = [
  "pdfs/".$pdf_file,
  "books/".$pdf_file,
  $pdf_file,
  "../lifecourse/pdfs/".$pdf_file
];

$found_path = "";
foreach($possible_paths as $p){
  if(file_exists($p) && !empty($pdf_file)){
    $found_path = $p;
    break;
  }
}

if(empty($found_path)){
  die("File not found in server. Expected: pdfs/".$pdf_file);
}

// FIX FOR PHONE CHROME - Use inline instead of attachment for HTTP
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="'.basename($found_path).'"');
header('Content-Length: ' . filesize($found_path));
header('Cache-Control: public, must-revalidate, max-age=0');
header('Pragma: public');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');

readfile($found_path);
exit();
?>