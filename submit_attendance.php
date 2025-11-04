<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli("sql212.infinityfree.com", "if0_38879727", "Lavanyath", "if0_38879727_attendance_system");

// Collect form inputs
$date = $_POST['date'];
$lecture = $_POST['lecture'];
$subject = $_POST['subject'];
$statusArray = $_POST['status']; // status[student_id] = 'Present'

// Insert attendance records
foreach ($statusArray as $student_id => $status) {
  $stmt = $conn->prepare("INSERT INTO attendance (student_id, date, lecture, subject, status) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("isiss", $student_id, $date, $lecture, $subject, $status);
  $stmt->execute();
}

// Redirect to markattendance page with success query param (optional)
header("Location: markattendance.php?success=1");
exit(); // Always use exit after header redirection
?>
