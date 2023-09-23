<?php
declare(strict_types=1);

if (empty($_POST)) {
    exit;
}

$orderNumber = $_POST['orderNumber'];
if (empty($orderNumber)) {
    return;
}

$database = (new Database)->getConnection();

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Mpdf\Mpdf;

$options = new QROptions([
    'outputType' => QRCode::OUTPUT_MARKUP_SVG
]);

$fileName = 'lippu-' . $orderNumber . '.pdf';

$identifier = strtoupper(hash('crc32', uniqid('', true)));

$database = (new Database)->getConnection();

$now = date('Y-m-d H:i:s');

$query = "INSERT INTO tickets (order_number, qr_code, created) VALUES ('$orderNumber', '$identifier', '$now')";
try {
    $database->query($query);
} catch (\Throwable $th) {
    die($th->getMessage());
}


$qrcode = (new QRCode($options))->render($identifier, '/tmp/qr.svg');

$pdf = new Mpdf();
$pdf->WriteHTML('<h1>King Satan + Project Silence</h1>');
$pdf->WriteHTML('<h2>Ottopoika Kuopio 20.1.2024</h2>');
$pdf->WriteHTML('<img src="/tmp/qr.svg" width="300" height="300">');
$pdf->WriteHTML($identifier);
$pdf->WriteHTML('<p>Tilausnumero: ' . $orderNumber . '</p>');
$pdf->Output('/tmp/ticket.pdf', 'F');

header("Content-Description: File Transfer"); 
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"". basename($fileName) ."\""); 
readfile('/tmp/ticket.pdf');

unlink('/tmp/qr.svg');
unlink('/tmp/ticket.svg');
