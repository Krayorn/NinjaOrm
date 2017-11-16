<?php

namespace Ninja\Database;

use Ninja\Database\Manager as DB;

class Model {
    protected $conn;

    function __construct() {
        $this->conn = DB::getInstance();
    }

    function save() {
        $db = $this->conn;
        $dbh = $db->dbh;
        $table = $this->tableName;
        $data = [];
        foreach ($this->fillable as $value) {
            $data[$value] = $this->$value;
        }
        $query = 'INSERT INTO `' . $table . '` VALUES (NULL,';
        $first = true;
        foreach ($data AS $k => $value) {
            if (!$first)
                $query .= ', ';
            else
                $first = false;
            $query .= ':'.$k;
        }
        $query .= ')';
        $sth = $dbh->prepare($query);
        $sth->execute($data);
        var_dump($sth);
    }

    public function __get($propname) {
        if (isset($this->fillable[$propname])) {
                return $this->$propname;
        } else if(in_array($propname, $this->nullable)) {
            return NULL;
        } else {
            throw new \Exception("Property `$propname` not set");
        }
    }

    public function __set($propname, $value) {
        if (in_array($propname, $this->fillable)) {
            $this->$propname = $value;
        } else {
            throw new \Exception("There is no property `$propname` on this element");
        }
    }

}
