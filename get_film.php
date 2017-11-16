<?php

require_once('db.php');

// $mySeances = Seance::find(['film_id'=> $argv[1], 'cinema_id' => $argv[2]]);
$myFilm = Film::find(['id'=> $argv[3]]);

var_dump($myFilm);
