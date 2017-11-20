<?php

require_once('db.php');

$update = Film::set(['title' => 'ThisWillBeMyTitle'])
                ->where(['title' => 'Final Test'])
                ->make();

$filmToUpdate = Film::find()
                ->where(['id' => 35])
                ->make();

$film = $filmToUpdate[0];

$film->title = 'NewUpdateTest';

foreach ($film->Seance as $seance) {
    $seance->start_horaire = '18:05:05';
    //var_dump($seance);
}

$film->saveAll();
