<?php
$conn = new mysqli("sql212.infinityfree.com", "if0_38879727", "Lavanyath", "if0_38879727_attendance_system");
$student_id = $_GET['student_id'];
$subject = $_GET['subject'];
$month = $_GET['month'];
$year = $_GET['year'];

$sql = "SELECT date, status FROM attendance WHERE student_id = ? AND subject = ? AND MONTH(date) = ? AND YEAR(date) = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isii", $student_id, $subject, $month, $year);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<ul class='list-disc pl-5'>";
    while ($row = $result->fetch_assoc()) {
        $color = $row['status'] === 'Present' ? 'text-green-600' : 'text-red-600';
        echo "<li class='$color'>{$row['date']} — {$row['status']}</li>";
    }
    echo "</ul>";
} else {
    echo "<p class='text-red-600'>No records found for this subject.</p>";
}

$stmt->close();
$conn->close();
?>
