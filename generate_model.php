<?php
use Ninja\Database\Manager as DB;

require_once('db.php');

$dbh = DB::getInstance()->generateModels();
