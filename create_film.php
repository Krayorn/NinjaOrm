<?php

require_once('db.php');

$film = new Film();
$film->title = $argv[1];
$film->release_date = $argv[2];
$film->director = $argv[3];

$film->save();
