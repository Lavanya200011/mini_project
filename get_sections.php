<?php
$conn = new mysqli("sql212.infinityfree.com", "if0_38879727", "Lavanyath", "if0_38879727_attendance_system");

if (isset($_GET['dept_id'])) {
    $dept_id = $conn->real_escape_string($_GET['dept_id']);
    $result = $conn->query("SELECT * FROM sections WHERE dept_id = '$dept_id'");

    while ($row = $result->fetch_assoc()) {
        echo "<option value='{$row['section_id']}'>Section {$row['section_name']}</option>";
    }
}
?>
