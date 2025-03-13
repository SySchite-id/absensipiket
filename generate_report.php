<?php
require_once('vendor/tecnickcom/tcpdf/tcpdf.php');
include("db.php");

$date = date("Y-m-d"); // Current date
$directory = __DIR__ . "/reports"; // Ensure absolute path
$filename = "$directory/Attendance_Report_$date.pdf"; // Absolute path for TCPDF

// Ensure the reports directory exists
if (!file_exists($directory)) {
    mkdir($directory, 0777, true); // Create with full permissions
}

$sql = "SELECT * FROM attendance WHERE date=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $date);
$stmt->execute();
$result = $stmt->get_result();

// Create new PDF document
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetTitle("Attendance Report - $date");
$pdf->SetMargins(10, 10, 10);
$pdf->AddPage();

// Report Header
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 10, "Attendance Report - $date", 0, 1, 'C');
$pdf->Ln(5);

// Table Header
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(40, 10, "Name", 1, 0, 'C');
$pdf->Cell(30, 10, "Class", 1, 0, 'C');
$pdf->Cell(35, 10, "Check-in", 1, 0, 'C');
$pdf->Cell(40, 10, "Activity", 1, 0, 'C');
$pdf->Cell(35, 10, "Check-out", 1, 1, 'C');

// Table Data
$pdf->SetFont('helvetica', '', 10);
while ($row = $result->fetch_assoc()) {
    $pdf->Cell(40, 10, $row['name'], 1, 0, 'C');
    $pdf->Cell(30, 10, $row['class'], 1, 0, 'C');
    $pdf->Cell(35, 10, $row['check_in'], 1, 0, 'C');
    $pdf->Cell(40, 10, ($row['activity'] ? $row['activity'] : "N/A"), 1, 0, 'C');
    $pdf->Cell(35, 10, ($row['check_out'] ? $row['check_out'] : "Not Checked Out"), 1, 1, 'C');
}

// Add images
$pdf->Ln(10);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 10, "Checkout Images", 0, 1, 'L');

$pdf->SetFont('helvetica', '', 10);
$result->data_seek(0);
while ($row = $result->fetch_assoc()) {
    if (!empty($row['checkout_image']) && file_exists($row['checkout_image'])) {
        $pdf->Cell(0, 10, $row['name'] . " (" . $row['class'] . ")", 0, 1);
        $pdf->Image($row['checkout_image'], '', '', 50, 50);
        $pdf->Ln(10);
    }
}

// Save the PDF file
$pdf->Output($filename, 'F');

// Redirect to reports list
header("Location: reports_list.php");
exit();
?>
