<?php
declare(strict_types=1);

$database = (new Database)->getConnection();

$query = 'SELECT * from tickets';
$tickets = $database->query($query)->fetchAll();
?>

<h1>Luodut liput</h1>

<p>Lippuja luotu yhteensä <?php echo count($tickets); ?> kappaletta.</p>

<table class="table">
    <thead>
        <tr>
            <th>Tilausnumero</th>
            <th>QR-tunniste</th>
            <th>Luotu</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($tickets as $ticket) : ?>
        <tr>
            <td><?php echo $ticket->order_number; ?></td>
            <td><?php echo $ticket->qr_code; ?></td>
            <td><?php echo $ticket->created; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>