<html>
<head>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<div class="max-w-xl mx-auto mt-20 bg-yellow-100 text-center border-l-4 border-yellow-500 text-yellow-800 p-6 rounded">
  <h2 class="text-xl font-bold mb-2">🚧 Module Under Development</h2>
    <p>This section is currently being built. Please check back soon!</p>
    </div>
    </html>



    <?php
$conn = new mysqli("sql212.infinityfree.com", "if0_38879727", "Lavanyath", "if0_38879727_attendance_system");

$results = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $start = $_POST['start_date'];
    $end = $_POST['end_date'];
    $subject = $_POST['subject'];

    $query = "SELECT a.*, s.name, s.roll_no 
              FROM attendance a 
              JOIN students s ON a.student_id = s.student_id 
              WHERE a.date BETWEEN ? AND ?";

    if (!empty($subject)) {
        $query .= " AND a.subject = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $start, $end, $subject);
    } else {
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $start, $end);
    }

    $stmt->execute();
    $results = $stmt->get_result();
}
?>

<!--
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Filter Attendance</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">

  <h1 class="text-2xl font-bold mb-6 text-center">📅 Filter Attendance Records</h1>

  <form method="POST" class="bg-white p-6 rounded shadow max-w-3xl mx-auto mb-10">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
      <div>
        <label class="block font-semibold">Start Date</label>
        <input type="date" name="start_date" required class="w-full p-2 border rounded">
      </div>
      <div>
        <label class="block font-semibold">End Date</label>
        <input type="date" name="end_date" required class="w-full p-2 border rounded">
      </div>
      <div>
        <label class="block font-semibold">Subject (optional)</label>
        <input type="text" name="subject" class="w-full p-2 border rounded" placeholder="e.g. Math">
      </div>
    </div>
    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Filter</button>
  </form>

  <?php if (!empty($results) && $results->num_rows > 0): ?>
    <div class="bg-white p-6 rounded shadow max-w-5xl mx-auto overflow-auto">
      <table class="w-full border border-gray-300">
        <thead>
          <tr class="bg-gray-200">
            <th class="p-2 border">Roll No</th>
            <th class="p-2 border">Name</th>
            <th class="p-2 border">Date</th>
            <th class="p-2 border">Lecture</th>
            <th class="p-2 border">Subject</th>
            <th class="p-2 border">Status</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $results->fetch_assoc()): ?>
            <tr class="text-center">
              <td class="p-2 border"><?= $row['roll_no'] ?></td>
              <td class="p-2 border"><?= $row['name'] ?></td>
              <td class="p-2 border"><?= $row['date'] ?></td>
              <td class="p-2 border"><?= $row['lecture'] ?></td>
              <td class="p-2 border"><?= $row['subject'] ?></td>
              <td class="p-2 border"><?= $row['status'] ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  <?php elseif ($_SERVER["REQUEST_METHOD"] === "POST"): ?>
    <div class="text-center text-red-600 font-semibold mt-4">❌ No attendance records found for the selected filter.</div>
  <?php endif; ?>

</body>
</html> -->
