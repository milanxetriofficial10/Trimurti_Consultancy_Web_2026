<?php
session_start();
include "../db/config.php";

// Check login session FIRST
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// अब मात्र navbar include गर
include "navbar.php";

// Fetch total stats
$total_slides = $conn->query("SELECT COUNT(*) AS total FROM slider_images")->fetch_assoc()['total'];
$total_news = $conn->query("SELECT COUNT(*) AS total FROM top_news")->fetch_assoc()['total'];
$total_courses = $conn->query("SELECT COUNT(*) AS total FROM courses")->fetch_assoc()['total'];
$total_categories = $conn->query("SELECT COUNT(*) AS total FROM course_categories")->fetch_assoc()['total'];
$total_gallery = $conn->query("SELECT COUNT(*) AS total FROM gallery")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <style>
/* ===== Dashboard Content ===== */
.dashboard-container {
    flex: 1;
    padding: 35px;
}

.dashboard-container h1 {
    text-align: center;
    margin-bottom: 6px;
}

.welcome-msg {
    text-align: center;
    color: #555;
    margin-bottom: 35px;
    font-size: 17px;
}

/* Cards */
.cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 25px;
}

.card {
    background: #ffffff;
    border-radius: 16px;
    padding: 25px;
    text-align: center;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    transition: all 0.35s ease;
}

.card:hover {
    transform: translateY(-8px);
    box-shadow: 0 18px 35px rgba(0,0,0,0.15);
}

.card h3 {
    color: #1a73e8;
    margin-bottom: 10px;
}

.card p {
    font-size: 34px;
    font-weight: bold;
}

/* Button */
.btn {
    display: inline-block;
    margin-top: 18px;
    padding: 10px 24px;
    background: linear-gradient(135deg, #ff4b5c, #e04352);
    color: #ffffff;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 600;
    transition: 0.3s;
}

.btn:hover {
    transform: scale(1.08);
}

/* ===== Footer ===== */
footer {
    background: #1a73e8;
    color: #ffffff;
    text-align: center;
    padding: 15px;
    font-size: 14px;
}

/* ===== Responsive ===== */
@media (max-width: 768px) {
    .navbar {
        width: 220px;
    }

    .main-area {
        margin-left: 220px;
        width: calc(100% - 220px);
    }
}

@media (max-width: 600px) {
    body {
        flex-direction: column;
    }

    .navbar {
        position: relative;
        width: 100%;
        height: auto;
        flex-direction: row;
        justify-content: space-between;
    }

    .navbar nav {
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: center;
    }

    .main-area {
        margin-left: 0;
        width: 100%;
    }
}

    </style>
</head>

<body>

    <body>
        <!-- ===== Dashboard Content ===== -->
        <div class="dashboard-container">
            <h1>Admin Dashboard</h1>
            <p class="welcome-msg">
                Welcome, <b><?php echo htmlspecialchars($_SESSION['admin_name']); ?></b>
            </p>

            <div class="cards">

                <div class="card">
                    <h3>Total Slider Images</h3>
                    <p><?php echo $total_slides; ?></p>
                    <a href="admin_slider.php" class="btn">Manage</a>
                </div>

                <div class="card">
                    <h3>Total Top News</h3>
                    <p><?php echo $total_news; ?></p>
                    <a href="top_news.php" class="btn">Manage</a>
                </div>

                <div class="card">
                    <h3>Total Courses</h3>
                    <p><?php echo $total_courses; ?></p>
                    <a href="admin_course.php" class="btn">Manage</a>
                </div>

            
                <div class="card">
                    <h3>Total Gallery Add</h3>
                    <p><?php echo $total_gallery; ?></p>
                    <a href="" class="btn">Manage</a>
                </div>

            </div>
        </div>

        <!-- ===== Footer ===== -->
        <footer>
            &copy; <?php echo date("Y"); ?> My Institute. All rights reserved.
        </footer>

    </div>

</body>


</html>
