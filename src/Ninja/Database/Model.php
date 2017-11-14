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

    public function __get($propname) {
        if (isset($this->$propname)) {
            return $this->$propname;
        } else {
            throw new \Exception('Property `$propname`not set');
        }
    }

    public function __set($propname, $value) {
            $this->$propname = $value;
    }

}
