<?php

require_once('db.php');

$update = Film::set(['director' => 'LastTestFromTheNight'])
                ->where(['title' => 'WilliamToutSeul'])
                ->make();

$filmToUpdate = Film::find()
                ->where(['id' => 741])
                ->make();

$film = $filmToUpdate[0];

$film->title = 'NewUpdateTest';

foreach ($film->Seance as $seance) {
    $seance->start_horaire = '18:05:05';
}

$film->saveAll();
