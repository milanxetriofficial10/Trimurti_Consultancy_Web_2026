
    <!-- ===== Sidebar ===== -->
    <div class="navbar">
        <div class="logo">
            <img src="../img /468819674_122128647596461823_8355324234216025560_n__1_-removebg-preview.png" alt="Logo">
        </div>

        <nav>
            <a href="dashboard.php" class="active">Dashboard</a>
            <a href="top_news.php">Top News Add</a>
            <a href="admin_course.php">Courses Add</a>
              <a href="gallery_add.php">Gallery Add</a>
              <a href="admissions_list.php">Join Us List Form</a>
              <a href="Add_manager.php">Manager Add</a>
              <a href="add_about_file.php">About Text Add</a>
            <a href="admin_sliders.php">Slider</a>    
            <a href="contact_slide.php">Contact Slide</a>
            <a href="admin_login_slide.php">Login Slide</a>
            <a href="about_slider.php">About Slider</a>
            <a href="logout.php">Logout</a>
        </nav>
    </div>

    <!-- ===== Main Area ===== -->
    <div class="main-area">

        <!-- ===== Top Bar ===== -->
        <div class="topbar">
            <div class="search-box">
                <input type="text" placeholder="Search anything...">
                <span>🔍</span>
            </div>
        </div>

        <style>
              /* ===== Reset ===== */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* ===== Body ===== */
body {
    font-family: "Segoe UI", Arial, sans-serif;
    background: #eef2f7;
    display: flex;
    min-height: 100vh;
    color: #333;
}

/* ===== Sidebar ===== */
/* ===== Sidebar ===== */
.navbar {
    width: 260px;
    height: 100vh;
    position: fixed;
    left: 0;
    top: 0;
    background: linear-gradient(180deg, #1a73e8, #1558b0);
    padding: 25px 20px 15px;
    display: flex;
    flex-direction: column;
    box-shadow: 4px 0 20px rgba(0,0,0,0.25);
    z-index: 1000;
    overflow: hidden; /* IMPORTANT */
}

/* Logo fixed top */
.logo {
    margin-bottom: 20px;
    flex-shrink: 0;
}

/* ===== Sidebar Links Scroll Enable ===== */
.navbar nav {
    width: 100%;
    display: flex;
    flex-direction: column;
    gap: 10px;

    overflow-y: auto;      /* ⭐ SCROLL ENABLE */
    flex: 1;               /* ⭐ TAKE REMAINING HEIGHT */
    padding-right: 6px;    /* scrollbar space */
}

/* Optional: Smooth scrollbar (Chrome) */
.navbar nav::-webkit-scrollbar {
    width: 6px;
}

.navbar nav::-webkit-scrollbar-thumb {
    background: rgba(255,255,255,0.35);
    border-radius: 10px;
}

.navbar nav::-webkit-scrollbar-track {
    background: transparent;
}


.logo img {
    height: 58px;
    transition: transform 0.4s ease;
}

.logo img:hover {
    transform: scale(1.1);
}


.navbar nav a {
    color: #ffffff;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    padding: 13px 16px;
    border-radius: 10px;
    transition: all 0.35s ease;
}

.navbar nav a:hover {
    background: rgba(255,255,255,0.22);
    padding-left: 24px;
}

/* Active */
.navbar nav a.active {
    background: #ffffff;
    color: #1a73e8;
}

/* Logout */
.navbar nav a:last-child {
    margin-top: 20px;
    background: #ff4b5c;
    text-align: center;
}

.navbar nav a:last-child:hover {
    background: #e04352;
}

/* ===== Main Area ===== */
.main-area {
    margin-left: 260px;
    width: calc(100% - 260px);
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

/* ===== Topbar ===== */
.topbar {
    background: #55565eff;
    padding: 18px 30px;
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: 0 4px 14px rgba(0,0,0,0.08);
    position: sticky;
    top: 0;
    z-index: 900;
}

/* Search Bar */
.search-box {
    width: 420px;
    max-width: 95%;
    position: relative;
}

.search-box input {
    width: 100%;
    padding: 12px 45px 12px 18px;
    border-radius: 30px;
    border: 1px solid #dcdcdc;
    outline: none;
    font-size: 14px;
    transition: 0.3s;
}

.search-box input:focus {
    border-color: #1a73e8;
    box-shadow: 0 0 0 3px rgba(26,115,232,0.15);
}

.search-box span {
    position: absolute;
    right: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: #888;
    font-size: 16px;
}

        </style>