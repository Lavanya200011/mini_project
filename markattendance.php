<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$conn = new mysqli("sql212.infinityfree.com", "if0_38879727", "Lavanyath", "if0_38879727_attendance_system");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mark Attendance</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
  setTimeout(() => {
    const alertBox = document.querySelector('[role="alert"]');
    if (alertBox) alertBox.style.display = 'none';
  }, 3000); // 3 seconds
</script>

</head>
<body class="bg-gray-100 min-h-screen">

<?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
  <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
    <strong class="font-bold">Success!</strong>
    <span class="block sm:inline">Attendance submitted successfully.</span>
  </div>
<?php endif; ?>


<header class="bg-white shadow p-4 flex justify-between items-center">
  <h1 class="text-xl font-semibold flex items-center space-x-2">
    📘 <span>Kcem Attendance System</span>
  </h1>
  <nav class="space-x-6">
    <a href="index.php" class="text-blue-600 font-semibold">Dashboard</a>
  </nav>
</header>

<div class="max-w-4xl mx-auto p-6 bg-indigo-500">
  <h1 class="text-3xl font-bold text-center mb-6">📝 Mark Attendance</h1>

  <?php if (!isset($_POST['section_id'])): ?>
    <form method="POST" action="">
      <div class="grid md:grid-cols-2 gap-4 mb-6">
        <div>
          <label class="block font-semibold mb-1">Department</label>
          <select name="dept_id" id="deptSelect" class="w-full p-2 border rounded" required>
            <option value="">-- Select Department --</option>
            <?php
            $res = $conn->query("SELECT * FROM departments");
            while ($row = $res->fetch_assoc()) {
              echo "<option value='{$row['dept_id']}'>{$row['dept_name']}</option>";
            }
            ?>
          </select>
        </div>
        <div>
          <label class="block font-semibold mb-1">Section</label>
          <select name="section_id" id="sectionSelect" class="w-full p-2 border rounded" required>
            <option value="">-- Select Section --</option>
          </select>
        </div>
        <div>
          <label class="block font-semibold mb-1">Lecture No</label>
          <input type="number" name="lecture" class="w-full p-2 border rounded" required min="1" max="8">
        </div>
        <div>
          <label class="block font-semibold mb-1">Subject</label>
          <input type="text" name="subject" class="w-full p-2 border rounded" required>
         <!--
          <select name="subject" id="subjectselect" class="w-full p-2 border rounded" required>
            <option value="">-- Select Section --</option>
            <option value="Osy">Osy</option>
            <option value="Daa">Daa</option>
            <option value="Py">Py</option>
            <option value="P&s">P&s</option>
            <option value="Bhr">Bhr</option>
            </select> -->
        </div>
        <div class="md:col-span-2">
          <label class="block font-semibold mb-1">Date</label>
          <input type="date" name="date" class="w-full p-2 border rounded" required>
        </div>
      </div>
      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Load Students</button>
    </form>

    <!-- JavaScript to dynamically update sections -->
    <script>
      document.getElementById('deptSelect').addEventListener('change', function () {
        const deptId = this.value;
        const sectionSelect = document.getElementById('sectionSelect');
        sectionSelect.innerHTML = '<option>Loading...</option>';

        fetch(`get_sections.php?dept_id=${deptId}`)
          .then(res => res.text())
          .then(data => {
            sectionSelect.innerHTML = data || '<option>No sections available</option>';
          })
          .catch(err => {
            sectionSelect.innerHTML = '<option>Error loading sections</option>';
            console.error(err);
          });
      });
    </script>

  <?php else: ?>
    <?php
    $section_id = $_POST['section_id'];
    $lecture = $_POST['lecture'];
    $subject = $_POST['subject'];
    $date = $_POST['date'];
    $students = $conn->query("SELECT * FROM students WHERE section_id =$section_id ORDER BY roll_no ASC;");
    

    ?>
    <div class="flex justify-center items-center min-h-screen bg-gray-50 px-4">
  <form method="POST" action="submit_attendance.php" class="w-full max-w-2xl space-y-6 bg-white p-6 rounded-lg shadow-md">
    <input type="hidden" name="section_id" value="<?= $section_id ?>">
    <input type="hidden" name="lecture" value="<?= $lecture ?>">
    <input type="hidden" name="subject" value="<?= $subject ?>">
    <input type="hidden" name="date" value="<?= $date ?>">

    <div class="bg-cyan-100 p-4 rounded shadow">
      <h2 class="text-xl font-bold mb-4">Students in Section <?= $section_id ?></h2>

      <?php while ($student = $students->fetch_assoc()): ?>
        <div class="mb-4">
          <strong><?= $student['roll_no'] ?> - <?= $student['name'] ?></strong>
          <div class="flex space-x-6 mt-2">
            <label class="flex items-center space-x-2">
              <input type="radio" name="status[<?= $student['student_id'] ?>]" value="Present" class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
              <span>Present</span>
            </label>
            <label class="flex items-center space-x-2">
              <input type="radio" name="status[<?= $student['student_id'] ?>]" value="Absent" class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500" checked>
              <span>Absent</span>
            </label>
          </div>
        </div>
      <?php endwhile; ?>
    </div>

    <button type="submit" class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">
      Submit Attendance
    </button>
  </form>
</div>

  <?php endif; ?>
</div>
</body>
</html>
