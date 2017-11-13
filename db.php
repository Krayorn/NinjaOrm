<?php
use Ninja\Database\Manager as DB;

require_once('vendor/autoload.php');

$conn = [
    "driver" => "mysql",
    "host" => "127.0.0.1",
    "port" => null,
    "database" => "cinema",
    "username" => "root",
    "password" => null
];

$manager = DB::getInstance();
$manager->addConnection($conn);
