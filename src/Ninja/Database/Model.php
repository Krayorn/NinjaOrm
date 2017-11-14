<?php

namespace Ninja\Database;

use Ninja\Database\Manager as DB;

class Model {
    protected $conn;

    function __construct() {
        $this->conn = DB::getInstance();
    }

    function save() {

    }
}
