<?php
session_start();

// but don't show role to users visually
include "../includes/top_header.php";
include "../includes/navbar.php";
include "../db/config.php";

$slides = $conn->query("SELECT * FROM slider_images ORDER BY id DESC");
$news = $conn->query("SELECT * FROM top_news ORDER BY id DESC");
$courses = $conn->query("SELECT * FROM courses ORDER BY id DESC");
$result = mysqli_query($conn, "SELECT * FROM gallery ORDER BY id DESC");
?>
<!-- SEO Meta : Brand Search -->
<title>Trimurti Educational Consultancy | Nepal</title>

<meta name="description"
      content="Trimurti Educational Consultancy is a trusted education consultancy in Nepal providing admission guidance, study abroad services, and career counseling.">

<meta name="keywords"
      content="Trimurti, Trimurti Educational Consultancy, Trimurti Nepal, Education Consultancy Nepal, Study Abroad Nepal">

<meta name="author" content="Trimurti Educational Consultancy">

<meta name="robots" content="index, follow">

<link rel="canonical" href="https://yourwebsite.com/">

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
<style>
  /* ===== Container ===== */
.container {
    max-width: 1500px;
    margin: auto;
    padding: 60px 20px;
}

.container h2 {
    text-align: center;
    font-size: 36px;
    font-weight: 700;
    margin-bottom: 50px;
    color: #111;
}

/* ===== Grid ===== */
.courses-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 30px;
}

/* ===== Card ===== */
.course-card {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    width: 300px;
    height: 360px;
    cursor: pointer;
    box-shadow: 0 15px 40px rgba(0,0,0,0.12);
    transform: translateY(0);
    transition: all 0.45s ease;
}

.course-card:hover {
    transform: translateY(-10px) scale(1.02);
    box-shadow: 0 25px 55px rgba(0,0,0,0.18);
}

/* ===== Image ===== */
.course-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

/* ===== Dark Overlay ===== */
.course-card::before {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(
        to bottom,
        rgba(0,0,0,0.25),
        rgba(0,0,0,0.65)
    );
    z-index: 1;
    transition: opacity 0.4s ease;
}

.course-card:hover::before {
    opacity: 0.85;
}

/* ===== Discount Badge (on image) ===== */
.discount-badge {
    position: absolute;
    top: 18px;
    left: 18px;
    z-index: 3;
    background: linear-gradient(135deg, #fc1a12ff, #ff1e00ff);
    color: #fff;
    padding: 8px 16px;
    border-radius: 30px;
    font-size: 14px;
    font-weight: 600;
    box-shadow: 0 8px 20px rgba(255,107,0,0.45);
    animation: floatBadge 2.5s ease-in-out infinite;
}

/* ===== Content on Image ===== */
.course-content {
    position: absolute;
    inset: 0;
    z-index: 2;
    padding: 30px;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    color: #fff;
    animation: fadeUp 0.9s ease both;
}

.course-content h3 {
    font-size: 22px;
    font-weight: 700;
    margin-bottom: 10px;
}

.course-content p {
    font-size: 15px;
    line-height: 1.7;
    opacity: 0.92;
    margin-bottom: 20px;
}

/* ===== Button on Image ===== */
.course-content a {
    align-self: flex-start;
    padding: 12px 28px;
    background: #ff6b00;
    color: #fff;
    border-radius: 30px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    transition: all 0.35s ease;
}

.course-content a:hover {
    background: #fff;
    color: #111;
    transform: translateX(6px);
}

/* ===== Animations ===== */
@keyframes fadeUp {
    from {
        opacity: 0;
        transform: translateY(25px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes floatBadge {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-6px); }
}

/* ===== Mobile Responsive ===== */
@media (max-width: 768px) {
    .course-card {
        height: 320px;
    }

    .course-content {
        padding: 22px;
        text-align: center;
        align-items: center;
    }

    .course-content a {
        align-self: center;
    }
}

@media (max-width: 480px) {
    .course-card {
        height: 300px;
    }

    .course-content h3 {
        font-size: 19px;
    }

    .course-content p {
        font-size: 14px;
    }
}

.top-news-bar{
    width:100%;
    background: #ff5a27ff;
    color:white;
    display:flex;
    align-items:center;
    font-family:Arial, sans-serif;
    overflow:hidden;
    padding:0 10px;
    box-sizing:border-box;
}

.top-news-label{
    flex:0 0 auto;
    background:  #ff5a27ff;
    color:white;
    font-weight:bold;
    padding:5px 20px;
    white-space:nowrap;
    position:relative;
}

.top-news-label::after{
    content:"";
    position:absolute;
    top:50%;
    right:-15px;
    transform:translateY(-50%);
    border-top:15px solid transparent;
    border-bottom:15px solid transparent;
    border-left:15px solid  #fc4a13ff;
}

.marquee-wrapper{
    flex:1 1 auto;
    overflow:hidden;
    white-space:nowrap;
    position:relative;
    margin-left:5px;
}

.marquee{
    display:inline-block;
    white-space:nowrap;
    animation:scroll-left 15s linear infinite;
}

.marquee a, .marquee span{
    color:white;
    text-decoration:none;
    margin-right:50px;
}

/* Right → left scrolling keyframes */
@keyframes scroll-left{
    0%{transform:translateX(100%);}
    100%{transform:translateX(-100%);}
}

/* Responsive adjustments */
@media(max-width:1024px){
    .top-news-label{padding:4px 16px; font-size:14px;}
    .marquee a, .marquee span{margin-right:30px;}
}
@media(max-width:768px){
    .top-news-label{padding:4px 12px; font-size:12px;}
    .marquee a, .marquee span{margin-right:20px;}
}
@media(max-width:480px){
    .top-news-bar{
        flex-direction:row;
        align-items:center;
        height:auto;
        padding:5px;
    }
    .top-news-label{
        margin-bottom:0; 
        margin-right:10px; 
    }
    .marquee-wrapper{
        width:calc(100% - 100px); 
        margin-left:0;
    }
    .marquee a, .marquee span{margin-right:15px;}
}
</style>

<?php include '../includes/footer.php'; ?>
