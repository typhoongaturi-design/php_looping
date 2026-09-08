<?php
error_reporting(0);
session_start();
if(!isset($_SESSION['admin_id']) && !isset($_SESSION['admin'])){ header("Location: admin_login.php"); exit(); }
if(file_exists('config.php')) include 'config.php'; else include '../config.php';

if(isset($_GET['del_user'])){
  $id=intval($_GET['del_user']);
  $conn->query("DELETE FROM users WHERE id=$id");
  header("Location: manage_users.php"); exit();
}
if(isset($_GET['block'])){
  $id=intval($_GET['block']);
  $conn->query("UPDATE users SET status='blocked' WHERE id=$id");
  header("Location: manage_users.php"); exit();
}
if(isset($_GET['unblock'])){
  $id=intval($_GET['unblock']);
  $conn->query("UPDATE users SET status='active' WHERE id=$id");
  header("Location: manage_users.php"); exit();
}

$users=$conn->query("SELECT * FROM users ORDER BY id DESC");
?>
<!DOCTYPE html>
<html><head><meta name="viewport" content="width=device-width,initial-scale=1"><title>Manage Users</title>
<style>
*{box-sizing:border-box;font-family:Segoe UI,Arial}body{margin:0;background:#080808;color:#fff;display:flex}
.sidebar{width:260px;background:#0e0e0e;border-right:1px solid #1e1e1e;min-height:100vh;padding:18px 14px}
.brand{color:#ffcc00;font-weight:900;font-size:15px} .menu a{display:block;padding:13px 14px;margin:7px 0;border-radius:8px;color:#777;text-decoration:none;font-size:13px} .menu a.active{background:#ffcc00;color:#000;font-weight:800}
.main{flex:1;padding:20px} .table-wrap{background:#111;border:1px solid #1e1e1e;border-radius:14px;overflow:hidden} .table{width:100%;border-collapse:collapse} .table th{background:#0f0f0f;padding:12px;text-align:left;font-size:11px;color:#666;border-bottom:1px solid #1e1e1e} .table td{padding:13px 12px;border-top:1px solid #161616;font-size:13px}
.btn{padding:5px 10px;border-radius:6px;text-decoration:none;font-size:11px;margin-right:4px} .btn-block{background:#2a1a0f;color:#ffaa00;border:1px solid #443015} .btn-del{background:#1a0f0f;color:#ff4444;border:1px solid #331515} .btn-unblock{background:#0f1a0f;color:#4caf50;border:1px solid #1f331f}
</style></head><body>
<div class="sidebar"><div class="brand">LIFECOURSE<br>LIBRARY COMMAND</div>
<div class="menu">
<a href="admin_dashboard.php">📊 Dashboard</a>
<a href="admin_dashboard.php#add">➕ Add New Book</a>
<a href="admin_dashboard.php#manage">📚 Manage Books</a>
<a class="active" href="manage_users.php">👥 Manage Users</a>
<a href="index.php" target="_blank">🌐 View Site</a>
<a href="logout.php">🚪 Logout</a>
</div></div>
<div class="main"><h3>👥 Manage Users - All Registered Users</h3>
<div class="table-wrap"><table class="table"><tr><th>ID</th><th>USER</th><th>EMAIL</th><th>STATUS</th><th>ACTION</th></tr>
<?php if($users) while($u=$users->fetch_assoc()){ $status=$u['status']??'active'; ?>
<tr>
<td><?php echo $u['id']; ?></td>
<td><?php echo htmlspecialchars($u['username']??$u['name']??'User'); ?></td>
<td><?php echo htmlspecialchars($u['email']??''); ?></td>
<td><span style="color:<?php echo $status=='blocked'?'#ff4444':'#4caf50'; ?>"><?php echo $status; ?></span></td>
<td>
<?php if($status=='blocked'){ ?><a href="?unblock=<?php echo $u['id']; ?>" class="btn btn-unblock">Unblock</a><?php } else { ?><a href="?block=<?php echo $u['id']; ?>" class="btn btn-block">Block</a><?php } ?>
<a href="?del_user=<?php echo $u['id']; ?>" onclick="return confirm('Delete user?')" class="btn btn-del">Delete</a>
</td></tr>
<?php } ?>
</table></div></div></body></html>