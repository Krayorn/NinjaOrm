<?php

require_once('db.php');

// Film::remove()
//             ->where(['title' => 'WilliamToutSeul'])
//             ->make();

$filmToDelete = Film::find()
            ->where(['id' => '741'])
            ->make();

$film = $filmToDelete[0];

$film->deleteAll();
