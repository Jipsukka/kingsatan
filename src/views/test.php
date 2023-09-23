<?php
declare(strict_types=1);

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

$database = (new Database)->getConnection();

$query = 'SELECT * from tickets ORDER BY id DESC LIMIT 3';
$tickets = $database->query($query)->fetchAll();

$options = new QROptions([
    'outputType' => QRCode::OUTPUT_MARKUP_SVG
]);

echo '<h3>Haetaan kolme uusinta lippua + virheellinen</h3>';

foreach ($tickets as $ticket) {
    echo '<div>';
    $qrcode = (new QRCode($options))->render($ticket->qr_code);
    echo "<img src='$qrcode' width='400' height='400'>";
    echo "<h1>$ticket->qr_code</h1>";
    echo '<br />created: ' . $ticket->created;
    echo '<br />Used: ' . $ticket->used;
    echo '</div>';
}

echo '<div>';
$random = 'KS-' . random_int(100000000, 999999999) . '-666';
$qrcode = (new QRCode($options))->render($random);
echo "<img src='$qrcode' width='400' height='400'>";
echo "<h1>$random</h1>";
echo '<h3>Virheellinen QR koodi</h3>';
echo '</div>';