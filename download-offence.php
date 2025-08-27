<?php
// download-offence.php
// Generates a PDF for a single offence using FPDF
require('fpdf.php');
require_once 'connect.php';

if (!isset($_GET['id'])) {
    die('Offence ID not specified.');
}
$offence_id = intval($_GET['id']);

// Fetch offence details using PDO and correct table
$stmt = $db->prepare("SELECT * FROM reported_offence WHERE id = :id");
$stmt->bindParam(':id', $offence_id, PDO::PARAM_INT);
$stmt->execute();
if ($stmt->rowCount() == 0) {
    die('Offence not found.');
}
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'Offence Details',0,1,'C');
$pdf->SetFont('Arial','',12);
foreach ($row as $key => $value) {
    $pdf->Cell(50,10,ucwords(str_replace('_',' ',$key)).':',0,0);
    $pdf->Cell(0,10,$value,0,1);
}
$pdf->Output('D', 'offence_'.$offence_id.'.pdf');
exit;
