<?php

require_once('db.php');

$films = Film::find()
            ->where(['id' => 741])
            // ->whereOr(['title' => 'Chicken run', 'id' => 61], "=", "AND")
            // ->orderDesc(['title', 'director'])
            ->orderAsc(['release_date'])
            ->make();

foreach ($films as $film) {
    $release_date = new DateTime($film->release_date);
    echo "[".$film->id."] ".
    $film->title
    ." (".
    $release_date->format("Y")
    .") by " . $film->director  . "\n";
}
