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
    <h2>Our Course Categories</h2>
    <div class="categories">
        <?php if($categories->num_rows > 0): ?>
            <?php while($row = $categories->fetch_assoc()): ?>
                <div class="category-card">
                    <img src="../admin/uploads/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                    <div class="category-content">
                        <h3><?php echo $row['name']; ?></h3>
                        <p><?php echo $row['description']; ?></p>
                    </div>
                    <div class="category-button">
                        <a href="courses.php?category=<?php echo $row['id']; ?>">View Courses</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align:center;">No categories found</p>
        <?php endif; ?>
    </div>
</div>

<div class="container">
<h2>Our Courses</h2>
<div class="courses-grid">
<?php if($courses->num_rows>0): ?>
    <?php while($row=$courses->fetch_assoc()): ?>
        <div class="course-card">
            <img src="../admin/uploads/<?php echo $row['image']; ?>">
            <div class="course-content">
                <h3><?php echo $row['title']; ?></h3>
                <p><?php echo $row['description']; ?></p>
                <?php if($row['button_text'] && $row['button_link']): ?>
                    <a href="<?php echo $row['button_link']; ?>"><?php echo $row['button_text']; ?></a>
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
        .container{max-width:1200px; margin:auto;}
h2{text-align:center; margin-bottom:30px;}
.courses-grid{display:grid; grid-template-columns:repeat(auto-fit,minmax(250px,1fr)); gap:20px;}
.course-card{background:white; border-radius:10px; overflow:hidden; box-shadow:0 0 10px rgba(0,0,0,0.1);}
.course-card img{width:100%; height:180px; object-fit:cover;}
.course-content{padding:15px;}
.course-content h3{margin:0 0 10px 0; color:#1f2937;}
.course-content p{font-size:14px; color:#333; height:60px; overflow:hidden;}
.course-content a{display:inline-block; margin-top:10px; padding:8px 15px; background:#ff5a27; color:white; border-radius:5px; text-decoration:none;}
.course-content a:hover{background:#e04352;}
@media(max-width:768px){.course-content p{height:auto;}}

*{margin:0;padding:0;box-sizing:border-box;}

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

/* Important News label pinned to left */
.top-news-label{
    flex:0 0 auto;
    background:  #ff5a27ff;
    color:white;
    font-weight:bold;
    padding:5px 20px;
    white-space:nowrap;
    position:relative;
}

/* Arrow on the label */
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

/* Marquee wrapper takes remaining width */
.marquee-wrapper{
    flex:1 1 auto;
    overflow:hidden;
    white-space:nowrap;
    position:relative;
    margin-left:5px;
}

/* Scrolling news text */
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
        margin-right:10px; /* small spacing to news */
    }
    .marquee-wrapper{
        width:calc(100% - 100px); /* leave space for label */
        margin-left:0;
    }
    .marquee a, .marquee span{margin-right:15px;}
}


.container{width:90%; margin:auto;}
h2{text-align:center; margin-bottom:30px; color:#333;}

/* Categories container */
.categories{display:flex; flex-direction:column; gap:20px;}

/* Individual row card */
.category-card{
    display:flex;
    background:white;
    border-radius:10px;
    overflow:hidden;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
    transition:0.3s;
    align-items:center;
}

.category-card:hover{
    transform:translateY(-5px);
}

/* Image on left */
.category-card img{
    width:200px;
    height:140px;
    object-fit:cover;
    border-radius:10px 0 0 10px;
    flex-shrink:0;
}

/* Text in the middle */
.category-content{
    padding:15px 20px;
    flex:1;
}

/* Right-side button container */
.category-button{
    padding-right:20px;
}

/* Title and description */
.category-content h3{
    margin-bottom:10px;
    color:#1f2937;
    font-size:1.4rem;
}

.category-content p{
    font-size:0.95rem;
    color:#555;
}

/* Button style */
.category-button a{
    display:inline-block;
    padding:10px 20px;
    background:#1f2937;
    color:white;
    border-radius:5px;
    text-decoration:none;
    font-weight:bold;
    transition:0.3s;
}

.category-button a:hover{
    background:#ff5a27;
}

/* Responsive adjustments */
@media(max-width:768px){
    .category-card{
        flex-direction:column;
        align-items:flex-start;
    }
    .category-card img{width:100%; height:180px; border-radius:10px 10px 0 0;}
    .category-content{padding:10px;}
    .category-button{padding:10px 0;}
}
@media(max-width:480px){
    .category-content h3{font-size:1.2rem;}
    .category-content p{font-size:0.85rem;}
    .category-button a{padding:6px 15px;}
}

</style>

<?php include '../includes/footer.php'; ?>
