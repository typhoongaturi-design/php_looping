<?php
include 'db.php';
if(!is_dir('covers')) mkdir('covers');
$res = mysqli_query($conn, "SELECT * FROM books");
$colors = [
  ['#FF6B6B','#FF8E53'], ['#4ECDC4','#556270'], ['#C06C84','#6C5B7B'],
  ['#2C3E50','#4CA1AF'], ['#F7971E','#FFD200'], ['#834D9B','#D04ED6'],
  ['#1D976C','#93F9B9'], ['#EB3349','#F45C43'], ['#000428','#004e92']
];
while($row = mysqli_fetch_assoc($res)){
  $raw = $row['cover_image']?? '';
  $path = 'covers/'.$raw;
  if($raw && file_exists($path)) continue; // already exists
  if(!$raw) continue;
  // Create image
  $w=400; $h=600;
  $img = imagecreatetruecolor($w,$h);
  $c = $colors[array_rand($colors)];
  $c1 = hex2rgb($c[0]); $c2 = hex2rgb($c[1]);
  // gradient
  for($y=0;$y<$h;$y++){
    $r = $c1[0] + ($c2[0]-$c1[0])*$y/$h;
    $g = $c1[1] + ($c2[1]-$c1[1])*$y/$h;
    $b = $c1[2] + ($c2[2]-$c1[2])*$y/$h;
    $col = imagecolorallocate($img,$r,$g,$b);
    imageline($img,0,$y,$w,$y,$col);
  }
  $white = imagecolorallocate($img,255,255,255);
  $black = imagecolorallocate($img,0,0,0);
  // Add text - book name
  $title = $row['book_name'];
  $title = wordwrap($title, 20, "\n");
  $lines = explode("\n",$title);
  $font = 5;
  $y = 200;
  foreach($lines as $line){
    $textWidth = imagefontwidth($font)*strlen($line);
    $x = ($w - $textWidth)/2;
    imagestring($img, $font, $x, $y, $line, $white);
    $y+=30;
  }
  imagejpeg($img, $path, 90);
  imagedestroy($img);
  echo "Created $path<br>";
}
function hex2rgb($hex){
  $hex = ltrim($hex,'#');
  return [hexdec(substr($hex,0,2)), hexdec(substr($hex,2,2)), hexdec(substr($hex,4,2))];
}
echo "<h2>DONE! All covers created! Now go to index2.php</h2>";
?>