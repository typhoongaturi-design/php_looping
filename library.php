<?php include 'db.php'; ?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>My Library</title>
<style>body{background:#0a0a0a;color:#fff;font-family:Arial;padding:12px}
.top{display:flex;justify-content:space-between;margin-bottom:15px}
.top a{color:#d4c5a0;text-decoration:none;font-weight:bold}
.card{background:#171717;border:1px solid #2a2a2a;border-radius:10px;padding:12px;margin-bottom:10px;display:flex;justify-content:space-between;align-items:center}
.btn{background:#2b2620;color:#d4c5a0;padding:8px 12px;border-radius:6px;text-decoration:none;font-size:12px;border:1px solid #3d352a}
</style>
</head><body>
<div class="top"><a href="index2.php">← Back</a><b>🔖 My Library</b><a href="chat.php">💬 Chat</a></div>
<div id="lib"></div>
<script>
let saved = JSON.parse(localStorage.getItem('savedBooks')||'[]');
let box=document.getElementById('lib');
if(saved.length==0) box.innerHTML="<p style='color:#666;text-align:center;margin-top:50px'>No saved books yet<br>Go save some! 📚</p>";
else saved.forEach(b=>{
 box.innerHTML+=`<div class="card"><div><b style="color:#c9b896">${b.title}</b></div><a class="btn" href="view.php?id=${b.id}">Read</a></div>`;
});
</script>
</body></html>