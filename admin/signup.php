<?php
include "../db/config.php";
$msg = '';

if(isset($_POST['signup'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO admins (username, email, password) VALUES ('$username','$email','$password')";
    if($conn->query($sql)){
        $msg = "Admin created successfully. <a href='login.php'>Login here</a>";
    }else{
        $msg = "Error: ".$conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Signup</title>
<style>
body{font-family:Arial; background:#f3f3f3; padding:40px;}
form{width:400px; margin:auto; background:white; padding:20px; border-radius:10px; box-shadow:0 0 10px #0002;}
input, button{width:100%; padding:10px; margin-top:10px; border:1px solid #aaa; border-radius:5px;}
button{background:#1f2937; color:white; border:none;}
.message{color:green; text-align:center; margin-bottom:10px;}
</style>
</head>
<body>

<h2 style="text-align:center;">Admin Signup</h2>
<?php if($msg) echo "<p class='message'>$msg</p>"; ?>

<form method="POST">
    <label>Username:</label>
    <input type="text" name="username" required>

    <label>Email:</label>
    <input type="email" name="email" required>

    <label>Password:</label>
    <input type="password" name="password" required>

    <button name="signup">Sign Up</button>
</form>

</body>
</html>
