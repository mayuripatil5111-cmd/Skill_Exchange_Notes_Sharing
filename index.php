<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<!-- FlexSlider CSS -->
<link rel="stylesheet" href="css/flexslider.css">
<link rel="stylesheet" href="css/home.css">

<!-- jQuery -->
<script src="js/jquery.min.js"></script>
<!-- FlexSlider JS -->
<script src="js/jquery.flexslider-min.js"></script>

<script>
$(window).on('load', function () {
  $('.flexslider').flexslider({
    animation: "fade",
    slideshowSpeed: 4000,
    animationSpeed: 600,
    controlNav: true,
    directionNav: false
  });
});
</script>

<!-- ================= SLIDER ================= -->
<div class="slider_container">
  <div class="flexslider">
    <ul class="slides">

      <li>
        <img src="images/slider/slide1.jpg" alt="Slide 1">
        <div class="flex-caption">
          <h2>Skill & Notes Sharing Platform</h2>
          <p>Upload, share and learn anytime, anywhere</p>
        </div>
      </li>

      <li>
        <img src="images/slider/slide2.jpg" alt="Slide 2">
        <div class="flex-caption">
          <h2>Upload Notes & Skills</h2>
          <p>PDF, PPT, DOC, Videos & more</p>
        </div>
      </li>

      <li>
        <img src="images/slider/slide3.jpg" alt="Slide 3">
        <div class="flex-caption">
          <h2>Admin Controlled System</h2>
          <p>Secure & verified content</p>
        </div>
      </li>

      <li>
        <img src="images/slider/slide4.jpg" alt="Slide 4">
        <div class="flex-caption">
          <h2>For Students & Teachers</h2>
          <p>Learn together, grow together</p>
        </div>
      </li>

    </ul>
  </div>
</div>
<!-- =============== SLIDER END =============== -->

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
