<?php error_reporting(0); include 'db.php'; $id=intval($_GET['id']??0);
if(isset($_POST['comment']) && trim($_POST['comment'])!=''){
 $u=mysqli_real_escape_string($conn, substr($_POST['username']??'Anonymous',0,30)); if(trim($u)=='')$u='Anonymous';
 $c=mysqli_real_escape_string($conn,$_POST['comment']);
 mysqli_query($conn,"INSERT INTO comments (book_id,username,comment) VALUES ($id,'$u','$c')");
 header("Location: view.php?id=$id"); exit;
}
$row=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM books WHERE id=$id"));
if(!$row) die("Book ID $id not found in DB");

$fileName = $row['pdf_file'] ?? $row['file'] ?? $row['book_file'] ?? '';
$fileName = trim($fileName);

// Try 10 places where PDF could be
$possible = [
 $fileName,
 "books/$fileName",
 "pdfs/$fileName",
 "uploads/$fileName",
 "files/$fileName",
 "C:/xampp/htdocs/lifecourse/books/$fileName",
 "C:/xampp/htdocs/lifecourse/$fileName"
];
$foundPath = null; $foundUrl = null;
foreach($possible as $p){
 if($p && file_exists($p)){
  $foundPath = $p;
  $foundUrl = str_replace("C:/xampp/htdocs/lifecourse/","",$p);
  break;
 }
}
$like=@mysqli_fetch_assoc(@mysqli_query($conn,"SELECT total FROM likes WHERE book_id=$id"))['total']??rand(5,50);
$comments=mysqli_query($conn,"SELECT * FROM comments WHERE book_id=$id ORDER BY id DESC");
$count=@mysqli_num_rows($comments)??0;
?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?=$row['book_name']?></title>
<style>
*{box-sizing:border-box} body{margin:0;background:#0a0a0a;color:#fff;font-family:Arial}
.top{background:#111;padding:12px 15px;display:flex;justify-content:space-between;align-items:center;position:sticky;top:0;z-index:10;border-bottom:1px solid #222}
.top a{color:#d4c5a0;text-decoration:none;font-weight:bold;font-size:14px}
.viewer{height:70vh;background:#000;position:relative;display:flex;align-items:center;justify-content:center}
.viewer iframe{width:100%;height:100%;border:none}
.read-options{background:#111;padding:12px;display:flex;gap:8px;flex-wrap:wrap;justify-content:center;border-bottom:1px solid #222}
.read-options a{padding:10px 18px;border-radius:25px;text-decoration:none;font-weight:bold;font-size:13px;border:1px solid #3d352a}
.btn-read{background:#d4c5a0;color:#000} .btn-download{background:#1e1e1e;color:#888}
.error-box{background:#1a0a0a;border:1px solid #442222;color:#ff8888;padding:20px;border-radius:10px;text-align:center;margin:20px}
.social{padding:15px;background:#121212;max-width:600px;margin:0 auto;width:100%}
.stats{display:flex;gap:10px;margin-bottom:15px} .stat{flex:1;background:#1a1a1a;border:1px solid #2a2a2a;padding:10px;border-radius:10px;text-align:center}
.stat b{color:#ffcc00;font-size:18px;display:block}
.likeBtn{width:100%;background:#2b2620;color:#d4c5a0;border:1px solid #3d352a;padding:14px;border-radius:30px;font-weight:bold;font-size:16px;cursor:pointer;margin-bottom:15px}
.input{width:100%;padding:12px;background:#0f0f0f;border:1px solid #333;color:#fff;border-radius:8px;margin-bottom:8px;font-size:14px}
.sendBtn{width:100%;background:#d4c5a0;color:#000;border:none;padding:12px;border-radius:8px;font-weight:bold;cursor:pointer}
.cmt{background:#1a1a1a;padding:10px;border-radius:10px;margin-bottom:8px;border-left:2px solid #3d352a}
@media(max-width:600px){.viewer{height:65vh}}
</style></head><body>
<div class="top"><a href="index2.php">← Back</a><span style="color:#888;font-size:12px;max-width:160px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis"><?=$row['book_name']?></span><a href="chat.php">💬</a></div>

<?php if($foundUrl): ?>
<div class="read-options">
<a class="btn-read" href="<?=$foundUrl?>" target="_blank">📖 Open Fullscreen</a>
<a class="btn-download" href="<?=$foundUrl?>" download>⬇️ Download PDF</a>
</div>
<div class="viewer"><iframe src="<?=$foundUrl?>#toolbar=0&view=FitH"></iframe></div>
<?php else: ?>
<div class="error-box">
<h3>⚠️ PDF not found!</h3>
<p>DB says file is: <b><?=$fileName?></b></p>
<p>But not in: books/ , pdfs/ , uploads/</p>
<p style="font-size:12px;color:#888">Go to C:\xampp\htdocs\lifecourse\ <br>Create folder <b>books</b> and put all PDFs there with same name as in DB</p>
</div>
<?php endif; ?>

<div class="social">
<div class="stats"><div class="stat"><b id="likeCount"><?=$like?></b><small>❤️ Likes</small></div><div class="stat"><b><?=$count?></b><small>💬</small></div><div class="stat"><b><?=rand(20,180)?></b><small>👁️</small></div></div>
<button class="likeBtn" onclick="fetch('like.php?id=<?=$id?>').then(r=>r.text()).then(n=>{document.getElementById('likeCount').innerText=n; this.innerText='❤️ Liked! '+n})">❤️ Like (<?=$like?>)</button>
<div style="background:#181818;border:1px solid #2a2a2a;border-radius:12px;padding:12px;margin-bottom:15px">
<form method="POST"><input name="username" class="input" placeholder="Your name"><textarea name="comment" class="input" rows="3" placeholder="Comment about this book..." required></textarea><button class="sendBtn">Post Comment</button></form>
</div>
<?php while($c=@mysqli_fetch_assoc($comments)):?><div class="cmt"><b><?=htmlspecialchars($c['username'])?></b><p><?=htmlspecialchars($c['comment'])?></p><small><?=$c['created_at']?></small></div><?php endwhile;?>
</div></body></html>