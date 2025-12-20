<?php
include "../db/config.php";
include "../includes/top_header.php";
include "../includes/navbar.php";
$slider = mysqli_query($conn,"SELECT * FROM about_slider WHERE status=1");
$about = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM about_consultancy ORDER BY id DESC LIMIT 1"));
$manager = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT * FROM about_manager ORDER BY id DESC LIMIT 1")
);
$news = $conn->query("SELECT * FROM top_news ORDER BY id DESC");
?>
<link rel="stylesheet" href="./css/about.css">
<!-- ABOUT SLIDER -->
<div class="about-slider">
<?php while($s = mysqli_fetch_assoc($slider)) { ?>
    <div class="slide" style="background-image:url('../admin/uploads/<?php echo $s['image']; ?>')">
        <div class="overlay">
            <h1><?php echo $s['title']; ?></h1>
            <a href="<?php echo $s['button_link']; ?>" class="btn">
                <?php echo $s['button_text']; ?>
            </a>
        </div>
    </div>
<?php } ?>
<meta name="description" content="Trimurti Educational Consultancy is a trusted education consultancy in Nepal providing admission guidance, study abroad services, and career counseling. | About">
<meta name="description" content="The Best Consultancy In Nepal.">
<meta name="keywords" content="Trimurti, Trimurti Educational Consultancy, Trimurti Nepal, Education Consultancy Nepal, Study Abroad Nepal">
<meta name="author" content="Trimurti Educational Consultancy">
<meta name="robots" content="index, follow">
<link rel="canonical" href="https://website.com.np/">
</div>
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
<!-- ABOUT MANAGER -->
<section class="manager">
    <div class="text">
        <h4><?php echo $manager['consultancy_name']; ?></h4>
        <h2><?php echo $manager['manager_name']; ?></h2>

        <p><?php echo nl2br($manager['manager_message']); ?></p>

        <div class="stats">
            <div>
                <strong><?php echo $manager['years_active']; ?>+</strong>
                <span>Years of Service</span>
            </div>
            <div>
                <strong><?php echo $manager['students_count']; ?>+</strong>
                <span>Students Guided</span>
            </div>
        </div>
    </div>
    <div class="image">
        <img src="../admin/uploads/<?php echo $manager['manager_image']; ?>">
    </div>
</section>
<!-- CONSULTANCY ABOUT -->
<section class="consultancy">
    <h2>Trimurti Educational Consultancy</h2>
    <p><?php echo nl2br($about['description']); ?></p>
</section>
<?php include '../includes/footer.php'; ?>