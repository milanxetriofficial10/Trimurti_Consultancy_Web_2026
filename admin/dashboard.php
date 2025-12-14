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

        /* Navbar */
        .navbar {
            background: #1a73e8;
            padding: 12px 25px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navbar .logo img {
            height: 50px;
        }

        .navbar nav a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-weight: bold;
        }

        .navbar nav a:hover {
            text-decoration: underline;
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
            <img src="logo.png" alt="Institute Logo">
        </div>
        <nav>
            <a href="index.php">Dashboard</a>
            <a href="admin_slider.php">Slider</a>
            <a href="admin_course.php">Courses</a>
            <a href="top_news.php">Top News</a>
            <a href="course_categories.php">Categories</a>
            <a href="contact_slide.php">Contact slide add</a>
            <a href="admin_login_slide.php">Add Login Slide</a>
            <a href="admissions_add.php">Add form</a>
            <a href="admissions_list.php">List form</a>
            <a href="gallery_add.php">Add Images</a>
            <a href="logout.php">Logout</a>
        </nav>
    </div>

    <!-- Dashboard -->
    <div class="dashboard-container">

        <h1>Admin Dashboard</h1>
        <p class="welcome-msg">Welcome, <b><?php echo htmlspecialchars($_SESSION['admin_name']); ?></b> 🌿</p>

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

    <footer>
        &copy; <?php echo date("Y"); ?> My Institute. All rights reserved.
    </footer>

</body>

</html>
