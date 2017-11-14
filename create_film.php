<?php

require_once('db.php');

$film = new Film();
$film->title = $argv[1];

var_dump($film);

$film->save();
