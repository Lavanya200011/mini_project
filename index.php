<?php
session_start();
$isLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>KCEM Smart Attendance Management</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
    /* Using Inter font is already good, adding a fallback */
    body {
      font-family: 'Inter', sans-serif;
      transition: background-color 0.3s ease;
    }
    
    /* Deep Shadow for floating effect (Neumorphism inspiration) */
    .soft-card-shadow {
      box-shadow: 8px 8px 15px rgba(0, 0, 0, 0.1), -8px -8px 15px rgba(255, 255, 255, 0.8);
      border: 1px solid rgba(255, 255, 255, 0.5); /* Subtle border for definition */
    }

    /* Hero Background Pattern */
    .bg-hero-pattern {
      background-color: #f3f4f6;
      background-image: radial-gradient(rgba(209, 213, 219, 0.5) 1px, transparent 1px), radial-gradient(rgba(209, 213, 219, 0.5) 1px, transparent 1px);
      background-size: 30px 30px;
      background-position: 0 0, 15px 15px;
    }

    /* Enhanced Text Shadow for Hero */
    .text-shadow-hero {
      text-shadow: 0 4px 6px rgba(0, 0, 0, 0.15);
    }
  </style>
  <script defer>
    function toggleMenu() {
      const menu = document.getElementById('mobile-menu');
      menu.classList.toggle('hidden');
    }

    // --- Slideshow logic retained for hero and collage image ---
    let slideIndex = 1;

    function showSlides(n) {
      const slides = document.getElementsByClassName("slide");
      const dots = document.getElementsByClassName("dot");

      if (n > slides.length) slideIndex = 1;
      if (n < 1) slideIndex = slides.length;

      for (let i = 0; i < slides.length; i++) {
        slides[i].classList.remove("opacity-100");
        slides[i].classList.add("opacity-0");
      }

      for (let i = 0; i < dots.length; i++) {
        dots[i].classList.remove("bg-indigo-600"); 
        dots[i].classList.add("bg-gray-400");
      }

      slides[slideIndex - 1].classList.remove("opacity-0");
      slides[slideIndex - 1].classList.add("opacity-100");
      dots[slideIndex - 1].classList.remove("bg-gray-400");
      dots[slideIndex - 1].classList.add("bg-indigo-600"); 
    }

    function plusSlides(n) {
      showSlides(slideIndex += n);
    }

    function currentSlide(n) {
      showSlides(slideIndex = n);
    }

    document.addEventListener("DOMContentLoaded", () => {
      showSlides(slideIndex);
      setInterval(() => plusSlides(1), 3000); // 3 seconds auto-slide
    });

    let slideshow1Index = 0;

    function slideshow1AutoSlide() {
      const slides = document.getElementsByClassName("slideshow1-slide");

      for (let i = 0; i < slides.length; i++) {
        slides[i].classList.remove("opacity-100");
        slides[i].classList.add("opacity-0");
      }

      slideshow1Index++;
      if (slideshow1Index > slides.length) slideshow1Index = 1;

      slides[slideshow1Index - 1].classList.remove("opacity-0");
      slides[slideshow1Index - 1].classList.add("opacity-100");
    }

    // Initial setup
    document.addEventListener("DOMContentLoaded", () => {
      slideshow1AutoSlide();
      setInterval(slideshow1AutoSlide, 3000); // Change slide every 3 seconds
    });
  </script>
</head>
<body class="bg-gray-100 text-gray-800">

  <!-- Navbar -->
  <nav class="bg-white shadow-xl px-4 py-4 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
      <div class="flex items-center space-x-3">
        <img src="kcem.png" alt="Logo" class="h-10 w-10 rounded-full border-2 border-indigo-500">
        <span class="font-extrabold text-2xl text-indigo-700 tracking-tight">KCEM ATTENDANCE</span>
      </div>
      <div class="hidden md:flex space-x-8 font-medium text-gray-700">
        <a href="#" class="hover:text-indigo-600 transition duration-150 transform hover:scale-105">Home</a>
        <a href="#" class="hover:text-indigo-600 transition duration-150 transform hover:scale-105">College Site</a>
        <a href="feedback.php" class="hover:text-indigo-600 transition duration-150 transform hover:scale-105">Feedback</a>
        <a href="createclass.php" class="hover:text-indigo-600 transition duration-150 transform hover:scale-105">New Class</a>
      </div>
      <div class="hidden md:block">
        <?php if (!$isLoggedIn): ?>
          <a href="login.html" class="bg-indigo-600 text-white px-6 py-2 rounded-xl hover:bg-indigo-700 transition duration-300 font-semibold shadow-xl shadow-indigo-500/50" id="loginbtn">Teacher Login</a>
        <?php else: ?>
          <a href="logout.php" class="bg-red-500 text-white px-6 py-2 rounded-xl hover:bg-red-600 transition duration-300 font-semibold shadow-xl shadow-red-500/50">Logout</a>
        <?php endif; ?>
      </div>
      <div class="md:hidden">
        <button onclick="toggleMenu()" class="text-gray-600 hover:text-indigo-600 focus:outline-none">
          <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
        </button>
      </div>
    </div>
    <!-- Mobile Menu -->
    <div id="mobile-menu" class="md:hidden hidden mt-3 px-2 space-y-2 bg-white rounded-xl shadow-xl p-4">
      <a href="#" class="block text-gray-700 hover:text-indigo-600">Home</a>
      <a href="#" class="block text-gray-700 hover:text-indigo-600">College Site</a>
      <a href="feedback.php" class="block text-gray-700 hover:text-indigo-600">Feedback</a>
      <a href="createclass.php" class="block text-gray-700 hover:text-indigo-600">New Class</a>
      <?php if (!$isLoggedIn): ?>
        <a href="login.html" class="block bg-indigo-600 text-white px-4 py-2 mt-2 rounded-xl text-center font-semibold">Teacher Login</a>
      <?php else: ?>
        <a href="logout.php" class="block bg-red-500 text-white px-4 py-2 mt-2 rounded-xl text-center font-semibold">Logout</a>
      <?php endif; ?>
    </div>
  </nav>


<!-- Hero Section (Clean and BOLD) -->
<div class="bg-white pt-24 pb-28 shadow-inner mb-16">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
    <p class="text-lg tracking-widest uppercase text-indigo-600 font-extrabold mb-3">
      Digital Attendance Solution
    </p>
    <h1 class="text-6xl md:text-7xl lg:text-8xl font-black mt-3 mb-8 text-gray-900 text-shadow-hero">
      Effortless Record Keeping at 
      <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-700 to-cyan-500">KCEM</span>
    </h1>
    <p class="text-gray-500 text-xl md:text-2xl max-w-4xl mx-auto mb-12">
      Empowering faculty with a modern platform to manage attendance records, ensuring superior accuracy and immediate report generation.
    </p>

    <!-- Hero Slideshow -->
    <div class="relative w-full h-80 md:h-96 mx-auto rounded-3xl overflow-hidden shadow-2xl shadow-indigo-400/50">
      <div class="relative w-full h-full">
        <div class="slide absolute w-full h-full opacity-100 transition-opacity duration-700">
          <img src="attendance.jpg" class="w-full h-full object-cover" alt="Attendance marking interface" />
        </div>
        <div class="slide absolute w-full h-full opacity-0 transition-opacity duration-700">
          <img src="kcem.png" class="w-full h-full object-cover p-10 bg-gray-50" alt="KCEM Logo slide" />
        </div>
      </div>
      <div class="absolute bottom-4 left-0 right-0 flex justify-center space-x-2">
        <span class="dot w-3 h-3 rounded-full bg-gray-400 cursor-pointer" onclick="currentSlide(1)"></span>
        <span class="dot w-3 h-3 rounded-full bg-gray-400 cursor-pointer" onclick="currentSlide(2)"></span>
      </div>
    </div>
  </div>
</div>


<!-- Statistics Section (Glassmorphism/Soft Card Design) -->
<section class="text-gray-800 py-16 bg-gray-100">
  <div class="container px-5 mx-auto">
    <h2 class="text-4xl font-extrabold text-center text-gray-900 mb-12">Key Institutional Data</h2>
    <div class="flex flex-wrap -m-4 text-center justify-center">
      
      <!-- Card 1: Total Boys -->
      <div class="p-4 sm:w-1/4 w-1/2 bg-gray-100 m-3 rounded-3xl soft-card-shadow transition duration-500 transform hover:scale-105 cursor-pointer">
        <h2 class="title-font font-black sm:text-6xl text-5xl text-indigo-700">xxx</h2>
        <h3 class="leading-relaxed text-gray-600 mt-3 font-semibold text-lg">Total Boys</h3>
      </div>
      
      <!-- Card 2: Total Girls -->
      <div class="p-4 sm:w-1/4 w-1/2 bg-gray-100 m-3 rounded-3xl soft-card-shadow transition duration-500 transform hover:scale-105 cursor-pointer">
        <h2 class="title-font font-black sm:text-6xl text-5xl text-indigo-700">xxx</h2>
        <h3 class="leading-relaxed text-gray-600 mt-3 font-semibold text-lg">Total Girls</h3>
      </div>
      
      <!-- Card 3: Total Students -->
      <div class="p-4 sm:w-1/4 w-1/2 bg-gray-100 m-3 rounded-3xl soft-card-shadow transition duration-500 transform hover:scale-105 cursor-pointer">
        <h2 class="title-font font-black sm:text-6xl text-5xl text-indigo-700">xxx</h2>
        <h3 class="leading-relaxed text-gray-600 mt-3 font-semibold text-lg">Total Students</h3>
      </div>
    </div>
  </div>
</section>

<!-- Call to Action Buttons Section (Vibrant, Clear Hierarchy) -->
<section class="py-20 bg-hero-pattern">
  <div class="flex justify-center flex-wrap gap-8 max-w-7xl mx-auto px-4">
    
    <!-- 1. Primary Action (Student/Guest) - Vibrant Cyan/Teal -->
    <a class="inline-block w-full sm:w-auto text-center min-w-[260px] px-10 py-4 text-white font-extrabold text-xl rounded-2xl shadow-2xl transition duration-300 transform hover:scale-105 bg-gradient-to-r from-cyan-500 to-teal-500 hover:from-cyan-600 hover:to-teal-600 shadow-cyan-500/50"
      href="checkattendance.php">
      Check Your Attendance Status
    </a>

    <!-- Teacher Actions (Logged In) -->
    <?php if ($isLoggedIn): ?>

    <!-- 2. Secondary Action (Teacher Input) - Deep Indigo -->
    <a class="inline-block w-full sm:w-auto text-center min-w-[260px] px-10 py-4 text-white font-extrabold text-xl rounded-2xl shadow-2xl transition duration-300 transform hover:scale-105 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 shadow-indigo-500/50" href="markattendance.php">
      Input Today's Attendance
    </a>

    <!-- 3. Tertiary Action (Reporting) - Action Red/Pink -->
    <a class="inline-block w-full sm:w-auto text-center min-w-[260px] px-10 py-4 text-white font-extrabold text-xl rounded-2xl shadow-2xl transition duration-300 transform hover:scale-105 bg-gradient-to-r from-red-600 to-pink-600 hover:from-red-700 hover:to-pink-700 shadow-red-500/50" href="attendancereport.php">
      Generate Reports (PDF)
    </a>

    <?php endif; ?>
  </div>
</section>

<!-- College Information Section (Modern Split Layout) -->
<section class="text-gray-800 body-font py-24 bg-white">
  <div class="container px-5 mx-auto flex flex-wrap items-center">
    
    <!-- Image Slideshow -->
    <div class="lg:w-1/2 w-full rounded-3xl overflow-hidden shadow-2xl shadow-gray-400/50 h-96 order-1 lg:order-2">
      <div class="slideshow1 relative w-full h-full">
        <img src="attendance.jpg" class="slideshow1-slide absolute w-full h-full object-cover object-center opacity-100 transition-opacity duration-2000" alt="Attendance system screenshot">
        <img src="Kcem_image.jpg" class="slideshow1-slide absolute w-full h-full object-cover object-center opacity-0 transition-opacity duration-2000" alt="College building image">
      </div>
    </div>
    
    <!-- Text Content -->
    <div class="lg:w-1/2 sm:w-2/3 mt-12 lg:mt-0 lg:pr-16 content-start order-2 lg:order-1">
      <div class="w-full mb-10">
        <h3 class="title-font font-extrabold text-5xl mb-4 text-gray-900">Platform Benefits</h3>
        <p class="leading-relaxed text-gray-600 text-xl">
          This system streamlines the administrative burden of attendance, providing subject-wise tracking, real-time data updates, and robust, customizable report generation features. It ensures full transparency and efficiency for students and faculty alike.
        </p>
      </div>

      <!-- Department Stats -->
      <div class="flex flex-wrap text-center border-t border-b border-gray-200 py-8">
        <div class="p-4 w-1/2 sm:w-1/4">
          <h2 class="title-font font-extrabold text-3xl text-indigo-700">XXX</h2>
          <p class="leading-relaxed text-gray-600">CSE</p>
        </div>
        <div class="p-4 w-1/2 sm:w-1/4">
          <h2 class="title-font font-extrabold text-3xl text-indigo-700">XXX</h2>
          <p class="leading-relaxed text-gray-600">CE</p>
        </div>
        <div class="p-4 w-1/2 sm:w-1/4">
          <h2 class="title-font font-extrabold text-3xl text-indigo-700">XXX</h2>
          <p class="leading-relaxed text-gray-600">EE</p>
        </div>
        <div class="p-4 w-1/2 sm:w-1/4">
          <h2 class="title-font font-extrabold text-3xl text-indigo-700">XXX</h2>
          <p class="leading-relaxed text-gray-600">AI</p>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- Process Steps Section (Neumorphic Timeline)-->
<section class="text-gray-800 body-font bg-gray-100 py-24">
  <div class="container px-5 mx-auto flex flex-wrap">
    <h2 class="text-4xl font-extrabold text-center w-full text-gray-900 mb-16">The Simple 5-Step Workflow</h2>
    
    <!-- Steps container -->
    <div class="md:w-2/3 mx-auto">
      
      <!-- Step 1: Teacher Login -->
      <div class="flex relative pb-16 sm:items-center">
        <div class="h-full w-6 absolute inset-0 flex items-center justify-center">
          <div class="h-full w-1 bg-gray-300 pointer-events-none"></div>
        </div>
        <div class="flex-shrink-0 w-12 h-12 rounded-full mt-10 sm:mt-0 inline-flex items-center justify-center bg-indigo-600 text-white relative z-10 font-bold text-xl shadow-xl">1</div>
        <div class="flex-grow md:pl-8 pl-6 flex sm:items-center items-start flex-col sm:flex-row bg-gray-100 p-6 rounded-2xl soft-card-shadow transition duration-500 hover:shadow-2xl ml-4 cursor-pointer">
          <div class="flex-shrink-0 w-16 h-16 bg-indigo-100 text-indigo-600 rounded-full inline-flex items-center justify-center mb-4 sm:mb-0 shadow-inner">
            <svg fill="none" stroke="currentColor" stroke-width="2" class="w-8 h-8" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4z"></path><path d="M4 20v-1a4 4 0 014-4h8a4 4 0 014 4v1"></path></svg>
          </div>
          <div class="flex-grow sm:pl-6">
            <h2 class="font-black title-font text-gray-900 mb-1 text-2xl">Teacher Login & Authentication</h2>
            <p class="leading-relaxed text-gray-600">Faculty members securely log in to access all class management and reporting tools.</p>
          </div>
        </div>
      </div>


      <!-- Step 2: Attendance Marking -->
      <div class="flex relative pb-16 sm:items-center">
        <div class="h-full w-6 absolute inset-0 flex items-center justify-center">
          <div class="h-full w-1 bg-gray-300 pointer-events-none"></div>
        </div>
        <div class="flex-shrink-0 w-12 h-12 rounded-full mt-10 sm:mt-0 inline-flex items-center justify-center bg-indigo-600 text-white relative z-10 font-bold text-xl shadow-xl">2</div>
        <div class="flex-grow md:pl-8 pl-6 flex sm:items-center items-start flex-col sm:flex-row bg-gray-100 p-6 rounded-2xl soft-card-shadow transition duration-500 hover:shadow-2xl ml-4 cursor-pointer">
          <div class="flex-shrink-0 w-16 h-16 bg-indigo-100 text-indigo-600 rounded-full inline-flex items-center justify-center mb-4 sm:mb-0 shadow-inner">
            <svg fill="none" stroke="currentColor" stroke-width="2" class="w-8 h-8" viewBox="0 0 24 24"><path d="M9 11H7v2h2v2h2v-2h2v-2h-2V9H9z"></path><path d="M12 22c5.52 0 10-4.48 10-10S17.52 2 12 2 2 6.48 2 12s4.48 10 10 10z"></path></svg>
          </div>
          <div class="flex-grow sm:pl-6">
            <h2 class="font-black title-font text-gray-900 mb-1 text-2xl">Daily Attendance Marking</h2>
            <p class="leading-relaxed text-gray-600">Mark attendance lecture-wise after selecting the correct department, section, and subject via the interface.</p>
          </div>
        </div>
        </div>

      <!-- Step 3: View Reports -->
      <div class="flex relative pb-16 sm:items-center">
        <div class="h-full w-6 absolute inset-0 flex items-center justify-center">
          <div class="h-full w-1 bg-gray-300 pointer-events-none"></div>
        </div>
        <div class="flex-shrink-0 w-12 h-12 rounded-full mt-10 sm:mt-0 inline-flex items-center justify-center bg-indigo-600 text-white relative z-10 font-bold text-xl shadow-xl">3</div>
        <div class="flex-grow md:pl-8 pl-6 flex sm:items-center items-start flex-col sm:flex-row bg-gray-100 p-6 rounded-2xl soft-card-shadow transition duration-500 hover:shadow-2xl ml-4 cursor-pointer">
          <div class="flex-shrink-0 w-16 h-16 bg-indigo-100 text-indigo-600 rounded-full inline-flex items-center justify-center mb-4 sm:mb-0 shadow-inner">
            <svg fill="none" stroke="currentColor" stroke-width="2" class="w-8 h-8" viewBox="0 0 24 24"><path d="M3 10h18M9 21V3m6 18V3"></path></svg>
          </div>
          <div class="flex-grow sm:pl-6">
            <h2 class="font-black title-font text-gray-900 mb-1 text-2xl">View Attendance Status</h2>
            <p class="leading-relaxed text-gray-600">Students and faculty can view attendance data, filterable by date range, subject, or month.</p>
          </div>
        </div>
      </div>

      <!-- Step 4: Feedback & Suggestions -->
      <div class="flex relative pb-16 sm:items-center">
        <div class="h-full w-6 absolute inset-0 flex items-center justify-center">
          <div class="h-full w-1 bg-gray-300 pointer-events-none"></div>
        </div>
        <div class="flex-shrink-0 w-12 h-12 rounded-full mt-10 sm:mt-0 inline-flex items-center justify-center bg-indigo-600 text-white relative z-10 font-bold text-xl shadow-xl">4</div>
        <div class="flex-grow md:pl-8 pl-6 flex sm:items-center items-start flex-col sm:flex-row bg-gray-100 p-6 rounded-2xl soft-card-shadow transition duration-500 hover:shadow-2xl ml-4 cursor-pointer">
          <div class="flex-shrink-0 w-16 h-16 bg-indigo-100 text-indigo-600 rounded-full inline-flex items-center justify-center mb-4 sm:mb-0 shadow-inner">
            <svg fill="none" stroke="currentColor" stroke-width="2" class="w-8 h-8" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
          </div>
          <div class="flex-grow sm:pl-6">
            <h2 class="font-black title-font text-gray-900 mb-1 text-2xl">Suggestions & Feedback</h2>
            <p class="leading-relaxed text-gray-600">Share suggestions or report issues securely through the built-in feedback form.</p>
          </div>
        </div>
      </div>

      <!-- Step 5: Attendance Report as PDF -->
      <div class="flex relative sm:items-center">
        <div class="h-full w-6 absolute inset-0 flex items-center justify-center">
          <!-- No connecting line for the last step -->
        </div>
        <div class="flex-shrink-0 w-12 h-12 rounded-full mt-10 sm:mt-0 inline-flex items-center justify-center bg-indigo-600 text-white relative z-10 font-bold text-xl shadow-xl">5</div>
        <div class="flex-grow md:pl-8 pl-6 flex sm:items-center items-start flex-col sm:flex-row bg-gray-100 p-6 rounded-2xl soft-card-shadow transition duration-500 hover:shadow-2xl ml-4 cursor-pointer">
          <div class="flex-shrink-0 w-16 h-16 bg-indigo-100 text-indigo-600 rounded-full inline-flex items-center justify-center mb-4 sm:mb-0 shadow-inner">
            <svg fill="none" stroke="currentColor" stroke-width="2" class="w-8 h-8" viewBox="0 0 24 24"><path d="M12 20h9"></path><path d="M12 4v16"></path><path d="M4 20h8"></path><path d="M4 4h8"></path></svg>
          </div>
          <div class="flex-grow sm:pl-6">
            <h2 class="font-black title-font text-gray-900 mb-1 text-2xl">Attendance Report as PDF</h2>
            <p class="leading-relaxed text-gray-600">Export detailed, printable reports in PDF format with a single click for official records.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


  <!-- Footer (Dark, High-Contrast) -->
  <footer class="bg-gray-900 text-white py-16 px-4 mt-16">
    <div class="max-w-6xl mx-auto grid md:grid-cols-4 gap-10 border-b border-gray-700 pb-10">
      <div class="space-y-4">
        <img src="kcem.png" alt="KCEM Logo" class="h-16 w-16 rounded-full border-2 border-cyan-400 shadow-lg">
        <p class="text-lg font-bold text-indigo-400">KCEM ATTENDANCE</p>
        <p class="text-sm text-gray-400">Smart Attendance Monitoring System</p>
      </div>
      <div>
        <h4 class="font-bold text-xl mb-5 text-cyan-400">Developer Team</h4>
        <ul class="text-md space-y-3 text-gray-300">
          <li><a href="#" class="hover:text-cyan-300 transition duration-150">Lavanya Thawkar</a></li>
          <li><a href="#" class="hover:text-cyan-300 transition duration-150">Akash Durutkar</a></li>
          <li><a href="#" class="hover:text-cyan-300 transition duration-150">Rahul Kosame</a></li>
        </ul>
      </div>
      <div>
        <h4 class="font-bold text-xl mb-5 text-cyan-400">Technology Stack</h4>
        <ul class="text-md space-y-3 text-gray-300">
          <li><a href="#" class="hover:text-cyan-300 transition duration-150">HTML5 / CSS3</a></li>
          <li><a href="#" class="hover:text-cyan-300 transition duration-150">Tailwind CSS</a></li>
          <li><a href="#" class="hover:text-cyan-300 transition duration-150">PHP / Javacsript</a></li>
          <li><a href="#" class="hover:text-cyan-300 transition duration-150">SQL (MyPhpAdmin)</a></li>
        </ul>
      </div>
      <div>
        <h4 class="font-bold text-xl mb-5 text-cyan-400">Other Information</h4>
        <ul class="text-md space-y-3 text-gray-300">
          <li><a href="#" class="hover:text-cyan-300 transition duration-150">College Info</a></li>
          <li><a href="#" class="hover:text-cyan-300 transition duration-150">Privacy Policy</a></li>
          <li><a href="#" class="hover:text-cyan-300 transition duration-150">Sitemap</a></li>
        </ul>
      </div>
    </div>
    <div class="text-center text-sm text-gray-500 mt-10">
      <p>&copy; 2025 KCEM. All rights reserved.</p>
    </div>
  </footer>
</body>
</html>
