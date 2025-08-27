<?php
// download-offence-list.php
// Generates a PDF for a list of offences using FPDF
require('fpdf.php');
require_once 'connect.php';

// Use PDO ($db) and correct table name
$stmt = $db->prepare("SELECT * FROM reported_offence ORDER BY id DESC");
$stmt->execute();

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'List of Offences',0,1,'C');
$pdf->SetFont('Arial','B',12);

// Table header
$header = array('ID', 'Offence', 'Offender', 'Reporter', 'Address');
foreach ($header as $col) {
    $pdf->Cell(38,10,$col,1);
}
$pdf->Ln();
$pdf->SetFont('Arial','',10);

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $pdf->Cell(38,10,$row['offence_id'],1);
    $pdf->Cell(38,10,substr($row['offence'],0,20),1);
    $pdf->Cell(38,10,substr($row['name'],0,20),1);
    $pdf->Cell(38,10,substr($row['officer_reporting'],0,20),1);
    $pdf->Cell(38,10,substr($row['address'],0,20),1);
    $pdf->Ln();
}
$pdf->Output('D', 'offence_list.pdf');
exit;
