<?php
require __DIR__ . '/../vendor/autoload.php';

$dotenv = \Dotenv\Dotenv::createMutable(__DIR__."/..");
$dotenv->load();

require __DIR__ . '/../src/router.php';


