<?php
use Ninja\Database\Manager as DB;

require_once('vendor/autoload.php');

$conn = [
    "driver" => "mysql",
    "host" => "127.0.0.1",
    "port" => null,
    "database" => "algo_cinema",
    "username" => "algo",
    "password" => "algo"
];

Film::has(['Seance' => 'film_id']);
Cinema::has(['Seance' => 'cinema_id']);

$manager = DB::getInstance();
$manager->addConnection($conn);
