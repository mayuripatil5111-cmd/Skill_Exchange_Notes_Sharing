<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<!-- CSS -->
<link rel="stylesheet" href="css/home.css">

<!-- jQuery -->
<script src="js/jquery.min.js"></script>

<!-- ================= IMAGE CARD SLIDER ================= -->
<div class="image-card-container">
  <div class="image-card active">
    <img src="images/slider/slide1.jpg" alt="Slide 1">
    <div class="card-caption">
      <h2>Skill & Notes Sharing Platform</h2>
      <p>Upload, share and learn anytime, anywhere</p>
    </div>
  </div>

  <div class="image-card">
    <img src="images/slider/slide2.jpg" alt="Slide 2">
    <div class="card-caption">
      <h2>Upload Notes & Skills</h2>
      <p>PDF, PPT, DOC, Videos & more</p>
    </div>
  </div>

  <div class="image-card">
    <img src="images/slider/slide3.jpg" alt="Slide 3">
    <div class="card-caption">
      <h2>Admin Controlled System</h2>
      <p>Secure & verified content</p>
    </div>
  </div>

  <div class="image-card">
    <img src="images/slider/slide4.jpg" alt="Slide 4">
    <div class="card-caption">
      <h2>For Students & Teachers</h2>
      <p>Learn together, grow together</p>
    </div>
  </div>
</div>

<!-- ================= FEATURES ================= -->
<section class="features">
  <div class="feature-box">
    <h3>📚 Notes Sharing</h3>
    <p>Upload and download educational notes anytime.</p>
  </div>

  <div class="feature-box">
    <h3>🎓 Skill Exchange</h3>
    <p>Share your skills and learn from others.</p>
  </div>

  <div class="feature-box">
    <h3>🔐 Secure Access</h3>
    <p>Only verified users can upload and access content.</p>
  </div>
</section>

<!-- ================= CTA ================= -->
<section class="cta">
  <h2>Start Learning Today</h2>
  <p>Join our platform and explore shared knowledge</p>
  <a href="signup.php">Get Started</a>
</section>

<?php include 'includes/footer.php'; ?>

<!-- ================= IMAGE CARD JS ================= -->
<script>
let currentIndex = 0;
const cards = document.querySelectorAll('.image-card');

function showNextCard() {
  cards[currentIndex].classList.remove('active');
  currentIndex = (currentIndex + 1) % cards.length;
  cards[currentIndex].classList.add('active');
}

// Change image every 4 seconds
setInterval(showNextCard, 4000);
</script>
