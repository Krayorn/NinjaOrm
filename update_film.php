<?php

require_once('db.php');

$update = Film::set(['title' => 'Final Test'])
                ->whereOr(['director' => 'Stephan Schesch', 'id' => 69])
                ->whereOr(['director' => 'Hayao Miyazaki', 'id' => 35], "=", "AND")
                ->make();

var_dump($update);
