<?php

namespace Ninja\Database;

use Ninja\Database\Manager as DB;
use Ninja\Database\QueryBuilder as QB;

use PDO;
use PDOException;

class Model extends Logs {
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

        foreach ($this->fillable as $key => $value) {
            $data[$key] = $this->$key;
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

        $msc = microtime(true);

        $sth = $dbh->prepare($query);
        $sth->execute($data);

        $msc = microtime(true) - $msc;
        $line = "save() => " . $query . " with " . implode("', '", $data);
        $this->writeRequestLog($line, $msc);

        return true;
    }

    // This function lauch the queryBuilder so the user can create more complex query easily
    public static function find() {
        $qb = new QB();

        $caller = get_called_class();
        $object = new $caller;

        $qb->object = $object;
        $qb->type = 'Select';

        return $qb;
    }

    public static function set($data) {
        $qb = new QB();

        $caller = get_called_class();
        $object = new $caller;

        $qb->object = $object;
        $qb->type = 'Update';

        $qb->set($data);

        return $qb;
    }

    public static function delete() {
        $qb = new QB();

        $caller = get_called_class();
        $object = new $caller;

        $qb->object = $object;
        $qb->type = 'Delete';

        return $qb;
    }

    public function __get($propname) {
        if (isset($this->$propname) || $propname === 'tableName' || $propname === 'id') {
                return $this->$propname;
        } else {
            $error = 'Property ' . $propname . ' not set';
            $line = "__get(".$propname.") => " . $error;
            $this->writeErrorLog($line);
            throw new \Exception($error);
        }
    }

    public function __set($propname, $value) {
        if (isset($this->fillable[$propname])) {
            if($value === NULL) {
                if ($this->fillable[$propname]['nullable'] === 'YES') {
                    $this->$propname = $value;
                } else {
                    $error = 'The property ' . $propname . ' can\'t be NULL';
                    $line = "__set(".$propname.") => " . $error;
                    $this->writeErrorLog($line);
                    throw new \Exception($error);
                }
            }
            $this->$propname = $value;
        } else if($propname === 'id') {
            $this->id = $value;
        } else {
            $error = 'There is no property ' . $propname . ' that you can set on this element';
            $line = "__set(".$propname.") => " . $error;
            $this->writeErrorLog($line);
            throw new \Exception($error);
        }
    }

}
