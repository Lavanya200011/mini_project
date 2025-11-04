<?php
// Contact form handling logic
$submitted = false;
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name    = htmlspecialchars($_POST["name"]);
    $dept_year   = htmlspecialchars($_POST["dept_year"]);
    $message = htmlspecialchars($_POST["message"]);
    // For now, we'll just show confirmation
    $submitted = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Feedback</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">
<body class="bg-gray-100 text-gray-800">
  <!-- Header -->
  <header class="bg-white shadow p-4 flex justify-between items-center">
    <h1 class="text-xl font-semibold flex items-center space-x-2">
      📘 <span>Kcem Attendance System</span>
    </h1>
    <nav class="space-x-6">
      <a href="index.php" class="text-blue-600 font-semibold">Dashboard</a>
    </nav>
  </header>
  
  <div class="max-w-xl mx-auto mt-10 bg-indigo-500 shadow-md rounded-lg p-6">
    <h1 class="text-2xl font-bold mb-4 text-center text-white underline">📬SUGGEST US WHAT WE DO Next</h1><br>

    <?php if ($submitted): ?>
      <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
        Thank you, <strong><?= $name ?></strong>! Your message has been received.
      </div>
    <?php endif; ?>

   <form action="givefeedback.php" method="POST" class="space-y-4">
  <div>
    <label for="name" class="block font-medium text-white">Your Name</label>
    <input type="text" id="name" name="name" required class="w-full border rounded px-4 py-2" />
  </div>

  <div>
    <label for="department_year" class="block font-medium text-white">Your Department and Year: Ex.CSE 2nd</label>
    <input type="text" id="dept_year" name="dept_year" required class="w-full border rounded px-4 py-2" />
  </div>

  <div>
    <label for="message" class="block font-medium text-white">Your Suggestion</label>
    <textarea id="message" name="message" rows="4" required class="w-full border rounded px-4 py-2"></textarea>
  </div>

  <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
    Send Feedback
  </button>
</form>

  </div>
</body>
</html>
