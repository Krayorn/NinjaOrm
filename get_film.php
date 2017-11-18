<?php

require_once('db.php');

$myFilm = Film::find()
                ->whereOr(['director' => 'Collectif'])
                // ->whereOr(['title' => 'Chicken run', 'id' => 61], "=", "AND")
                // ->orderDesc(['title', 'director'])
                ->orderAsc(['release_date'])
                ->make();

var_dump($myFilm);
