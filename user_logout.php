<?php
// Delete cookies by setting time in the past
setcookie("user_id", "", time() - 3600, "/");
setcookie("user_name", "", time() - 3600, "/");

// Redirect to register
header("Location: register.php");
exit();
?>