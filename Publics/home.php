<?php
session_start();

// Optional: If you want to check role (admin/user)
$role = $_SESSION['role']; 
// but don't show role to users visually
include "../includes/top_header.php";
include "../includes/navbar.php";
include "../db/config.php";

$slides = $conn->query("SELECT * FROM slider_images ORDER BY id DESC");
$news = $conn->query("SELECT * FROM top_news ORDER BY id DESC");
$courses = $conn->query("SELECT * FROM courses ORDER BY id DESC");
$categories = $conn->query("SELECT * FROM course_categories ORDER BY id DESC");
$result = mysqli_query($conn, "SELECT * FROM gallery ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Home Slider</title>
<link rel="stylesheet" href="./css/home.css">
</head>
<body>

<div class="top-news-bar">
    <div class="top-news-label">Important News</div>
    <div class="marquee-wrapper">
        <div class="marquee">
            <?php if($news->num_rows > 0): ?>
                <?php while($row=$news->fetch_assoc()): ?>
                    <?php if($row['link']): ?>
                        <a href="<?php echo $row['link']; ?>" target="_blank"><?php echo $row['title']; ?></a>
                    <?php else: ?>
                        <span><?php echo $row['title']; ?></span>
                    <?php endif; ?>
                <?php endwhile; ?>
            <?php else: ?>
                <span>No news found</span>
            <?php endif; ?>
        </div>
    </div>
</div>


<div class="slider">
<?php $count=0; while($row=$slides->fetch_assoc()): ?>
<div class="slide <?php if($count==0) echo 'active'; ?>">
    <img src="../admin/uploads/<?php echo $row['image']; ?>">
    <div class="center-text">
        <h1><?php echo $row['heading']; ?></h1>
        <p><?php echo $row['paragraph']; ?></p>
        <?php if($row['btn_text']): ?>
        <a href="<?php echo $row['btn_link']; ?>"><?php echo $row['btn_text']; ?></a>
        <?php endif; ?>
    </div>
</div>
<?php $count++; endwhile; ?>

<!-- Dots navigation -->
<div class="dots">
<?php for($i=0;$i<$slides->num_rows;$i++): ?>
    <span class="<?php echo $i===0?'active':''; ?>"></span>
<?php endfor; ?>
</div>

</div>
<br>
  <div class="gallery-header">
    <h2>Gallery Of Trimurti Educational Consultancy</h2>
    <span class="gallery-line"></span>
</div>
<div class="gallery">

<?php while($row = mysqli_fetch_assoc($result)) { ?>
    <div class="gallery-card" onclick="openModal('../admin/uploads/<?php echo $row['image']; ?>')">
        <img src="../admin/uploads/<?php echo $row['image']; ?>">
        <div class="overlay"></div>
        <div class="text"><?php echo $row['title']; ?></div>
    </div>
<?php } ?>
</div>

<!-- Modal -->
<div id="imgModal" class="modal">
    <span class="close" onclick="closeModal()">×</span>
    <a id="downloadBtn" download class="download"><i class="fa fa-download"></i></a>
    <img id="modalImg">
</div>

<div class="container">
<h2>Our Courses</h2>
<div class="courses-grid">
<?php if($courses->num_rows > 0): ?>
<?php while($row = $courses->fetch_assoc()): ?>

    <div class="course-card">

        <?php if($row['discount'] > 0): ?>
            <div class="discount-badge">
                <?php echo $row['discount']; ?>% OFF
            </div>
        <?php endif; ?>

        <img src="../admin/uploads/<?php echo $row['image']; ?>">

        <div class="course-content">
            <h3><?php echo $row['title']; ?></h3>
            <p><?php echo $row['description']; ?></p>

            <?php if($row['button_text'] && $row['button_link']): ?>
                <a href="<?php echo $row['button_link']; ?>">
                    <?php echo $row['button_text']; ?>
                </a>
            <?php endif; ?>
        </div>

    </div>

<?php endwhile; ?>
<?php else: ?>
    <p style="text-align:center;">No courses found!</p>
<?php endif; ?>
</div>
</div>

<script src="./js/home.js"></script>
</body>
</html>
<br>
<br>
<?php
include "../includes/footer.php";
?>
