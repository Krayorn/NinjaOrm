<?php

require_once('db.php');

$Film = Film::delete()
            ->where(['title' => 'NewFilmTest'])
            ->make();
