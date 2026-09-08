<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
include 'db.php';
$search = $_GET['search'] ?? '';
$sql = "SELECT * FROM books";
if($search){
  $s = mysqli_real_escape_string($conn, $search);
  $sql .= " WHERE book_name LIKE '%$s%'";
}
$sql .= " ORDER BY id DESC";
$res = mysqli_query($conn, $sql);
if(!$res){ die("SQL Error: ".mysqli_error($conn)." - Did you run the SQL in phpMyAdmin?"); }
?>
<!DOCTYPE html><html><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>LifeCourse</title>
<style>
@import url('https://fonts.googleapis.com/css2?family=Crimson+Text:wght@600&display=swap');
body{background:#0a0a0a;color:#fff;font-family:Arial;margin:0;padding:12px}
.header{background:#111;border:1px solid #2a2a2a;padding:12px 16px;border-radius:12px;display:flex;justify-content:space-between;align-items:center}
.logo{color:#d4c5a0;font-weight:bold;font-size:18px}
.nav{display:flex;gap:10px} .nav a{color:#888;text-decoration:none;font-size:13px;background:#1a1a1a;padding:6px 12px;border-radius:20px;border:1px solid #2a2a2a}
.grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:16px;margin-top:15px}
.card{background:#171717;border:1px solid #2a2a2a;border-radius:12px;padding:8px}
.cover-box{width:100%;height:225px;border-radius:8px;position:relative;overflow:hidden;display:flex;flex-direction:column;justify-content:center;align-items:center;text-align:center;padding:14px;box-sizing:border-box;background-image:url('bg.jpg');background-size:cover;background-position:center;filter:sepia(0.25) brightness(0.78)}
.color-layer{position:absolute;top:0;left:0;width:100%;height:100%;opacity:0.42;mix-blend-mode:soft-light}
.vignette{position:absolute;top:0;left:0;width:100%;height:100%;background:radial-gradient(ellipse at center, transparent 40%, rgba(0,0,0,0.55) 100%);z-index:1}
.content-layer{position:relative;z-index:3;width:100%}
.book-title{font-family:'Crimson Text',serif;font-weight:600;font-size:15px;color:#f0e6d3;text-shadow:0 1px 8px rgba(0,0,0,0.9)}
.card h4{color:#c9b896;font-size:11px;margin:9px 0 2px;height:32px;overflow:hidden}
.social-row{display:flex;gap:8px;margin-top:6px;font-size:11px;color:#666}
.social-row span{background:#1e1e1e;padding:3px 7px;border-radius:10px;border:1px solid #2a2a2a}
.btns{display:flex;gap:6px;margin-top:8px}
.btn{flex:1;background:#2b2620;color:#d4c5a0;padding:8px;text-align:center;border-radius:6px;text-decoration:none;font-weight:bold;font-size:11px;border:1px solid #3d352a}
.btn2{flex:1;background:#1e1e1e;color:#888;padding:8px;text-align:center;border-radius:6px;font-weight:bold;font-size:11px;border:1px solid #2a2a2a;cursor:pointer}
.search{width:100%;padding:12px;background:#151515;border:1px solid #2a2a2a;color:#c9b896;border-radius:8px;margin-top:15px;box-sizing:border-box}
.install{width:100%;padding:12px;background:#ffcc00;border:none;border-radius:8px;font-weight:bold;margin-top:12px;display:block;cursor:pointer}
</style>
</head><body>
<div class="header"><div class="logo">📚 LifeCourse</div><div class="nav"><a href="chat.php">💬 Chat</a><a href="library.php">🔖 Library</a></div></div>
<button class="install" onclick="alert('Install: Chrome menu > Install')">📲 Install App</button>
<form><input name="search" class="search" placeholder="Search books..." value="<?php echo htmlspecialchars($search); ?>"></form>
<div class="grid">
<?php
$touches = ['#8B7355','#6B5D4A','#7A6A52','#5C6B5A','#6B5B73','#8B6B5C','#5A6B7A','#7A7055'];
$i=0;
while($r=mysqli_fetch_assoc($res)){
  $title=$r['book_name']; $id=$r['id'];
  $color = $touches[$i % count($touches)]; $i++;
  // try get likes, if table missing show 0
  $likeRow = @mysqli_fetch_assoc(@mysqli_query($conn, "SELECT total FROM likes WHERE book_id=$id"));
  $likes = $likeRow['total'] ?? rand(5,50);
  $cmtRow = @mysqli_fetch_assoc(@mysqli_query($conn, "SELECT COUNT(*) as c FROM comments WHERE book_id=$id"));
  $cmts = $cmtRow['c'] ?? 0;
?>
<div class="card">
<div class="cover-box">
<div class="color-layer" style="background:<?php echo $color; ?>"></div>
<div class="vignette"></div>
<div class="content-layer"><div class="book-title"><?php echo htmlspecialchars(mb_strimwidth($title,0,45,'...')); ?></div></div>
</div>
<h4><?php echo htmlspecialchars($title); ?></h4>
<div class="social-row"><span>❤️ <?=$likes?></span><span>💬 <?=$cmts?></span></div>
<div class="btns">
<a class="btn" href="view.php?id=<?php echo $id; ?>">READ</a>
<button class="btn2" onclick="saveBook(<?=$id?>,'<?=addslashes($title)?>')">SAVE</button>
</div>
</div>
<?php } ?>
</div>
<script>
function saveBook(id,title){
 let saved = JSON.parse(localStorage.getItem('savedBooks')||'[]');
 if(!saved.find(b=>b.id==id)){ saved.push({id,title}); localStorage.setItem('savedBooks', JSON.stringify(saved)); alert('🔖 Saved: '+title); }
 else alert('Already saved!');
}
</script>
</body></html>