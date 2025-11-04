<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$conn = new mysqli("sql212.infinityfree.com", "if0_38879727", "Lavanyath", "if0_38879727_attendance_system");

// Include FPDF
require('fpdf/fpdf/fpdf.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dept_id = $_POST['dept_id'];
    $section_id = $_POST['section_id'];
    $subject = $_POST['subject'];
    $month = $_POST['month'];
    $year = $_POST['year'];

    // Fetch students
    $sql = "SELECT students.student_id, students.name, students.roll_no FROM students
            JOIN sections ON students.section_id = sections.section_id
            JOIN departments ON sections.dept_id = departments.dept_id
            WHERE departments.dept_id = ? AND sections.section_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $dept_id, $section_id);
    $stmt->execute();
    $students = $stmt->get_result();

    // Create PDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);

    $pdf->Cell(0, 10, "Attendance Report - $subject ($month/$year)", 0, 1, 'C');
    $pdf->Ln(10);

    // Table Headers
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(15, 10, 'S.No', 1);
    $pdf->Cell(50, 10, 'Name', 1);
    $pdf->Cell(30, 10, 'Roll No', 1);
    $pdf->Cell(25, 10, 'Present', 1);
    $pdf->Cell(25, 10, 'Absent', 1);
    $pdf->Cell(30, 10, 'Attendance %', 1);
    $pdf->Ln();

    $pdf->SetFont('Arial', '', 12);
    $sno = 1;

    while ($student = $students->fetch_assoc()) {
        $student_id = $student['student_id'];

        // Count Present
        $present_sql = "SELECT COUNT(*) as present_days FROM attendance 
                        WHERE student_id = ? AND subject = ? AND status = 'Present' 
                        AND MONTH(date) = ? AND YEAR(date) = ?";
        $present_stmt = $conn->prepare($present_sql);
        $present_stmt->bind_param("isii", $student_id, $subject, $month, $year);
        $present_stmt->execute();
        $present_result = $present_stmt->get_result();
        $present_days = $present_result->fetch_assoc()['present_days'];

        // Count Total Records
        $total_sql = "SELECT COUNT(*) as total_days FROM attendance 
                      WHERE student_id = ? AND subject = ? 
                      AND MONTH(date) = ? AND YEAR(date) = ?";
        $total_stmt = $conn->prepare($total_sql);
        $total_stmt->bind_param("isii", $student_id, $subject, $month, $year);
        $total_stmt->execute();
        $total_result = $total_stmt->get_result();
        $total_days = $total_result->fetch_assoc()['total_days'];

        $absent_days = $total_days - $present_days;
        $attendance_percentage = $total_days > 0 ? round(($present_days / $total_days) * 100, 2) : 0;

        // Table Rows
        $pdf->Cell(15, 10, $sno++, 1);
        $pdf->Cell(50, 10, $student['name'], 1);
        $pdf->Cell(30, 10, $student['roll_no'], 1);
        $pdf->Cell(25, 10, $present_days, 1);
        $pdf->Cell(25, 10, $absent_days, 1);
        $pdf->Cell(30, 10, "$attendance_percentage%", 1);
        $pdf->Ln();
    }

    $pdf->Output('D', 'attendance_report.pdf');
    exit();
}
?>

<!-- HTML Frontend -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Generate Attendance Report</title>
  <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="bg-gray-100 min-h-screen">
 <!-- Header -->
 <header class="bg-white shadow p-4 flex justify-between items-center">
    <h1 class="text-xl font-semibold flex items-center space-x-2">
      📘 <span>Kcem Attendance System</span>
    </h1>
    <nav class="space-x-6">
      <a href="index.php" class="text-blue-600 font-semibold">Dashboard</a>
    </nav>
  </header>

<div class="flex items-center justify-center mt-6 ">
  <div class="bg-indigo-500 p-8 rounded shadow-lg w-full max-w-lg">
    <h1 class="text-2xl font-bold mb-6 text-center text-gray-700">📄 Attendance Report Generator</h1>

    <form method="POST" action="generate_report.php" class="space-y-4">
      <!-- Department -->
<div>
  <label class="block font-semibold mb-1">Department</label>
  <select name="dept_id" id="deptSelect" required class="w-full p-2 border rounded">
    <option value="">-- Select Department --</option>
    <?php
    $departments = $conn->query("SELECT * FROM departments");
    while ($row = $departments->fetch_assoc()) {
        echo "<option value='{$row['dept_id']}'>{$row['dept_name']}</option>";
    }
    ?>
  </select>
</div>

<!-- Section - to be dynamically filled -->
<div>
  <label class="block font-semibold mb-1">Section</label>
  <select name="section_id" id="sectionSelect" required class="w-full p-2 border rounded">
    <option value="">-- Select Section --</option>
  </select>
</div>


      <div>
        <label class="block font-semibold mb-1">Subject</label>
        <input type="text" name="subject" placeholder="Enter Subject" required class="w-full p-2 border rounded">
      </div>

      <div class="flex gap-4">
        <div class="flex-1">
          <label class="block font-semibold mb-1">Month (1-12)</label>
          <input type="number" name="month" min="1" max="12" required class="w-full p-2 border rounded">
        </div>
        <div class="flex-1">
          <label class="block font-semibold mb-1">Year (e.g., 2025)</label>
          <input type="number" name="year" required class="w-full p-2 border rounded">
        </div>
      </div>

      <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded">Generate PDF Report</button>
    </form>
  </div>
        </div>




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

</body>
</html>
