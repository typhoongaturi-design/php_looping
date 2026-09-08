<?php
session_start();
if(isset($_SESSION['admin_id'])){
  header('Location: admin_dashboard.php?tab=dashboard');
  exit();
}

$error = '';
if(isset($_POST['login'])){
  $user = trim($_POST['username']);
  $pass = trim($_POST['password']);
  
  // Change these if you want - but admin/admin123 will work
  if($user === 'admin' && $pass === 'admin123'){
    $_SESSION['admin_id'] = 1;
    $_SESSION['admin_user'] = 'CEO';
    header('Location: admin_dashboard.php?tab=dashboard');
    exit();
  } else {
    $error = 'Wrong username or password! Use admin / admin123';
  }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin Login - Lifecourse</title>
<style>
*{box-sizing:border-box;margin:0;padding:0;font-family:Arial}
body{background:#070707;display:flex;justify-content:center;align-items:center;min-height:100vh;color:#fff}
.box{width:380px;background:#111;border:2px solid #FFD700;border-radius:16px;padding:28px;box-shadow:0 0 40px rgba(255,215,0,0.15)}
.box h2{color:#FFD700;margin-bottom:20px;text-align:center;letter-spacing:1px}
input{width:100%;padding:13px;background:#000;border:1px solid #333;color:#fff;border-radius:8px;margin-bottom:12px}
.btn{width:100%;padding:13px;background:#FFD700;color:#000;border:none;border-radius:8px;font-weight:900;cursor:pointer;font-size:15px}
.err{background:#1f0f0f;color:#ff5a5a;padding:10px;border-radius:8px;font-size:12px;margin-bottom:12px;border:1px solid #450a0a}
a{color:#666;font-size:12px;text-decoration:none;display:block;margin-top:14px;text-align:center}
a:hover{color:#FFD700}
</style>
</head>
<body>
<div class="box">
<h2>Admin Login</h2>
<?php if($error!=''){ echo '<div class="err">'.$error.'</div>'; } ?>
<form method="POST">
<input type="text" name="username" placeholder="Username (admin)" required value="admin">
<input type="password" name="password" placeholder="Password (admin123)" required value="admin123">
<button name="login" class="btn">LOGIN TO CEO DASHBOARD</button>
</form>
<a href="index.php">Back to Home</a>
<p style="font-size:10px;color:#444;margin-top:12px;text-align:center">If Chrome shows "password in breach" - click "Use password anyway" or change to admin@2026</p>
</div>
</body>
</html>