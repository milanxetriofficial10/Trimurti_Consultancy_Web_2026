<?php

include "../db/config.php"; // DB connection
include "../includes/top_header.php";
include "../includes/navbar.php"; 

// Fetch Contact Slides
$slides = mysqli_query($conn, "SELECT * FROM contact_slides ORDER BY id DESC");

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
$news = $conn->query("SELECT * FROM top_news ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contact Us</title>
<style>

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
    height: 35px;
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



.slider { 
    max-width:1500px; 
    margin: auto; 
    position:relative; 
    overflow:hidden; 
    border-radius:3px; 
    height:420px; /* Adjust as needed */
}
.slide { 
    display:none; 
    position:relative; 
    height:100%;
}

/* Image with overlay */
.slide img { 
    width:100%; 
    height:100%;
    object-fit:cover; 
    border-radius:3px; 
    display:block;
}

/* Add subtle black overlay */
.slide::before {
    content: '';
    position: absolute;
    top:0; left:0; right:0; bottom:0;
    background: rgba(0, 0, 0, 0.52); /* Adjust darkness here */
    border-radius:10px;
    z-index:1;
}

/* Text centered above overlay */
.slide h2 { 
    position:absolute; 
    top:50%; 
    left:50%; 
    transform:translate(-50%, -50%);
    color: #fcc01bff; 
    font-size:29px;
    text-align:center;
    z-index:2; /* Make sure text is above overlay */
    max-width:90%;
    word-wrap:break-word;
}

/* Responsive adjustments */
@media(max-width:1024px){
    .slider { height:290px; }
    .slide h2 { font-size:20px; }
}
@media(max-width:768px){
    .slider { height:300px; }
    .slide h2 { font-size:18px; }
}
@media(max-width:480px){
    .slider { height:300px; }
    .slide h2 { font-size:16px; }
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
</style>
</head>
<body>

<!-- Slider Section -->
<div class="slider">
    <?php while($slide = mysqli_fetch_assoc($slides)) { ?>
        <div class="slide">
            <img src="../admin/uploads/<?php echo $slide['image']; ?>" alt="<?php echo htmlspecialchars($slide['title']); ?>">
            <h2><?php echo htmlspecialchars($slide['title']); ?></h2>
        </div>
    <?php } ?>
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

<script>
// Simple JS Slider
let slides = document.querySelectorAll('.slide');
let current = 0;
function showSlide(index){
    slides.forEach(s => s.style.display='none');
    slides[index].style.display='block';
}
function nextSlide(){
    current = (current+1) % slides.length;
    showSlide(current);
}
if(slides.length>0){
    showSlide(current);
    setInterval(nextSlide, 3000); // Change slide every 3s
}
</script>

</body>
</html>

<?php include "../includes/footer.php"; ?>