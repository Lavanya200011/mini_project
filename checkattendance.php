<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Check Attendance</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-sky-200 min-h-screen flex flex-col">


  <!-- Header -->
  <header class="bg-white shadow p-4 flex justify-between items-center">
    <h1 class="text-xl font-semibold flex items-center space-x-2">
      📘 <span>Kcem Attendance System</span>
    </h1>
    <nav class="space-x-6">
      <a href="index.php" class="text-blue-600 font-semibold">Dashboard</a>
    </nav>
  </header>

  <!-- Main Content -->
  <main class="flex-grow flex items-center justify-center p-6">
    <div class="bg-indigo-500 shadow-lg rounded-lg p-8 max-w-md w-full">
      <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">📅 Check Your Attendance</h2>

      <form method="POST" action="check_attendance.php" class="space-y-4">
        <div>
          <label class="block text-white font-semibold mb-1">Student ID</label>
          <input type="number" name="student_id" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
        </div>

        <div>
          <label class="block text-white font-semibold mb-1">Month (1-12)</label>
          <input type="number" name="month" min="1" max="12"  class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
        </div>

       <!-- <div>
          <label class="block text-gray-700 font-semibold mb-1">Semister (1-8)</label>
          <input type="number" name="Semister" min="1" max="8" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
        </div> -->


        <div>
          <label class="block text-white font-semibold mb-1">Year (e.g., 2025)</label>
          <input type="number" name="year" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
        </div>

        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition duration-300">
          Get Attendance
        </button>
      </form>
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-white text-center text-xs p-4 text-gray-500">
    &copy;
