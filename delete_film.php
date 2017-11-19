<?php

require_once('db.php');

$Film = Film::delete()
            ->where(['title' => 'Final test'])
            ->make();
