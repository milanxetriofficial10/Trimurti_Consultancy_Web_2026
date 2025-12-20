<?php
session_start();
include "../db/config.php";

$error = "";

if (isset($_POST['signup'])) {

    // Clean user inputs
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password_raw = $_POST['password'];
    $password = password_hash($password_raw, PASSWORD_DEFAULT);

    // Check if username or email already exists
    $check = "SELECT id FROM users WHERE username = ? OR email = ?";
    $stmt = mysqli_prepare($conn, $check);
    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $error = "Username or Email already exists!";
    } else {

        // Insert using prepared statement
        $sql = "INSERT INTO users (username, email, password, role) 
                VALUES (?, ?, ?, 'user')";

        $stmt2 = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt2, "sss", $username, $email, $password);

        if (mysqli_stmt_execute($stmt2)) {
            header("Location: home.php");
            exit();
        } else {
            $error = "Signup failed! Try again.";
        }
    }
}
// Fetch slider images
$slides = mysqli_query($conn, "SELECT * FROM login_slide_images ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Signup - Trimurti Educational Consultancy</title>
<meta name="description" content="Trimurti Educational Consultancy is a trusted education consultancy in Nepal providing admission guidance, study abroad services, and career counseling.">
<meta name="description" content="The Best Consultancy In Nepal. | Signup Here">
<meta name="keywords" content="Trimurti, Trimurti Educational Consultancy, Trimurti Nepal, Education Consultancy Nepal, Study Abroad Nepal">
<meta name="author" content="Trimurti Educational Consultancy">
<meta name="robots" content="index, follow">
<link rel="canonical" href="https://website.com.np/">
    <link rel="icon" href="../img /468819674_122128647596461823_8355324234216025560_n-modified.png" sizes="50x52" type="image/png">
    <style>
        body, html{margin:0; padding:0; font-family:Arial, sans-serif; height:100%;}
        .container{display:flex; height:100vh;}
        .slider{flex:1; position:relative; overflow:hidden;}
        .slider img{width:100%; height:100%; object-fit:cover; position:absolute; top:0; left:0; opacity:0; transition:opacity 1s;}
        .slider img.active{opacity:1;}
        .overlay{
            position:absolute; top:0; left:0; width:100%; height:100%;
            background: rgba(0,0,0,0.4);
            display:flex; justify-content:center; align-items:center;
            color:white; text-align:center; flex-direction:column; padding:20px;
        }
        .overlay h1{font-size:32px; margin-bottom:10px;}
        .overlay p{font-size:18px;}

        .signup-form{flex:1; display:flex; justify-content:center; align-items:center; background:#edf2fcff; flex-direction:column; padding:20px; box-sizing:border-box;}
        .signup-form img.logo{height:80px; margin-bottom:20px;}
        .signup-form input {
    width: 80%;      
    max-width:300px;   
    padding:8px;       
    margin:5px 0;
    border-radius:5px;
    border:1px solid #ccc;
    font-size:14px;   
    box-sizing:border-box;
}
.signup-form button {
    width:80%;         
    max-width:300px;
    padding:10px;
    border:none;
    border-radius:5px;
    background:#ff6600;
    color:#fff;
    font-weight:bold;
    cursor:pointer;
}
.signup-form button:hover {
    background:#e04300;
}

        .error{color:red; font-weight:bold;}
        .login-link{font-size:14px; margin-top:10px;}

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
            <h1>Join Trimurti Educational Consultancy</h1>
            <p>Register today to start your educational journey</p>
        </div>
    </div>

    <!-- Signup Form -->
    <div class="signup-form">
        <img src="../img /468819674_122128647596461823_8355324234216025560_n__1_-removebg-preview.png" class="logo" alt="Logo">
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button name="signup">Signup</button>
        </form>
        <?php if($error): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <p class="login-link">Already have an account? <a href="login.php">Login</a></p>
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
