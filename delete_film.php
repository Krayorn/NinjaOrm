<?php

require_once('db.php');

$Film = Film::remove()
            ->where(['title' => 'NewFilmTest'])
            ->make();

$filmToDelete = Film::find()
            ->where(['id' => '81'])
            ->make();

$film = $filmToDelete[0];

$film->deleteAll();
