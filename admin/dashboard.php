<?php
session_start();
include "../db/config.php";

// Check login session
if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit;
}

// Fetch total stats
$total_slides = $conn->query("SELECT COUNT(*) AS total FROM slider_images")->fetch_assoc()['total'];
$total_news = $conn->query("SELECT COUNT(*) AS total FROM top_news")->fetch_assoc()['total'];
$total_courses = $conn->query("SELECT COUNT(*) AS total FROM courses")->fetch_assoc()['total'];
$total_categories = $conn->query("SELECT COUNT(*) AS total FROM course_categories")->fetch_assoc()['total'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #eef2f7;
        }

       /* ===== Admin Navbar ===== */
.navbar {
    position: sticky;
    top: 0;
    z-index: 1000;
    background: linear-gradient(135deg, #1a73e8, #1558b0);
    padding: 14px 35px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
}

/* Logo */
.navbar .logo {
    display: flex;
    align-items: center;
}

.navbar .logo img {
    height: 48px;
    transition: transform 0.3s ease;
}

.navbar .logo img:hover {
    transform: scale(1.05);
}

/* Nav links container */
.navbar nav {
    display: flex;
    align-items: center;
    gap: 14px;
    flex-wrap: wrap;
}

/* Links */
.navbar nav a {
    color: #fff;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    padding: 8px 14px;
    border-radius: 6px;
    transition: all 0.3s ease;
    white-space: nowrap;
}

/* Hover effect */
.navbar nav a:hover {
    background: rgba(255, 255, 255, 0.18);
    transform: translateY(-1px);
}

/* Active page (optional – add class="active") */
.navbar nav a.active {
    background: #ffffff;
    color: #1a73e8;
}

/* Logout highlight */
.navbar nav a:last-child {
    background: #ff4b5c;
}

.navbar nav a:last-child:hover {
    background: #e04352;
}

/* ===== Responsive ===== */
@media (max-width: 992px) {
    .navbar {
        flex-direction: column;
        align-items: flex-start;
        padding: 15px 20px;
    }

    .navbar nav {
        margin-top: 12px;
        width: 100%;
        gap: 10px;
    }

    .navbar nav a {
        font-size: 13px;
        padding: 7px 12px;
    }
}

@media (max-width: 600px) {
    .navbar nav {
        flex-direction: column;
        align-items: stretch;
    }

    .navbar nav a {
        width: 100%;
        text-align: center;
    }
}

        /* Dashboard container */
        .dashboard-container {
            width: 90%;
            max-width: 1100px;
            margin: 30px auto;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 5px;
        }

        .welcome-msg {
            text-align: center;
            margin-bottom: 30px;
            font-size: 18px;
            color: #444;
        }

        /* Dashboard Cards */
        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .card h3 {
            margin-bottom: 10px;
            color: #1a73e8;
        }

        .card p {
            font-size: 30px;
            font-weight: bold;
            color: #333;
        }

        .btn {
            margin-top: 15px;
            display: inline-block;
            background: #ff4b5c;
            padding: 10px 18px;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
        }

        .btn:hover {
            background: #e04352;
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 15px;
            background: #1a73e8;
            color: white;
            margin-top: 50px;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <div class="navbar">
        <div class="logo">
            <img src="../img /468819674_122128647596461823_8355324234216025560_n__1_-removebg-preview.png" alt="Institute Logo">
        </div>
        <nav>
            <a href="index.php">Dashboard</a>
            <a href="admin_sliders.php">Slider</a>
            <a href="admin_course.php">Courses</a>
            <a href="top_news.php">Top News</a>
            <a href="contact_slide.php">Contact slide add</a>
            <a href="admin_login_slide.php">Add Login Slide</a>
            <a href="admissions_list.php">List form</a>
            <a href="gallery_add.php">Add Gallery</a>
            <a href="about_slider.php">Add About Slider</a>
            <a href="add_about_file.php">Add About Files</a>
            <a href="Add_manager.php">Add About Manager</a>
            <a href="logout.php">Logout</a>
        </nav>
    </div>
    <!-- Dashboard -->
    <div class="dashboard-container">

        <h1>Admin Dashboard</h1>
        <p class="welcome-msg">Welcome, <b><?php echo htmlspecialchars($_SESSION['admin_name']); ?></b></p>

        <div class="cards">

            <div class="card">
                <h3>Total Slider Images</h3>
                <p><?php echo $total_slides; ?></p>
                <a class="btn" href="admin_slider.php">Manage</a>
            </div>

            <div class="card">
                <h3>Total Top News</h3>
                <p><?php echo $total_news; ?></p>
                <a class="btn" href="top_news.php">Manage</a>
            </div>

            <div class="card">
                <h3>Total Courses</h3>
                <p><?php echo $total_courses; ?></p>
                <a class="btn" href="admin_course.php">Manage</a>
            </div>

            <div class="card">
                <h3>Total Categories</h3>
                <p><?php echo $total_categories; ?></p>
                <a class="btn" href="course_categories.php">Manage</a>
            </div>

        </div>

    </div>

    <br> <br><br><br><br><br>
    <footer>
        &copy; <?php echo date("Y"); ?> My Institute. All rights reserved.
    </footer>

</body>

</html>
