<?php
session_start();
// but don't show role to users visually
include "../includes/top_header.php";
include "../includes/navbar.php";
include "../db/config.php";
$slides = $conn->query("SELECT * FROM slider_images ORDER BY id DESC");
$news = $conn->query("SELECT * FROM top_news ORDER BY id DESC");
$courses = $conn->query("SELECT * FROM courses ORDER BY id DESC");
$categories = $conn->query("SELECT * FROM course_categories ORDER BY id DESC");
$result = mysqli_query($conn, "SELECT * FROM gallery ORDER BY id DESC");
$result = $conn->query("SELECT * FROM media_gallery ORDER BY created_at DESC");


// Contact Form Processing
$name = $email = $subject = $message = "";
$success = $error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $subject = mysqli_real_escape_string($conn, trim($_POST['subject']));
    $message = mysqli_real_escape_string($conn, trim($_POST['message']));

    if ($name && $email && $subject && $message) {
        $sql = "INSERT INTO contact_messages (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";
        if (mysqli_query($conn, $sql)) {
            $success = "Thank you! Your message has been sent.";
            $name = $email = $subject = $message = "";
        } else {
            $error = "Something went wrong. Try again later.";
        }
    } else {
        $error = "Please fill all fields.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<!-- SEO Meta : Brand Search -->
<title>Trimurti Educational Consultancy</title>

<meta name="description"
      content="Trimurti Educational Consultancy is a trusted education consultancy in Nepal providing admission guidance, study abroad services, and career counseling.">

<meta name="keywords"
      content="Trimurti, Trimurti Educational Consultancy, Trimurti Nepal, Education Consultancy Nepal, Study Abroad Nepal">

<meta name="author" content="Trimurti Educational Consultancy">

<meta name="robots" content="index, follow">

<link rel="canonical" href="https://yourwebsite.com/">

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


<h2>Media Gallery</h2>
<div class="gallery-container">
<?php while($row = $result->fetch_assoc()): ?>
    <div class="media-card">
        <h3><?php echo htmlspecialchars($row['name']); ?></h3>
        <p><?php echo htmlspecialchars($row['description']); ?></p>

        <?php if($row['video']): ?>
            <video controls>
                <source src="<?php echo $row['video']; ?>" type="video/mp4">
                Your browser does not support HTML5 video.
            </video>
        <?php endif; ?>

        <?php if($row['image']): ?>
            <img src="<?php echo $row['image']; ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
        <?php endif; ?>

        <?php if($row['audio']): ?>
            <audio controls>
                <source src="<?php echo $row['audio']; ?>" type="audio/mpeg">
                Your browser does not support audio element.
            </audio>
        <?php endif; ?>
    </div>
<?php endwhile; ?>
</div>



<h2 class="gallery-title">Media Gallery</h2>

<div class="media-gallery">
<?php while($row = $result->fetch_assoc()): ?>
    <div class="gallery-item">
        <h3 class="gallery-name"><?php echo htmlspecialchars($row['name']); ?></h3>
        <p class="gallery-desc"><?php echo htmlspecialchars($row['description']); ?></p>

        <!-- Video -->
        <?php if($row['video']): ?>
            <video class="gallery-video" controls>
                <source src="admin/<?php echo $row['video']; ?>" type="video/mp4">
                Your browser does not support HTML5 video.
            </video>
        <?php endif; ?>

        <!-- Image -->
        <?php if($row['image']): ?>
            <img class="gallery-image" src="admin/<?php echo $row['image']; ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
        <?php endif; ?>

        <!-- Audio -->
        <?php if($row['audio']): ?>
            <audio class="gallery-audio" controls>
                <source src="admin/<?php echo $row['audio']; ?>" type="audio/mpeg">
                Your browser does not support audio element.
            </audio>
        <?php endif; ?>
    </div>
<?php endwhile; ?>
</div>


<!-- Contact Section -->
<div class="contact-container">
    <div class="contact-form">
        <h2>Contact Us</h2>
        <?php if($success) echo "<div class='message success'>$success</div>"; ?>
        <?php if($error) echo "<div class='message error'>$error</div>"; ?>
        <form method="POST" action="">
            <input type="text" name="name" placeholder="Your Name" value="<?php echo htmlspecialchars($name); ?>" required>
            <input type="email" name="email" placeholder="Your Email" value="<?php echo htmlspecialchars($email); ?>" required>
            <input type="text" name="subject" placeholder="Subject" value="<?php echo htmlspecialchars($subject); ?>" required>
            <textarea name="message" placeholder="Your Message" rows="5" required><?php echo htmlspecialchars($message); ?></textarea>
            <button type="submit">Send Message</button>
        </form>
    </div>

    <div class="contact-info-info">
        <h2>Our Location</h2>
        <p><strong>Address:</strong> Chabahil-07, Kathmandu (Near Pashupati College)</p>
        <p><strong>Phone:</strong> 📞 01-5922403 | 📱 9840536647</p>
        <p><strong>Email:</strong> trimurtiedu.consultancy@gmail.com</p>
       <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2166.0063273607548!2d85.34347095438973!3d27.713954481852728!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb1900407250af%3A0x1c696e93c50f94a8!2sTrimurti%20Educational%20Consultancy!5e0!3m2!1sen!2snp!4v1765633252947!5m2!1sen!2snp" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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


.slider {
    position: relative;
    width: 100%;
    height: 70vh; /* full screen ko 80% */
    overflow: hidden;
}


.slide{
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:100%;
    opacity:0;
    transition:opacity 1s ease-in-out;
}

.slide img{
    width:100%;
    height:100%;
    object-fit:cover;
    display:block;
}


.slide::after{
    content:"";
    position:absolute;
    top:0; left:0;
    width:100%;
    height:100%;
    background: rgba(0, 0, 0, 0.62); 
    z-index:1;
}



.slide.active{
    opacity:1;
    z-index:2;
}

.center-text{
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%);
    text-align:center;
    color: white;
    z-index:3;
    padding:0 10px;
}
.center-text h1{
    font-size:2.5rem;
    margin-bottom:10px;
}
.center-text p{
    font-size:1.1rem;
    margin-bottom:15px;
}
.center-text a{
    display:inline-block;
    padding:10px 25px;
    background: #fa5406ff;
    color:#000;
    border-radius:5px;
    text-decoration:none;
    font-weight:bold;
}
.center-text a:hover{
    background: #dfccc1ff;
    color:#000;
}

/* Dots navigation */
.dots{
    position:absolute;
    bottom:15px;
    width:100%;
    text-align:center;
    z-index:4;
}
.dots span{
    display:inline-block;
    width:18px;
    height:4px;
    margin:0 5px;
    background: #f7b501ff;
    border-radius:10%;
    cursor:pointer;
    opacity:0.5;
    transition:opacity 0.3s;
}
.dots span.active{
    opacity:1;
}

@media(max-width:1024px){
    .center-text h1{font-size:2rem;}
    .center-text p{font-size:1rem;}
    .slider{height:45vh;}
}
@media(max-width:768px){
    .center-text h1{font-size:1.5rem;}
    .center-text p{font-size:0.9rem;}
    .slider{height:40vh;}
}
@media(max-width:480px){
    .center-text h1{font-size:1.2rem;}
    .center-text p{font-size:0.8rem;}
    .slider{height:35vh;}
    .center-text a{padding:8px 18px;font-size:0.9rem;}
}


/* Contact Section */
.contact-container { max-width:1200px; margin:20px auto; display:flex; flex-wrap:wrap; gap:50px; padding:0 10px; }
.contact-form, .contact-info-info { background: translate; padding:30px; border-radius:10px; flex:1; min-width:300px; box-shadow:0 4px 10px rgba(0,0,0,0.1); }
.contact-form h2, .contact-info-info h2 { margin-bottom:20px; color:#333; }
.contact-form input, .contact-form textarea { width:100%; padding:12px; margin-bottom:15px; border:1px solid #ccc; border-radius:5px; resize:none; }
.contact-form button { padding:12px 25px; background: #007bff; color:#fff; border:none; border-radius:5px; cursor:pointer; }
.contact-form button:hover { background:#0056b3; }
.message { margin-bottom:15px; padding:10px; border-radius:5px; }
.success { background:#d4edda; color:#155724; }
.error { background: #f8d7da; color: #721c24; }
.contact-info-info p { margin:10px 0; font-size:16px; color:#555; }
iframe { width:100%; height:250px; border:0; border-radius:10px; }
@media(max-width:768px){ .contact-container{ flex-direction:column; } }


/* Page heading */
.gallery-title {
    text-align: center;
    margin: 20px 0;
    font-size: 2rem;
    color: #222;
}

/* Gallery container grid */
.media-gallery {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
    padding: 20px;
}

/* Each card */
.gallery-item {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    padding: 15px;
    transition: transform 0.3s, box-shadow 0.3s;
}

.gallery-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

/* Name and description */
.gallery-name {
    font-size: 1.2rem;
    margin-bottom: 8px;
    color: #333;
}
.gallery-desc {
    font-size: 0.95rem;
    color: #555;
    margin-bottom: 12px;
}

/* Media styling */
.gallery-image, .gallery-video {
    width: 100%;
    border-radius: 8px;
    margin-bottom: 10px;
}
.gallery-audio {
    width: 100%;
    margin-top: 5px;
}

/* Responsive text */
@media screen and (max-width: 768px) {
    .gallery-name {
        font-size: 1.1rem;
    }
    .gallery-desc {
        font-size: 0.9rem;
    }
}

</style>