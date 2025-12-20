<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<footer class="clone-footer">

  <div class="footer-top">

    <div class="footer-col">
      <h3>Navigation</h3>
      <ul>
        <li><a href="#">About Us</a></li>
        <li><a href="#">Service</a></li>
        <li><a href="#">Results</a></li>
        <li><a href="#">Notices</a></li>
        <li><a href="#">Contact Us</a></li>
      </ul>
    </div>

    <div class="footer-col">
      <h3>Our Courses</h3>
      <ul>
        <li><a href="#">UK</a></li>
        <li><a href="#">Japan</a></li>
        <li><a href="#">USA</a></li>
        <li><a href="#">Australia</a></li>
        <li><a href="#">UAE</a></li>
      </ul>
    </div>

    <div class="footer-col">
      <h3>Exam Preparation</h3>
      <ul>
        <li><a href="#">Officer First Paper</a></li>
        <li><a href="#">Nayab Subba</a></li>
      </ul>
    </div>

    <div class="footer-col">
      <h3>Quick Links</h3>
      <ul>
        <li><a href="#">Privacy Policy</a></li>
        <li><a href="#">Terms & Condition</a></li>
        <li><a href="#">Public Queries</a></li>
      </ul>
    </div>

    
    <div class="footer-col">
      <h3>Our Supports & Contact Information</h3>
      <ul class="contact-info">
        <li><i class="fa-solid fa-location-dot"></i>Chabahil-07, Kathmandu (Near Pashupati College)</li>
        <li><i class="fa-solid fa-phone"></i>01-5922403</li>
        <li><i class="fa-solid fa-envelope"></i>trimurtiedu.consultancy@gmail.com</li>
        <li><i class="fa-solid fa-mobile-screen"></i>9840536647</li>
      </ul>
    </div>

  </div>

  <hr class="footer-line">

  <!-- Payment + PlayStore + Associate + Social -->
  <div class="footer-middle">

    <div class="footer-box">
      <h4>We Accept This Type Of Payment Gateway</h4>
      <img src="images/khalti.png" class="pay-img">
    </div>

    <div class="footer-box">
      <h4>Trimurti Educational Consultancy </h4>
      <img src="../img /468819674_122128647596461823_8355324234216025560_n__1_-removebg-preview.png" class="play-img">
    </div>

    <div class="footer-box">
      <h4>Our Associate</h4>
      <img src="images/associate.png" class="associate-img">
    </div>

    <div class="footer-box">
      <h4>Social Media</h4>
      <div class="social-icons">
        <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
        <a href="#"><i class="fa-brands fa-twitter"></i></a>
        <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
        <a href="#"><i class="fa-brands fa-instagram"></i></a>
        <a href="#"><i class="fa-brands fa-youtube"></i></a>
      </div>
    </div>

  </div>

  <hr class="footer-line">

  <div class="footer-bottom">
    <p>Copyright © 2025 Trimurti Educational Consultancy (TEC). All Rights Reserved.</p>
  </div>
</footer>
<style>
    .clone-footer {
  background: #e0e8faff;     /* Purple background same look */
  padding: 40px 20px;
  color: #1e0397ff;
  font-family: 'Segoe UI', sans-serif;
}

.footer-top {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  gap: 40px;
}

.footer-col h3 {
  font-size: 20px;
  margin-bottom: 12px;
  border-bottom: 2px solid #ffcc00; /* Yellow underline */
  padding-bottom: 5px;
  display: inline-block;
}

.footer-col ul {
  list-style: none;
  padding: 0;
}

.footer-col ul li {
  margin: 7px 0;
}

.footer-col ul li a {
  color: #39038fff;
  text-decoration: none;
  transition: 0.3s;
}

.footer-col ul li a:hover {
  color: rgba(252, 206, 1, 1);
}

/* Contact Info Icons */
.contact-info li i {
  margin-right: 8px;
}

/* Middle Section */
.footer-line {
  border: none;
  height: 1px;
  background: #ffffff40;
  margin: 30px 0;
}

.footer-middle {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  gap: 40px;
}

.footer-box h4 {
  margin-bottom: 10px;
  font-size: 18px;
}

.pay-img,
.play-img,
.associate-img {
  height: 75px;
  width: auto;
}

.social-icons {
  display: flex;
  gap: 12px;
  height: 44px;
}

.social-icons a {
  color: white;
  background: #6405fdf6;
  padding: 10px 15px;
  border-radius: 50%;
  font-size: 18px;
  transition: 0.3s;
}

.social-icons a:hover {
  background: #7df110f5;
  transform: scale(1.1);
}

/* Bottom Section */
.footer-bottom {
  text-align: center;
  margin-top: 0px;
}

/* RESPONSIVE */
@media (max-width: 992px) {
  .footer-top {
    flex-direction: column;
    text-align: center;
  }

  .footer-middle {
    flex-direction: column;
    text-align: center;
  }
}

@media (max-width: 600px) {
  .social-icons {
    justify-content: center;
  }

  .footer-col h3 {
    font-size: 18px;
  }

  .footer-bottom {
    font-size: 14px;
  }
}

</style>