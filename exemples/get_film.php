<?php

require_once('db.php');

$films = Film::find()
            ->whereOr(['id' => 315])
            ->where(['title' => 'WilliamToutSeul', 'director' => 'Collectif'])
            ->orderDesc(['title', 'director'])
            ->orderAsc(['release_date'])
            ->make();

foreach ($films as $film) {
    $release_date = new DateTime($film->release_date);
    echo "[".$film->id."] ".
    $film->title
    ." (".
    $release_date->format("Y")
    .") by " . $film->director  . "\n";
    foreach ($film->Seance as $seance) {
        echo 'Seance le '. $seance->jour . ' à ' . $seance->start_horaire . "\n";
    }
}
