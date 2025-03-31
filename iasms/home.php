<?php
// Include database connection (Not used for statistics in this version)
include 'database_connection/database_connection.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Industrial Attachment Management System</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', Arial, sans-serif;
  }

  body {
    background: #f5f7fa;
    color: #333;
    line-height: 1.6;
    overflow-x: hidden;
  }

  /* Header */
  header {
    background: linear-gradient(90deg, #006605, #008a39);
    color: #fff;
    padding: 20px 0;
    position: sticky;
    top: 0;
    z-index: 1000;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  }

  .container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 20px;
  }

  .header-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .logo {
    display: flex;
    align-items: center;
  }

  .logo h1 {
    font-size: 24px;
    font-weight: 600;
  }

  .logo img {
    height: 50px;
    margin-right: 10px;
  }

  nav {
    display: flex;
    align-items: center;
  }

  .nav-menu {
    list-style: none;
    display: flex;
    gap: 20px;
  }

  .nav-menu li {
    position: relative;
  }

  .nav-menu a {
    color: #fff;
    text-decoration: none;
    font-weight: 500;
    padding: 10px 15px;
    transition: color 0.3s;
    cursor: pointer;
  }

  .nav-menu a:hover {
    color: #f39c12;
  }

  .dropdown {
    position: absolute;
    top: 100%;
    left: 0;
    background: #fff;
    color: #333;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    display: none;
    min-width: 200px;
    border-radius: 5px;
  }

  .dropdown a {
    color: #333;
    padding: 10px;
    display: block;
  }

  .dropdown a:hover {
    background: #f39c12;
    color: #fff;
  }

  .nav-menu li:hover .dropdown {
    display: block;
  }

  .btn {
    background: #f39c12;
    padding: 10px 20px;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    font-weight: 500;
    transition: background 0.3s;
  }

  .btn:hover {
    background: #e08b0e;
  }

  /* Hero Section */
  .hero {
    position: relative;
    text-align: center;
    padding: 120px 20px;
    color: #fff;
    overflow: hidden;
    min-height: 400px;
  }

  .hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1;
  }

  .slideshow-container {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
    background: #ccc;
    /* Fallback color if images fail to load */
  }

  .slide {
    position: absolute;
    width: 100%;
    height: 100%;
    opacity: 0;
  }

  .slide img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    /* Prevents extra space below image */
  }

  .slide img.error {
    border: 2px solid red;
    /* Visual indicator for failed image load */
  }

  .fade {
    animation: fadeEffect 15s infinite;
  }

  @keyframes fadeEffect {
    0% {
      opacity: 0;
    }

    20% {
      opacity: 1;
    }

    33% {
      opacity: 1;
    }

    53% {
      opacity: 0;
    }

    100% {
      opacity: 0;
    }
  }

  .slide:nth-child(1) {
    animation-delay: 0s;
  }

  .slide:nth-child(2) {
    animation-delay: 3.75s;
  }

  .slide:nth-child(3) {
    animation-delay: 7.5s;
  }

  .slide:nth-child(4) {
    animation-delay: 11.25s;
  }

  .hero .container {
    position: relative;
    z-index: 2;
  }

  .hero h2 {
    font-size: 48px;
    margin-bottom: 20px;
    animation: fadeInDown 1s ease;
  }

  .hero p {
    font-size: 20px;
    margin-bottom: 30px;
    animation: fadeInUp 1s ease 0.5s;
  }

  .hero .cta {
    background: #f39c12;
    padding: 15px 40px;
    font-size: 18px;
    border-radius: 5px;
    transition: transform 0.3s, background 0.3s;
  }

  .hero .cta:hover {
    background: #e08b0e;
    transform: scale(1.05);
  }

  /* About Section */
  .about {
    padding: 80px 20px;
    background: #fff;
    text-align: center;
  }

  .about h2 {
    font-size: 36px;
    margin-bottom: 20px;
    color: #006605;
  }

  .about p {
    max-width: 800px;
    margin: 0 auto;
    font-size: 18px;
  }

  .about-content {
    display: none;
    max-width: 800px;
    margin: 20px auto;
    font-size: 16px;
  }

  .about-content.active {
    display: block;
  }

  /* Statistics Section */
  .stats {
    background: #008a39;
    color: #fff;
    padding: 80px 20px;
    text-align: center;
  }

  .stats h2 {
    font-size: 36px;
    margin-bottom: 40px;
  }

  .stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 30px;
    max-width: 1200px;
    margin: 0 auto;
  }

  .stat-box {
    padding: 20px;
    transition: transform 0.3s;
  }

  .stat-box:hover {
    transform: translateY(-10px);
  }

  .stat-box i {
    font-size: 48px;
    color: #f39c12;
    margin-bottom: 15px;
  }

  .stat-box h3 {
    font-size: 32px;
    margin: 10px 0;
  }

  .stat-box p {
    font-size: 16px;
  }

  /* Contact Section */
  .contact {
    padding: 80px 20px;
    background: #fff;
    text-align: center;
  }

  .contact h2 {
    font-size: 36px;
    margin-bottom: 20px;
    color: #006605;
  }

  .contact p {
    margin-bottom: 30px;
    font-size: 18px;
  }

  .contact ul {
    list-style: none;
    max-width: 600px;
    margin: 0 auto;
  }

  .contact ul li {
    margin: 15px 0;
    font-size: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
  }

  .contact ul li i {
    color: #f39c12;
  }

  /* Footer */
  footer {
    background: #1a1a1a;
    color: #fff;
    padding: 40px 20px;
    text-align: center;
  }

  footer p {
    font-size: 14px;
  }

  footer a {
    color: #f39c12;
    text-decoration: none;
  }

  footer a:hover {
    text-decoration: underline;
  }

  /* Animations */
  @keyframes fadeInDown {
    from {
      opacity: 0;
      transform: translateY(-20px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(20px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    .header-container {
      flex-direction: column;
      gap: 15px;
    }

    .nav-menu {
      flex-direction: column;
      gap: 10px;
    }

    .dropdown {
      position: static;
      box-shadow: none;
    }

    .hero h2 {
      font-size: 32px;
    }

    .hero p {
      font-size: 16px;
    }

    .stats-grid {
      grid-template-columns: 1fr;
    }
  }
  </style>
</head>

<body>
  <!-- Header Section -->
  <header>
    <div class="container header-container">
      <div class="logo">
        <h1>Industrial Attachment Management System</h1>
      </div>
      <nav>
        <ul class="nav-menu">
          <li><a href="#home">Home</a></li>
          <li>
            <a href="#about">About</a>
            <div class="dropdown">
              <a href="#" onclick="showContent('mission')">Our Mission</a>
              <a href="#" onclick="showContent('team')">Our Team</a>
            </div>
          </li>
          <li><a href="#stats">Statistics</a></li>
          <li><a href="#contact">Contact</a></li>
          <li><a href="/index.php" class="btn">Register</a></li>
          <li><a href="/index.php" class="btn">Login</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <!-- Hero Section with Slideshow -->
  <section class="hero" id="home">
    <div class="slideshow-container">
      <div class="slide fade">
        <img src="images/images1.jpg" alt="Image 1">
      </div>
      <div class="slide fade">
        <img src="images/images2.jpg" alt="Image 2">
      </div>
      <div class="slide fade">
        <img src="images/images3.jpg" alt="Image 3">
      </div>
      <div class="slide fade">
        <img src="images/images4.jpg" alt="Image 4">
      </div>
    </div>
    <div class="container">
      <h2>Welcome to IASMS</h2>
      <p>Effortlessly manage industrial attachment applications, logbooks, and evaluations.</p>
      <a href="/index.php" class="cta">Get Started</a>
    </div>
  </section>

  <!-- About Us Section -->
  <section class="about" id="about">
    <div class="container">
      <h2>About Us</h2>
      <p>IASMS is a platform designed to streamline industrial attachment processes for students, supervisors, and
        administrators.</p>
      <div id="mission" class="about-content">
        <h3>Our Mission</h3>
        <p>Our mission is to bridge the gap between academia and industry by providing a seamless, efficient platform
          for managing industrial attachments, ensuring students gain practical experience and companies benefit from
          fresh talent.</p>
      </div>
      <div id="team" class="about-content">
        <h3>Our Team</h3>
        <p>We are a dedicated group of educators, developers, and industry experts working together to enhance the
          industrial attachment experience. Our team is committed to innovation, support, and excellence.</p>
      </div>
    </div>
  </section>

  <!-- Statistics Section -->
  <section class="stats" id="stats">
    <div class="container">
      <h2>Statistics</h2>
      <div class="stats-grid">
        <div class="stat-box">
          <i class="fa fa-users"></i>
          <h3 id="students-count">0</h3>
          <p>Registered Students</p>
        </div>
        <div class="stat-box">
          <i class="fa fa-building"></i>
          <h3 id="companies-count">0</h3>
          <p>Companies Offering Attachments</p>
        </div>
        <div class="stat-box">
          <i class="fa fa-book"></i>
          <h3 id="logbooks-count">0</h3>
          <p>Logbook Entries Submitted</p>
        </div>
        <div class="stat-box">
          <i class="fa fa-check-circle"></i>
          <h3 id="completed-count">0</h3>
          <p>Attachments Completed</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact Section -->
  <section class="contact" id="contact">
    <div class="container">
      <h2>Contact Us</h2>
      <p>Need assistance? Get in touch with us.</p>
      <ul>
        <li><i class="fa fa-envelope"></i> Email: support@university.edu</li>
        <li><i class="fa fa-phone"></i> Phone: +254 700 123 456</li>
        <li><i class="fa fa-map-marker"></i> Location: Egerton University, Industrial Attachment Office</li>
      </ul>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <p>© 2025 Industrial Attachment Management System. All rights reserved.</p>
  </footer>

  <!-- JavaScript for Dynamic Stats, Content Toggle, and Slideshow -->
  <script>
  document.addEventListener("DOMContentLoaded", function() {
    // Stats Animation
    let statsSection = document.querySelector(".stats");
    let statsCounters = {
      "students-count": 1500,
      "companies-count": 250,
      "logbooks-count": 4500,
      "completed-count": 1200,
    };

    let hasAnimated = false;

    function animateCount(id, targetValue, duration = 2000) {
      let start = 0;
      let increment = Math.ceil(targetValue / (duration / 50));
      let element = document.getElementById(id);
      let interval = setInterval(() => {
        start += increment;
        if (start >= targetValue) {
          element.textContent = targetValue.toLocaleString();
          clearInterval(interval);
        } else {
          element.textContent = start.toLocaleString();
        }
      }, 50);
    }

    let observer = new IntersectionObserver(
      function(entries) {
        if (entries[0].isIntersecting && !hasAnimated) {
          hasAnimated = true;
          for (let id in statsCounters) {
            animateCount(id, statsCounters[id]);
          }
        }
      }, {
        threshold: 0.5
      }
    );

    observer.observe(statsSection);

    // Slideshow initialization and error handling
    const slides = document.querySelectorAll('.slide');
    slides.forEach((slide, index) => {
      slide.style.animation = `fadeEffect 15s infinite ${index * 3.75}s`;

      const img = slide.querySelector('img');
      img.onerror = function() {
        console.log(`Failed to load image: ${img.src}`);
        img.classList.add('error');
        img.src = 'https://via.placeholder.com/1350x400?text=Image+Not+Found'; // Fallback image
      };
      img.onload = function() {
        console.log(`Successfully loaded image: ${img.src}`);
      };
    });
  });

  // Function to toggle About content
  function showContent(sectionId) {
    const contents = document.querySelectorAll('.about-content');
    contents.forEach(content => {
      content.classList.remove('active');
    });
    const selectedContent = document.getElementById(sectionId);
    if (selectedContent) {
      selectedContent.classList.add('active');
    }
  }
  </script>
</body>

</html>