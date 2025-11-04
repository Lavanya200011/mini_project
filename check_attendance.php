<?php 
$conn = new mysqli("sql212.infinityfree.com", "if0_38879727", "Lavanyath", "if0_38879727_attendance_system");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $month = $_POST['month'];
    $year = $_POST['year'];

    // Step 1: Get student name
    $sql1 = "SELECT name FROM students WHERE student_id = ?";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->bind_param("i", $student_id);
    $stmt1->execute();
    $result1 = $stmt1->get_result();

    if ($result1->num_rows === 0) {
        echo "<p>No student found with ID: $student_id</p>";
        exit;
    }

    $row1 = $result1->fetch_assoc();
    $student_name = $row1['name'];

    // Step 2: Get attendance records
    $sql2 = "SELECT * FROM attendance WHERE student_id = ? AND MONTH(date) = ? AND YEAR(date) = ?";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param("iii", $student_id, $month, $year);
    $stmt2->execute();
    $result2 = $stmt2->get_result();

    $total_days = 0;
    $present_days = 0;
    $subject_attendance = [];

    echo '<script src="https://cdn.tailwindcss.com"></script>';
    echo '<div>
    <!-- Header -->
  <header class="bg-white shadow p-4 flex justify-between items-center">
    <h1 class="text-xl font-semibold flex items-center space-x-2">
      📘 <span>Student Attendance System</span>
    </h1>
    <nav class="space-x-6">
      <a href="index.php" class="text-blue-600 font-semibold">Dashboard</a>
    </nav>
  </header>
  </div>';

    echo "<center><h2 class='text-4xl font-bold mt-6'>WELCOME<br> $student_name (ID: $student_id)</h2></center>";

    if ($result2->num_rows > 0) {
        while ($row = $result2->fetch_assoc()) {
            $total_days++;
            if ($row['status'] === 'Present') {
                $present_days++;
            }

            $sub = $row['subject'];
            if (!isset($subject_attendance[$sub])) {
                $subject_attendance[$sub] = ['total' => 0, 'present' => 0];
            }
            $subject_attendance[$sub]['total']++;
            if ($row['status'] === 'Present') {
                $subject_attendance[$sub]['present']++;
            }
        }

        $attendance_percentage = $total_days > 0 ? round(($present_days / $total_days) * 100, 2) : 0;

        echo "<div class='ml-12 mt-4 border-l-4 border-blue-600 h-[150px] mx-auto my-4'>";
        echo "<h3 class='text-lg font-semibold'>Total Classes: $total_days</h3>";
        echo "<h3 class='text-lg font-semibold text-green-600'>Present Days: $present_days</h3>";
        echo "<h3 class='text-lg font-semibold text-blue-600'>Overall Attendance: $attendance_percentage%</h3>";
        echo "</div><hr>";
        echo "<h3 class='font-bold text-2xl text-center'>Here is your attendance summary</h3>";
        echo "<h3 class='text-lg text-gray-700 text-center font-bold'>Month: $month, Year: $year</h3><hr>";


        


        // Subject-wise summary cards
        echo '<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 px-6 mt-10">';

        $subjectIndex = 0;
        foreach ($subject_attendance as $subject => $data) {
            $percentage = round(($data['present'] / $data['total']) * 100, 2);
            echo "<div onclick=\"showSubjectDetails('$subject')\" class='cursor-pointer bg-white border-l-4 border-indigo-600 shadow-md p-5 rounded-xl hover:bg-gray-100 transition-all duration-200'>";
            echo "<h3 class='text-xl font-bold text-gray-800 mb-2'>$subject</h3>";
            echo "<p class='text-gray-600'>Total Classes: {$data['total']}</p>";
            echo "<p class='text-green-600'>Present: {$data['present']}</p>";
            echo "<p class='text-blue-600 font-semibold'>Attendance: $percentage%</p>";
            echo "</div>";
            $subjectIndex++;
        }
        echo '</div>';

    } else {
        echo "<p class='text-center text-red-600 mt-6'>No attendance records found for Student ID: $student_id in the selected month.</p>";
    }

    // Modal HTML
    echo <<<EOD
<div id="subjectModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
  <div class="bg-white w-11/12 md:w-1/2 p-6 rounded-xl shadow-lg relative">
    <button onclick="closeModal()" class="absolute top-2 right-2 text-gray-500 hover:text-black text-2xl">&times;</button>
    <h2 id="modalTitle" class="text-xl font-bold text-indigo-700 mb-4"></h2>
    <div id="modalContent" class="text-gray-800 space-y-2 max-h-96 overflow-y-auto"></div>
  </div>
</div>
EOD;

    // Modal script
    echo <<<EOD
<script>
function showSubjectDetails(subject) {
    fetch('get_subject_attendance.php?subject=' + encodeURIComponent(subject) + '&student_id={$student_id}&month={$month}&year={$year}')
        .then(response => response.text())
        .then(data => {
            document.getElementById('modalTitle').innerText = 'Details for ' + subject;
            document.getElementById('modalContent').innerHTML = data;
            document.getElementById('subjectModal').classList.remove('hidden');
            document.getElementById('subjectModal').classList.add('flex');
        });
}

function closeModal() {
    const modal = document.getElementById('subjectModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
</script>
EOD;

    $stmt1->close();
    $stmt2->close();
    $conn->close();
}
?>
</body>
</html>
