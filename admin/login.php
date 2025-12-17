<?php
session_start(); // top of file
include "../db/config.php";

$msg = ''; // <- initialize variable to avoid undefined warning

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $res = $conn->query("SELECT * FROM admins WHERE email='$email'");
    if($res->num_rows > 0){
        $row = $res->fetch_assoc();
        if(password_verify($password, $row['password'])){
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['admin_name'] = $row['username'];
            header("Location: dashboard.php");
            exit;
        } else { 
            $msg = "Incorrect password!";
        }
    } else { 
        $msg = "Admin not found!";
    }
}
include "navbar.php";
?>



<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>
<style>
body{font-family:Arial; background:#f3f3f3; padding:40px;}
form{width:400px; margin:auto; background:white; padding:20px; border-radius:10px; box-shadow:0 0 10px #0002;}
input, button{width:100%; padding:10px; margin-top:10px; border:1px solid #aaa; border-radius:5px;}
button{background:#1f2937; color:white; border:none;}
.message{color:red; text-align:center; margin-bottom:10px;}
</style>
</head>
<body>

<h2 style="text-align:center;">Admin Login</h2>
<?php if($msg) echo "<p class='message'>$msg</p>"; ?>

<form method="POST">
    <label>Email:</label>
    <input type="email" name="email" required>

    <label>Password:</label>
    <input type="password" name="password" required>

    <button name="login">Login</button>
</form>

<p style="text-align:center;margin-top:10px;">Don't have an account? <a href="signup.php">Sign Up</a></p>

</body>
</html>
