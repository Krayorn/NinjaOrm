<?php

require_once('db.php');

$Film = Film::remove()
            ->where(['director' => 'RandomAuthor'])
            ->make();

// $filmToDelete = Film::find()
//             ->where(['id' => '761'])
//             ->make();

// $film = $filmToDelete[0];

// $film->deleteAll();
