<?php

require_once('db.php');

$update = Film::set(['title' => 'ThisWillBeMyTitle'])
                ->where(['title' => 'Final Test'])
                ->make();
