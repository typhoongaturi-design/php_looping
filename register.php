<?php
session_start();
include 'config.php';
$error = "";

if(isset($_POST['register'])){
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    if($name=="" || $email=="" || $password==""){
        $error = "All fields required!";
    }else if(strlen($password) < 6){
        $error = "Password must be at least 6 characters!";
    }else{
        $check = $conn->query("SELECT id FROM users WHERE email='$email'");
        if($check->num_rows > 0){
            $error = "Email already registered!";
        }else{
            // SECURE HASH - no one can see real password, not even admin
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $conn->query("INSERT INTO users (name, email, password) VALUES ('$name','$email','$hashed')");
            $id = $conn->insert_id;
            $_SESSION['user_id'] = $id;
            $_SESSION['user_name'] = $name;
            $_SESSION['user_email'] = $email;
            header("Location: index.php");
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Join LifeCourse</title>
<style>
*{box-sizing:border-box;margin:0;padding:0;font-family:Arial}
body{background:#000;color:#FFD700;min-height:100vh}
.header{padding:15px 20px;border-bottom:2px solid #FFD700;display:flex;justify-content:space-between;align-items:center;background:#111;flex-wrap:wrap}
.container{display:flex;justify-content:center;align-items:center;padding:20px;min-height:80vh}
.box{background:#111;border:2px solid #FFD700;border-radius:12px;padding:25px;width:100%;max-width:400px}
input{width:100%;padding:14px;margin:10px 0;background:#000;border:1px solid #FFD700;color:#FFD700;border-radius:8px;font-size:16px}
input::placeholder{color:#888}
button{width:100%;padding:14px;margin-top:12px;background:#FFD700;color:#000;border:none;border-radius:8px;font-weight:bold;font-size:16px;cursor:pointer}
.error{background:#ff3333;color:#fff;padding:10px;border-radius:6px;margin-bottom:12px;text-align:center;font-size:14px}
.small{font-size:12px;color:#aaa;text-align:center;margin-top:10px;line-height:1.4}
</style>
</head>
<body>
<div class="header">
<h2>📚 LifeCourse</h2>
<a href="index.php" style="color:#FFD700;text-decoration:none;border:1px solid #FFD700;padding:6px 12px;border-radius:6px">Home</a>
</div>
<div class="container">
<div class="box">
<h3 style="text-align:center;margin-bottom:10px">Create Account to Read Books</h3>
<p class="small">⚠️ Use a NEW password for this site. Don't use your Gmail/Google password.</p>
<?php if($error!=""){ echo "<div class='error'>$error</div>"; } ?>
<form method="POST">
<input type="text" name="name" placeholder="Your Full Name" required>
<input type="email" name="email" placeholder="Your Email" required>
<input type="password" name="password" placeholder="Create NEW Password (not Gmail)" required>
<button type="submit" name="register">Join & Read Books</button>
</form>
<p class="small">Your password is encrypted. Even admin cannot see it.</p>
</div>
</div>
</body>
</html>b    