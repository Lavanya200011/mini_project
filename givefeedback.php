<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$submitted = false;
$insertError = false;

// DB connection details — update with your actual credentials
$host = "sql212.infinityfree.com";
$user = "if0_38879727";            // your MySQL username
$pass = "Lavanyath";                // your MySQL password
$db   = "if0_38879727_attendance_system";   // your database name

$conn = new mysqli("sql212.infinityfree.com", "if0_38879727", "Lavanyath", "if0_38879727_attendance_system");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name    = htmlspecialchars($_POST["name"]);
    $dept_year  = htmlspecialchars($_POST["dept_year"]);
    $message = htmlspecialchars($_POST["message"]);

    $stmt = $conn->prepare("INSERT INTO feedbacks (name, dept_year, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $dept_year, $message);

   if ($stmt->execute()) {
    $submitted = true;
    echo "<script>
        alert('We Got Your Feedback');
        window.location.href = 'feedback.php'; // Optional: redirect
    </script>";
} else {
    $insertError = true;
}


    $stmt->close();
}
$conn->close();
?>
