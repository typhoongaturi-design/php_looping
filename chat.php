<?php
error_reporting(0);
include 'db.php';
if(isset($_POST['message']) && trim($_POST['message'])!=''){
 $u = mysqli_real_escape_string($conn, substr($_POST['username']??'Anonymous',0,30));
 if(trim($u)=='') $u='Anonymous';
 $m = mysqli_real_escape_string($conn, $_POST['message']);
 mysqli_query($conn, "INSERT INTO chat (username,message) VALUES ('$u','$m')");
 header("Location: chat.php"); exit;
}
$msgs = mysqli_query($conn, "SELECT * FROM chat ORDER BY id DESC LIMIT 100");
?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
<title>Reader Chat</title>
<style>
*{box-sizing:border-box}
body{margin:0;background:#0a0a0a;color:#fff;font-family:Arial;display:flex;flex-direction:column;height:100dvh}
.top{background:#111;padding:12px 15px;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid #222;flex-wrap:wrap;gap:8px}
.top a{color:#d4c5a0;text-decoration:none;font-weight:bold;font-size:14px}
.top div{font-size:14px}
.chat{flex:1;overflow-y:auto;padding:12px;display:flex;flex-direction:column-reverse;gap:8px}
.msg{background:#1a1a1a;padding:10px 12px;border-radius:15px;max-width:85%;border:1px solid #2a2a2a;word-wrap:break-word}
.msg b{color:#c9b896;font-size:11px;display:block;margin-bottom:3px}
.msg p{margin:0;font-size:14px;line-height:1.3}
.msg small{color:#555;font-size:10px}
.box{padding:10px;background:#111;border-top:1px solid #222;display:flex;gap:8px;position:sticky;bottom:0}
.box input{padding:12px;background:#1e1e1e;border:1px solid #333;color:#fff;border-radius:25px;font-size:14px}
.box input[name=username]{width:80px;flex-shrink:0}
.box input[name=message]{flex:1}
.box button{background:#d4c5a0;color:#000;border:none;padding:12px 18px;border-radius:25px;font-weight:bold;cursor:pointer;flex-shrink:0}
.online{color:#4caf50;font-size:11px}
@media(max-width:600px){.msg{max-width:92%} .box input[name=username]{display:none}}
</style>
</head><body>
<div class="top"><a href="index2.php">← Books</a><div>🌍 Lounge <span class="online">● <?=rand(12,89)?> online</span></div><a href="library.php">🔖</a></div>
<div class="chat">
<?php while($m=mysqli_fetch_assoc($msgs)):?>
<div class="msg"><b><?=htmlspecialchars($m['username'])?></b><p><?=htmlspecialchars($m['message'])?></p><small><?=$m['created_at']?></small></div>
<?php endwhile;?>
</div>
<form method="POST" class="box">
<input name="username" placeholder="Name">
<input name="message" placeholder="Type message... 💬" required autocomplete="off">
<button>Send</button>
</form>
</body></html>