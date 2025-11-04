<?php
session_start();
$isLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Attendance Management for Teachers</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script defer>
    function toggleMenu() {
      const menu = document.getElementById('mobile-menu');
      menu.classList.toggle('hidden');
    }

 
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
    dots[i].classList.remove("bg-gray-800");
    dots[i].classList.add("bg-gray-400");
  }

  slides[slideIndex - 1].classList.remove("opacity-0");
  slides[slideIndex - 1].classList.add("opacity-100");
  dots[slideIndex - 1].classList.remove("bg-gray-400");
  dots[slideIndex - 1].classList.add("bg-gray-800");
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
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
  </style>
</head>
<body class="bg-gray-800 text-white">
  <!-- Navbar -->
  <nav class="bg-white text-black px-4 py-4">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
      <div class="flex items-center space-x-4">
        <img src="kcem.png" alt="Logo" class="h-16 w-16">
        <span class="font-bold text-lg">KCEM</span>
      </div>
      <div class="hidden md:flex space-x-6">
        <a href="#" class="hover:text-blue-600">Home Page</a>
        <a href="#" class="hover:text-blue-600">College Website</a>
        <a href="feedback.php" class="hover:text-blue-600">Feedback</a>
        <a href="createclass.php" class="hover:text-blue-600">Create New Class</a>
        <!-- <a href="add_student.php" class="hover:text-blue-600">add your details</a> -->

      </div>
      <div class="hidden md:block">
        <?php if (!$isLoggedIn): ?>
          <a href="login.html" class="bg-black text-white px-4 py-2 rounded" id="loginbtn">Login</a>
        <?php else: ?>
          <a href="logout.php" class="bg-red-600 text-white px-4 py-2 rounded">Logout</a>
        <?php endif; ?>
      </div>
      <div class="md:hidden">
        <button onclick="toggleMenu()" class="focus:outline-none">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
        </button>
      </div>
    </div>
    <!-- Mobile Menu -->
    <div id="mobile-menu" class="md:hidden hidden mt-4 px-4 space-y-2">
      <a href="#" class="block hover:text-blue-600">Home Page</a>
      <a href="#" class="block hover:text-blue-600">College Website</a>
      <a href="feedback.php" class="hover:text-blue-600">Feedback</a>
      <a href="createclass.php" class="block hover:text-blue-600">Create New Class</a>
      <?php if (!$isLoggedIn): ?>
        <a href="login.html" class="block bg-black text-white px-4 py-2 mt-2 rounded">Sign Up/Login</a>
      <?php else: ?>
        <a href="logout.php" class="block bg-red-600 text-white px-4 py-2 mt-2 rounded">Logout</a>
      <?php endif; ?>
    </div>
  </nav>


<div class="relative bg-gray-600">
  <!-- Slideshow Section -->
  <div class="relative max-w-full mx-auto overflow-hidden">
  <!-- Slides -->
  <div class="relative w-full h-64 sm:h-80 md:h-[500px]">
    <div class="slide absolute w-full h-full opacity-100 transition-opacity duration-700">
      <img src="attendance.jpg" class="w-full h-full object-cover" />
    </div>
    <div class="slide absolute w-full h-full opacity-0 transition-opacity duration-700">
      <img src="kcem.png" class="w-full h-full object-cover" />
    </div>
  </div>


  <!-- Dots -->
  <div class="flex justify-center mt-3 space-x-2">
    <span class="dot w-4 h-4 rounded-full bg-gray-400 cursor-pointer" onclick="currentSlide(1)"></span>
    <span class="dot w-4 h-4 rounded-full bg-gray-400 cursor-pointer" onclick="currentSlide(2)"></span>
  </div>
</div>


    <!-- Hero Section OVER Slideshow -->
    <section class="absolute inset-0 flex flex-col items-center justify-center text-center px-4 z-10">
      <div class="bg-black bg-opacity-60 p-6 rounded-lg max-w-3xl">
        <p class="text-sm tracking-wide uppercase text-gray-300">Attendance</p>
        <h1 class="text-3xl md:text-4xl font-bold mt-2 mb-4 text-white">KCEM Attendance Management</h1>
        <p class="text-gray-300 text-base md:text-lg">
          This platform allows teachers to easily input attendance records. Additionally, they can generate attendance reports in PDF format for their records.
        </p>
      </div>
    </section>

  </div>
</div>



<br>

<section class="text-white body-font">
  <div class="container px-5 py-24 mx-auto">
    <div class="flex flex-wrap -m-4 text-center item-center justify-center">
      <div class="p-4 sm:w-1/4 w-1/2">
        <h2 class="title-font font-medium sm:text-4xl text-3xl text-white">xxx</h2>
        <h3 class="leading-relaxed text-white">Total Boys</h3>
      </div>
      <div class="p-4 sm:w-1/4 w-1/2">
        <h2 class="title-font font-medium sm:text-4xl text-3xl text-white">xxx</h2>
        <h3 class="leading-relaxed text-white">Total Girls</h3>
      </div>
      <div class="p-4 sm:w-1/4 w-1/2">
        <h2 class="title-font font-medium sm:text-4xl text-3xl text-white">xxx</h2>
        <h3 class="leading-relaxed text-white ">Total Students</h3>
      </div>
    </div>
  </div>
</section>


      <hr><hr><br><br>

    <!-- This button is ALWAYS visible -->
    <section>
<div class="flex justify-center">
  <a class="inline-block w-auto text-center min-w-[200px] px-6 py-4 text-white transition-all rounded-md shadow-xl sm:w-auto bg-gradient-to-r from-blue-600 to-blue-500 hover:bg-gradient-to-b dark:shadow-blue-900 shadow-blue-200 hover:shadow-2xl hover:shadow-blue-400" 
     href="checkattendance.php">
    Check your Attendance info
  </a>
</div>


<!-- These buttons only show if logged in -->
<?php if ($isLoggedIn): ?>

<div id="teacheracc" class="flex flex-col items-center justify-center gap-5 mt-6 md:flex-row md:gap-10">
  <a class="inline-block w-auto text-center min-w-[200px] px-6 py-4 text-white transition-all rounded-md shadow-xl bg-gradient-to-r from-blue-600 to-blue-500 hover:bg-gradient-to-b dark:shadow-blue-900 shadow-blue-200 hover:shadow-2xl hover:shadow-blue-400" href="markattendance.php">
    Input Attendance
  </a>

  <a class="inline-block w-auto text-center min-w-[200px] px-6 py-4 text-white transition-all rounded-md shadow-xl bg-gradient-to-r from-blue-600 to-blue-500 hover:bg-gradient-to-b dark:shadow-blue-900 shadow-blue-200 hover:shadow-2xl hover:shadow-blue-400" href="attendancereport.php">
    Get Attendance Report
  </a>
</div>
<?php endif; ?>
  </section>

<!-- hero section collage information-->

  <section class="text-gray-600 body-font">
  <div class="container px-5 py-24 mx-auto flex flex-wrap">
    <div class="flex flex-wrap -mx-4 mt-auto mb-auto lg:w-1/2 sm:w-2/3 content-start sm:pr-10">
      <div class="w-full sm:p-4 px-4 mb-6">
  <h3 class="title-font font-medium text-xl mb-2 text-white">Smart Attendance Monitoring System</h3>
  <div class="leading-relaxed text-white">
    This system simplifies the process of marking, managing, and reviewing attendance records. With subject wise tracking, real-time updates, and report generation features, it ensures transparency and efficiency for both students and faculty.
  </div>
</div>

      <div class="p-4 sm:w-1/2 lg:w-1/4 w-1/2">
        <h2 class="title-font font-medium text-3xl text-white">XXX</h2>
        <p class="leading-relaxed text-white">CSE</p>
      </div>
      <div class="p-4 sm:w-1/2 lg:w-1/4 w-1/2">
        <h2 class="title-font font-medium text-3xl text-white">XXX</h2>
        <p class="leading-relaxed text-white">CE</p>
      </div>
      <div class="p-4 sm:w-1/2 lg:w-1/4 w-1/2">
        <h2 class="title-font font-medium text-3xl text-white">XXX</h2>
        <p class="leading-relaxed text-white">EE</p>
      </div>
      <div class="p-4 sm:w-1/2 lg:w-1/4 w-1/2">
        <h2 class="title-font font-medium text-3xl text-white">XXX</h2>
        <p class="leading-relaxed text-white">AI</p>
      </div>
    </div>
   <div class="lg:w-1/2 sm:w-1/3 w-full rounded-lg overflow-hidden mt-6 sm:mt-0 relative h-64 sm:h-80 md:h-96">
  <div class="slideshow1 relative w-full h-full">
    <img src="attendance.jpg" class="slideshow1-slide absolute w-full h-full object-cover object-center opacity-100 transition-opacity duration-2000">
    <img src="Kcem_image.jpg" class="slideshow1-slide absolute w-full h-full object-cover object-center opacity-0 transition-opacity duration-2000">
  </div>
</div>

  </div>
</section>




<!-- THis is the hero section-->
<section class="text-gray-600 body-font">
  <div class="container px-5 py-24 mx-auto flex flex-wrap">

    <!-- Step 1: Teacher Login -->
<div class="flex relative pt-10 pb-20 sm:items-center md:w-2/3 mx-auto">
  <div class="h-full w-6 absolute inset-0 flex items-center justify-center">
    <div class="h-full w-1 bg-gray-200 pointer-events-none"></div>
  </div>
  <div class="flex-shrink-0 w-6 h-6 rounded-full mt-10 sm:mt-0 inline-flex items-center justify-center bg-indigo-500 text-white relative z-10 title-font font-medium text-sm">1</div>
  <div class="flex-grow md:pl-8 pl-6 flex sm:items-center items-start flex-col sm:flex-row">
    <div class="flex-shrink-0 w-24 h-24 bg-indigo-100 text-indigo-500 rounded-full inline-flex items-center justify-center">
      <svg fill="none" stroke="currentColor" stroke-width="2" class="w-12 h-12" viewBox="0 0 24 24">
        <path d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4z"></path>
        <path d="M4 20v-1a4 4 0 014-4h8a4 4 0 014 4v1"></path>
      </svg>
    </div>
    <div class="flex-grow sm:pl-6 mt-6 sm:mt-0">
      <h2 class="font-medium title-font text-gray-300 mb-1 text-xl">Teacher Login & Authentication</h2>
      <p class="leading-relaxed">Faculty members can securely log in to access attendance forms, student lists, and reporting tools.</p>
    </div>
  </div>
</div>


    <!-- Step 2: Attendance Marking -->
    <div class="flex relative pb-20 sm:items-center md:w-2/3 mx-auto">
      <div class="h-full w-6 absolute inset-0 flex items-center justify-center">
        <div class="h-full w-1 bg-gray-200 pointer-events-none"></div>
      </div>
      <div class="flex-shrink-0 w-6 h-6 rounded-full mt-10 sm:mt-0 inline-flex items-center justify-center bg-indigo-500 text-white relative z-10 title-font font-medium text-sm">2</div>
      <div class="flex-grow md:pl-8 pl-6 flex sm:items-center items-start flex-col sm:flex-row">
        <div class="flex-shrink-0 w-24 h-24 bg-indigo-100 text-indigo-500 rounded-full inline-flex items-center justify-center">
<svg fill="none" stroke="currentColor" stroke-width="2" class="w-12 h-12" viewBox="0 0 24 24">
<path d="M9 11H7v2h2v2h2v-2h2v-2h-2V9H9z"></path>
<path d="M12 22c5.52 0 10-4.48 10-10S17.52 2 12 2 2 6.48 2 12s4.48 10 10 10z"></path>
</svg>
</div>
<div class="flex-grow sm:pl-6 mt-6 sm:mt-0">
<h2 class="font-medium title-font text-gray-300 mb-1 text-xl">Daily Attendance Marking</h2>
<p class="leading-relaxed">Faculty can mark attendance lecture-wise with department, section, and subject selection.</p>
</div>
</div>
</div>

<!-- Step 3: View Reports -->
<div class="flex relative pb-20 sm:items-center md:w-2/3 mx-auto">
      <div class="h-full w-6 absolute inset-0 flex items-center justify-center">
        <div class="h-full w-1 bg-gray-200 pointer-events-none"></div>
      </div>
      <div class="flex-shrink-0 w-6 h-6 rounded-full mt-10 sm:mt-0 inline-flex items-center justify-center bg-indigo-500 text-white relative z-10 title-font font-medium text-sm">3</div>
      <div class="flex-grow md:pl-8 pl-6 flex sm:items-center items-start flex-col sm:flex-row">
        <div class="flex-shrink-0 w-24 h-24 bg-indigo-100 text-indigo-500 rounded-full inline-flex items-center justify-center">
          <svg fill="none" stroke="currentColor" stroke-width="2" class="w-12 h-12" viewBox="0 0 24 24">
            <path d="M3 10h18M9 21V3m6 18V3"></path>
          </svg>
        </div>
        <div class="flex-grow sm:pl-6 mt-6 sm:mt-0">
          <h2 class="font-medium title-font text-gray-300 mb-1 text-xl">View Attendance</h2>
          <p class="leading-relaxed">Students can view their attendance on the basis of date month wise <br>  date range, subject, or month.</p>
        </div>
      </div>
    </div>

    <!-- Step 4: Feedback & Suggestions -->
    <div class="flex relative pb-10 sm:items-center md:w-2/3 mx-auto">
      <div class="h-full w-6 absolute inset-0 flex items-center justify-center">
        <div class="h-full w-1 bg-gray-200 pointer-events-none"></div>
      </div>
      <div class="flex-shrink-0 w-6 h-6 rounded-full mt-10 sm:mt-0 inline-flex items-center justify-center bg-indigo-500 text-white relative z-10 title-font font-medium text-sm">4</div>
      <div class="flex-grow md:pl-8 pl-6 flex sm:items-center items-start flex-col sm:flex-row">
        <div class="flex-shrink-0 w-24 h-24 bg-indigo-100 text-indigo-500 rounded-full inline-flex items-center justify-center">
          <svg fill="none" stroke="currentColor" stroke-width="2" class="w-12 h-12" viewBox="0 0 24 24">
            <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path>
            <circle cx="12" cy="7" r="4"></circle>
          </svg>
        </div>
        <div class="flex-grow sm:pl-6 mt-6 sm:mt-0">
          <h2 class="font-medium title-font text-gray-300 mb-1 text-xl">Suggestions & Feedback</h2>
          <p class="leading-relaxed">Users can share feedback through the built-in form, stored securely in the backend database.</p>
        </div>
      </div>
    </div>

    <!-- Step 5: Attendance Report as PDF -->
<div class="flex relative pb-10 sm:items-center md:w-2/3 mx-auto">
  <div class="h-full w-6 absolute inset-0 flex items-center justify-center">
    <div class="h-full w-1 bg-gray-200 pointer-events-none"></div>
  </div>
  <div class="flex-shrink-0 w-6 h-6 rounded-full mt-10 sm:mt-0 inline-flex items-center justify-center bg-indigo-500 text-white relative z-10 title-font font-medium text-sm">5</div>
  <div class="flex-grow md:pl-8 pl-6 flex sm:items-center items-start flex-col sm:flex-row">
    <div class="flex-shrink-0 w-24 h-24 bg-indigo-100 text-indigo-500 rounded-full inline-flex items-center justify-center">
      <svg fill="none" stroke="currentColor" stroke-width="2" class="w-12 h-12" viewBox="0 0 24 24">
        <path d="M12 20h9"></path>
        <path d="M12 4v16"></path>
        <path d="M4 20h8"></path>
        <path d="M4 4h8"></path>
      </svg>
    </div>
    <div class="flex-grow sm:pl-6 mt-6 sm:mt-0">
      <h2 class="font-medium title-font text-gray-300 mb-1 text-xl">Attendance Report as PDF</h2>
      <p class="leading-relaxed">Teachers can export lecture-wise or monthly attendance reports in clean, printable PDF format with a single click.</p>
    </div>
  </div>
</div>

  </div>
</section>



  <!-- Footer -->
  <footer class="bg-white text-black py-10 px-4">
    <div class="max-w-6xl mx-auto grid md:grid-cols-4 gap-8">
      <div>
        <img src="kcem.png" alt="" class="h-48 max-w-65">
      </div>
      <div>
        <h4 class="font-semibold mb-2">developer team</h4>
        <ul class="text-sm space-y-1">
          <li><a href="#" class="hover:text-blue-600">Lavanya Thawkar</a></li>
          <li><a href="#" class="hover:text-blue-600">Akash Durutkar</a></li>
          <li><a href="#" class="hover:text-blue-600">Rahul Kosame</a></li>
        </ul>
      </div>
      <div>
        <h4 class="font-semibold mb-2">Technology Used</h4>
        <ul class="text-sm space-y-1">
          <li><a href="#" class="hover:text-blue-600">HTML5</a></li>
          <li><a href="#" class="hover:text-blue-600">Tailwind CSS</a></li>
          <li><a href="#" class="hover:text-blue-600">Javacsript</a></li>
          <li><a href="#" class="hover:text-blue-600">php</a></li>
          <li><a href="#" class="hover:text-blue-600">SQL(MyPhpAdmin)</a></li>
        </ul>
      </div>
      <div>
        <h4 class="font-semibold mb-2">Other Information</h4>
        <ul class="text-sm space-y-1">
          <li><a href="#" class="hover:text-blue-600">xxxxxx</a></li>
          <li><a href="#" class="hover:text-blue-600">xxxxxx</a></li>
          <li><a href="#" class="hover:text-blue-600">xxxxxx</a></li>
        </ul>
      </div>
    </div>
    <div class="text-center text-xs text-gray-500 mt-10">
      <p>&copy; 2025 KCEM. All rights reserved.</p>
      <div class="space-x-4 mt-2">
        <a href="#" class="hover:underline">Terms of Service</a>
      </div>
    </div>
  </footer>
</body>
</html>
