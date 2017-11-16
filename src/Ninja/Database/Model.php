<?php

namespace Ninja\Database;

use Ninja\Database\Manager as DB;
use PDO;
use PDOException;

class Model {
    protected $conn;

    function __construct() {
        $this->conn = DB::getInstance();
    }

    function getDbh() {
        return $this->conn->dbh;
    }
    // This function allow the user to save an object into his database as long
    // as there isn't a non-nullable field without a value
    public function save() {
        $dbh = $this->getDbh();
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

        return true;
    }

    // This function allow the user to find one or multiples objects in his database with multiples parameters in the WHERE
    public static function find($data = []) {
        $caller = get_called_class();
        $object = new $caller;
        $dbh = $object->getDbh();

        $query = "SELECT * FROM " . $object->tableName . " WHERE ";
        $first = true;
        foreach ($data AS $key => $value) {
            if (!$first)
                $query .= " AND ";
            else
                $first = false;
            $query .= $key . " = :" . $key;
        }

        $sth = $dbh->prepare($query);
        $sth->execute($data);
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        return $result;
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
