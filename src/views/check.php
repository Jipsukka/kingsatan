<?php
declare(strict_types=1);

if (empty($_POST)) {
    exit;
}

$database = (new Database)->getConnection();

$code = $_POST['code'];

$query = "SELECT used FROM tickets WHERE qr_code = '$code'";
$result = $database->query($query)->fetch();

if (!$result) {
    echo '<div style="background-color: #f00;"><h1>Virheellinen lippu</h1></div>';
    exit;
}

if ($result->used) {
    echo '<div style="background-color: #f00;"><h1>Lippu on jo luettu</h1></div>';
    exit;
}

$query = "UPDATE tickets SET used = 1 WHERE qr_code = '$code'";
try {
    $database->query($query);
} catch (\Throwable $th) {
    echo '<div style="background-color: #f00;"><h1>Virhe lippua käyttäessä!</h1></div>';
    echo '<p>' . $th->getMessage() . '</p>';
    exit;
}

echo '<div style="background-color: #0f0;"><h1>OK</h1></div>';
