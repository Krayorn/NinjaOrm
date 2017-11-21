<?php

require_once('db.php');

Film::remove()
            ->whereAnd(['title' => 'Quel cirque !', 'director' => 'Collectif'])
            ->make();

$filmToDelete = Film::find()
            ->where(['id' => '735'])
            ->make();

$film = $filmToDelete[0];

$film->deleteAll();
