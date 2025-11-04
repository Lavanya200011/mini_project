<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli("sql212.infinityfree.com", "if0_38879727", "Lavanyath", "if0_38879727_attendance_system");

$message = "";

function sanitize_input($input) {
    return trim(htmlspecialchars($input));
}

// Function to generate unique 14-digit PRN
function generateUniquePRN($conn) {
    do {
        $prn = strval(rand(10000000000000, 99999999999999));
        $check = $conn->prepare("SELECT student_id FROM students WHERE student_id = ?");
        $check->bind_param("s", $prn);
        $check->execute();
        $result = $check->get_result();
    } while ($result->num_rows > 0);
    return $prn;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = sanitize_input($_POST['student_id'] ?? '');
    $name = sanitize_input($_POST['name'] ?? '');
    $roll_no = strtoupper(sanitize_input($_POST['roll_no'] ?? ''));

    if (!$student_id || !$name || !$roll_no) {
        $message = "❌ Please fill all fields.";
    } else {
        // Extract section_id from roll number like "CE-A-01"
        $section_code = strtoupper(substr($roll_no, 0, 5)); // "CE-A-" → "CE-A"
        $section_map = [
            "CSE-A" => 1,
            "CSE-B" => 2,
            "AI-A"  => 3,
            "AI-B"  => 4,
            "CE-A"  => 5,
            "CE-B"  => 6,
            "EE-A"  => 7,
            "EE-B"  => 8
        ];
        $section_id = $section_map[$section_code] ?? null;

        if ($section_id === null) {
            $message = "❌ Invalid department-section code in Roll No.";
        } else {
            // Check if student already exists
            $check = $conn->prepare("SELECT * FROM students WHERE student_id = ? OR roll_no = ?");
            $check->bind_param("ss", $student_id, $roll_no);
            $check->execute();
            $result = $check->get_result();

            if ($result->num_rows > 0) {
                $message = "⚠️ Student with this PRN or Roll Number already exists.";
            } else {
                // Insert student
                $stmt = $conn->prepare("INSERT INTO students (student_id, name, roll_no, section_id) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("sssi", $student_id, $name, $roll_no, $section_id);
                if ($stmt->execute()) {
                    $message = "✅ Student added successfully.";
                } else {
                    $message = "❌ Error inserting student: " . $stmt->error;
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Add Student</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
    <h2 class="text-2xl font-bold text-center mb-6 text-blue-700">➕ Add New Student</h2>

    <?php if (!empty($message)): ?>
      <div class="mb-4 text-center font-semibold <?= str_starts_with($message, '✅') ? 'text-green-600' : 'text-red-600' ?>">
        <?= $message ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="add_student.php" class="max-w-md mx-auto bg-white p-6 rounded shadow">
      <label class="block mb-2 font-semibold">PRN Number:</label>
      <input type="text" name="student_id" class="w-full p-2 border mb-4 rounded" required>

      <label class="block mb-2 font-semibold">Full Name:</label>
      <input type="text" name="name" class="w-full p-2 border mb-4 rounded" required>

      <label class="block mb-2 font-semibold">Roll Number (e.g., CE-A-01):</label>
      <input type="text" name="roll_no" class="w-full p-2 border mb-4 rounded" required>

      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
        Submit
      </button>
    </form>
  </div>

</body>
</html>
