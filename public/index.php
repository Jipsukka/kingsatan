<?php
declare(strict_types=1);

ini_set('display_errors', 1);
ini_Set('error_reporting', -1);

require_once '../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

require_once '../src/lib/Database.php';
require_once '../src/lib/Router.php';

(new Router)->start();

