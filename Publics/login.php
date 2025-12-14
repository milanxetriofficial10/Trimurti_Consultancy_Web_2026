<?php
session_start();
include "../db/config.php";

$error = "";

// Login form submission
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $stmt = mysqli_prepare($conn, "SELECT id, username, password, role FROM users WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];

            if ($row['role'] === "admin") {
                header("Location: ../admin/dashboard.php");
            } else {
                header("Location: home.php");
            }
            exit();
        } else {
            $error = "Incorrect password!";
        }
    } else {
        $error = "No account found!";
    }
}

// Fetch slider images
$slides = mysqli_query($conn, "SELECT * FROM login_slide_images ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Trimurti Educational Consultancy</title>
    <link rel="icon" href="../img /468819674_122128647596461823_8355324234216025560_n-modified.png" sizes="50x52" type="image/png">
    <style>
        body, html{margin:0; padding:0; font-family:Arial, sans-serif; height:100%;}
        .container{display:flex; height:100vh;}
        .slider{flex:1; position:relative; overflow:hidden;}
        .slider img{width:100%; height:100%; object-fit:cover; position:absolute; top:0; left:0; opacity:0; transition:opacity 1s;}
        .slider img.active{opacity:1;}
        /* Black overlay */
        .overlay{
            position:absolute; top:0; left:0; width:100%; height:100%;
            background: rgba(0,0,0,0.4);
            display:flex; justify-content:center; align-items:center;
            color:white; text-align:center; flex-direction:column; padding:20px;
        }
        .overlay h1{font-size:32px; margin-bottom:10px;}
        .overlay p{font-size:18px;}

        .login-form{flex:1; display:flex; justify-content:center; align-items:center; background:#edf2fcff; flex-direction:column; padding:20px; box-sizing:border-box;}
        .login-form img.logo{height:80px; margin-bottom:20px;}
        .login-form input{width:100%; padding:10px; margin:5px 0; border-radius:5px; border:1px solid #ccc;}
        .login-form button{width:100%; padding:10px; margin:10px 0; border:none; border-radius:5px; background:#ff6600; color:#fff; font-weight:bold; cursor:pointer;}
        .login-form button:hover{background:#e04300;}
        .error{color:red; font-weight:bold;}
        .signup{font-size:14px; margin-top:10px;}

        @media(max-width:768px){
            .container{flex-direction:column;}
            .slider{height:200px;}
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Slider -->
    <div class="slider">
        <?php foreach($slides as $index => $slide): ?>
            <img src="../admin/uploads/<?php echo $slide['image']; ?>" class="<?php echo $index===0?'active':''; ?>">
        <?php endforeach; ?>
        <div class="overlay">
            <h1>Welcome to Trimurti Educational Consultancy</h1>
            <p>Your future begins with the right guidance</p>
        </div>
    </div>

    <!-- Login Form -->
    <div class="login-form">
        <img src="../img /468819674_122128647596461823_8355324234216025560_n__1_-removebg-preview.png" class="logo" alt="Logo">
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button name="login">Login</button>
        </form>
        <?php if($error): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <p class="signup">Don’t have an account? <a href="signup.php">Signup</a></p>
    </div>
</div>

<script>
    // Slider JS
    const slides = document.querySelectorAll('.slider img');
    let current = 0;
    setInterval(() => {
        slides[current].classList.remove('active');
        current = (current + 1) % slides.length;
        slides[current].classList.add('active');
    }, 3000);
</script>

</body>
</html>
