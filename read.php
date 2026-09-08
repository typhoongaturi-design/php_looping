<?php
include 'config.php';
$id = intval($_GET['id']);
$row = $conn->query("SELECT * FROM books WHERE id=$id")->fetch_assoc();
if(!$row) die("Book not found");
$file = "pdfs/".$row['pdf_file'];
if(!file_exists($file)) die("PDF missing: ".$row['pdf_file']." not in pdfs folder");
?>
<!DOCTYPE html><html><head><title><?php echo $row['book_name']; ?></title></head>
<body style="margin:0">
<iframe src="<?php echo $file; ?>" width="100%" height="100%" style="height:100vh;border:none"></iframe>
</body></html>