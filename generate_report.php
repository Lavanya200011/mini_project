<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$conn = new mysqli("sql212.infinityfree.com", "if0_38879727", "Lavanyath", "if0_38879727_attendance_system");

require('fpdf/fpdf/fpdf.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dept_id = $_POST['dept_id'];
    $section_id = $_POST['section_id'];
    $subject = $_POST['subject'];
    $month = $_POST['month'];
    $year = $_POST['year'];

    $sql = "SELECT students.student_id, students.name, students.roll_no FROM students
            JOIN sections ON students.section_id = sections.section_id
            JOIN departments ON sections.dept_id = departments.dept_id
            WHERE departments.dept_id = ? AND sections.section_id = ? ORDER BY roll_no ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $dept_id, $section_id);
    $stmt->execute();
    $students = $stmt->get_result();

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);

    $pdf->Cell(0, 10, "Attendance Report - $subject ($month/$year)", 0, 1, 'C');
    $pdf->Ln(10);

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
    $total_attendance_percent = 0;
    $total_students = 0;

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

        // Count Total
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

        $total_attendance_percent += $attendance_percentage;
        $total_students++;

        $pdf->Cell(15, 10, $sno++, 1);
        $pdf->Cell(50, 10, $student['name'], 1);
        $pdf->Cell(30, 10, $student['roll_no'], 1);
        $pdf->Cell(25, 10, $present_days, 1);
        $pdf->Cell(25, 10, $absent_days, 1);
        $pdf->Cell(30, 10, "$attendance_percentage%", 1);
        $pdf->Ln();
    }

    // Class Average
    if ($total_students > 0) {
        $class_average = round($total_attendance_percent / $total_students, 2);
        $pdf->Ln(10); // Space after table
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, "Average Class Attendance: $class_average %", 0, 1, 'C');
    }

    $pdf->Output('D', 'attendance_report.pdf'); // Force Download
    exit();
}
?>