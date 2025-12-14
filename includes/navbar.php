<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Trimurti Educational Consultancy</title>
<link rel="icon" href="../img/468819674_122128647596461823_8355324234216025560_n-modified.png">
<link rel="stylesheet" href="navbar.css">
</head>
<body>
<nav class="navbar">
    <!-- Logo -->
    <a href="../Publics/home.php" class="brand">
        <img src="../img /468819674_122128647596461823_8355324234216025560_n__1_-removebg-preview.png" alt="Logo">
        <span>Trimurti Educational Consultancy</span>
    </a>

    <!-- Hamburger / Cancel -->
    <button class="hamburger" id="hamburger">☰</button>

    <!-- Center Links + Right -->
    <div class="nav-menu" id="navMenu">
        <ul class="nav-links">
            <li><a href="../Publics/home.php" class="active">Home</a></li>
            <li><a href="#">About Us</a></li>
            <li><a href="#">Service</a></li>
            <li><a href="../Publics/join_us.php">Join Us</a></li>
            <li><a href="../Publics/contact.php">Contact</a></li>
        </ul>

        <!-- Right: search + login -->
        <div class="nav-right">
            <input type="search" placeholder="Search">
            <a href="../Publics/login.php"><button class="login-btn">Login</button></a>
        </div>
    </div>
</nav>

<script src="navbar.js"></script>
</body>
</html>
<style>
  body{
    margin:0;
    font-family:Arial, sans-serif;
    background: #f7c7b8ff;
}
/* Navbar */
.navbar{
    background: #edf1faff;
    height:50px;
    display:flex;
    align-items:center;
    padding:0 20px;
    justify-content:space-between;
    position:relative;
     position: sticky;  /* change from relative to sticky */
    top: 0;            /* stick to top */
    z-index: 1000;
}

/* Brand */
.brand{
    display:flex;
    align-items:center;
    gap:6px;
    text-decoration:none;
    color: #1c037e;
    font-weight:bold;
    font-size:14px;
}
.brand img{
    height:50px;
}

/* Menu */
.nav-menu{
    display:flex;
    align-items:center;
    gap:30px;
}

/* Links */
.nav-links{
    display:flex;
    list-style:none;
    gap:25px;
}
.nav-links a{
    text-decoration:none;
    color:hsla(246,99%,27%,1);
    font-weight:600;
    transition:0.3s;
}
.nav-links a:hover{
    color:#ff6600;
}

/* Center links */
.nav-links{
    position:absolute;
    left:50%;
    transform:translateX(-50%);
}

/* Right */
.nav-right{
    display:flex;
    align-items:center;
    gap:10px;
}
.nav-right input{
    height:33px;
    padding:4px 10px;
    border-radius:4px;
    border:1px solid #ccc;
}
.login-btn{
    height:33px;
    background:#ff6600;
    border:none;
    color:#fff;
    padding:0 12px;
    cursor:pointer;
    border-radius:4px;
    transition:0.3s;
}
.login-btn:hover{
    background:#e04300;
}

/* Hamburger */
.hamburger{
    display:none;
    font-size:22px;
    background:none;
    border:none;
    cursor:pointer;
}

/* Mobile */
@media(max-width:991px){
    .hamburger{
        display:block;
        color: #0e0505ff;
    }
    .brand span{
    font-size:12px;
}


    .nav-menu{
        position:fixed;
        top:0;
        left:-250px; /* hidden off screen */
        width:220px;
        height: 100%;
        background: #30373fff;
        flex-direction:column;
        padding-top:80px;
        gap:20px;
        transition:0.3s;
        z-index:999;
    }

    .nav-menu.active{
        left:0;
    }

    .nav-links{
        position:static;
        flex-direction:column;
        transform:none;
        gap:15px;
    }

    .nav-links a{
        color:white;
        font-size:18px;
    }

    .nav-right{
        display:flex;
        flex-direction:column;
        gap:10px;
        padding:0 15px;
    }

    /* Hide search on mobile */
    .nav-right input{
        display:none;
    }

    /* Cancel icon */
    .hamburger.active::after{
        content:"✖";
        color:white;
        font-size:22px;
    }
}

</style>

<script>
  const hamburger = document.getElementById("hamburger");
const navMenu = document.getElementById("navMenu");

hamburger.addEventListener("click", () => {
    navMenu.classList.toggle("active");
    hamburger.classList.toggle("active"); // toggle cancel icon
});

// Close menu clicking outside
document.addEventListener("click", function(e){
    if(!navMenu.contains(e.target) && !hamburger.contains(e.target)){
        navMenu.classList.remove("active");
        hamburger.classList.remove("active");
    }
});

</script>