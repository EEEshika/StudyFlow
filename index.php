<?php
session_start();

if(isset($_SESSION['user_id'])){
    header("Location: Views/dashboard/dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>

StudyFlow | Student Productivity System

</title>

<link
rel="stylesheet"
href="Assets/Css/landing.css">

<link
rel="preconnect"
href="https://fonts.googleapis.com">

<link
rel="preconnect"
href="https://fonts.gstatic.com"
crossorigin>

<link
href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet">

</head>

<body>

<!-- =========================
NAVBAR
========================= -->

<header>

<nav class="navbar">

<div class="logo">

StudyFlow

</div>

<ul class="nav-links">

<li>

<a href="#home">

Home

</a>

</li>

<li>

<a href="#features">

Features

</a>

</li>

<li>

<a href="#about">

About

</a>

</li>

<li>

<a
class="login-btn"
href="Views/Auth/login.php">

Login

</a>

</li>

<li>

<a
class="register-btn"
href="Views/Auth/register.php">

Register

</a>

</li>

</ul>

</nav>

</header>

<!-- =========================
HERO SECTION
========================= -->

<section
class="hero"
id="home">

<div class="hero-left">

<h1>

Study Smarter.

<br>

Stay Organized.

</h1>

<p>

StudyFlow helps students manage
subjects, tasks, notes and study
sessions from one simple dashboard.

</p>

<div class="hero-buttons">

<a
href="Views/Auth/register.php"
class="btn-primary">

Get Started

</a>

<a
href="Views/Auth/login.php"
class="btn-secondary">

Login

</a>

</div>

</div>

<div class="hero-right">

<div class="hero-box">

📚

</div>

</div>

</section>

<!-- =========================
FEATURES
========================= -->

<section
class="features"
id="features">

<h2>

Why Choose StudyFlow?

</h2>

<div class="feature-grid">

<div class="feature-card">

<div class="icon">

📚

</div>

<h3>

Manage Subjects

</h3>

<p>

Create and organize all your study subjects
in one place.

</p>

</div>

<div class="feature-card">

<div class="icon">

✅

</div>

<h3>

Task Management

</h3>

<p>

Track assignments, priorities and deadlines
efficiently.

</p>

</div>

<div class="feature-card">

<div class="icon">

📝

</div>

<h3>

Study Notes

</h3>

<p>

Save important notes for each subject and
access them anytime.

</p>

</div>

<div class="feature-card">

<div class="icon">

⏱

</div>

<h3>

Study Sessions

</h3>

<p>

Record your study time and improve your
productivity.

</p>

</div>

</div>

</section>

<!-- =========================
ABOUT
========================= -->

<section
class="about"
id="about">

<div class="about-content">

<h2>

About StudyFlow

</h2>

<p>

StudyFlow is a Student Productivity Management System
developed using PHP, MySQL, HTML, CSS and JavaScript.

It helps students organize subjects, manage tasks,
write notes and track study sessions from a single
dashboard.

</p>

</div>

</section>

<!-- =========================
CALL TO ACTION
========================= -->

<section
class="cta">

<h2>

Ready to Boost Your Productivity?

</h2>

<p>

Join StudyFlow today and organize your study life.

</p>

<a
href="Views/Auth/register.php"
class="btn-primary">

Create Free Account

</a>

</section>

<!-- =========================
FOOTER
========================= -->

<footer>

<p>

© <?php echo date("Y"); ?>

StudyFlow.

Built with ❤️ using PHP & MySQL.

</p>

</footer>

</body>

</html>