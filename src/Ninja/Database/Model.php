<?php

namespace Ninja\Database;

use Ninja\Database\Manager as DB;
use Ninja\Database\QueryBuilder as QB;

use PDO;
use PDOException;

class Model extends Logs {
    protected $conn;
    protected $id;

    function __construct() {
        $this->conn = DB::getInstance();
    }

    function getDbh() {
        return $this->conn->dbh;
    }

    // This function allow the user to insert an object into his database as long
    // as there isn't a non-nullable field without a value
    protected function insert() {
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
        $line = "insert() => " . $query . " with " . implode("', '", $data);
        $this->writeRequestLog($line, $msc);

        return true;
    }

    // This function allow the user to save the current object
    public function save() {
        if(!isset($this->id)) {
            $this->insert();
        } else {
            foreach ($this->fillable as $key => $value) {
                $data[$key] = $this->$key;
            }
            $qb = $this::set($data);
            $qb->where(['id' => $this->id])->make();
            return true;
        }
    }

    // This function allow the user to save the current object and all the objects inside that one
    public function saveAll() {
        if (isset($this::$has)) {
            foreach ($this::$has as $key => $value) {
                if(isset($this->$key)) {
                    foreach ($this->$key as $item) {
                        $item->saveAll();
                    }
                }
            }
        }
        $this->save();
    }
    // This function allow the user to delete the current object
    public function delete() {
        if(!isset($this->id)) {
            $error = 'We need an id to delete an object with this method, if you don\'t have any, use the static remove instead';
            $line = "delete(".$propname.") => " . $error;
            $this->writeErrorLog($line);
            throw new \Exception($error);
        } else {
            foreach ($this->fillable as $key => $value) {
                $data[$key] = $this->$key;
            }
            $qb = $this::remove();
            $qb->where(['id' => $this->id])->make();
            return true;
        }
    }
    // This function allow the user to delete the current object and all the objects inside that one
    public function deleteAll() {
        if (isset($this::$has)) {
            foreach ($this::$has as $key => $value) {
                if(isset($this->$key)) {
                    foreach ($this->$key as $item) {
                        $item->deleteAll();
                    }
                }
            }
        }
        $this->delete();
    }

    // This function lauch the queryBuilder so the user can create more complex query easily to SELECT items from db
    public static function find() {
        $qb = new QB();

        $caller = get_called_class();
        $object = new $caller;

        $qb->object = $object;
        $qb->type = 'Select';

        return $qb;
    }

    // This function lauch the queryBuilder so the user can create more complex query easily to UPDATE items from db
    public static function set($data) {
        $qb = new QB();

        $caller = get_called_class();
        $object = new $caller;

        $qb->object = $object;
        $qb->type = 'Update';

        $qb->set($data);

        return $qb;
    }

    // This function lauch the queryBuilder so the user can create more complex query easily to DELETE items from db
    public static function remove() {
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
        if (isset($this->fillable[$propname]) || isset($this::$has[$propname])) {
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
            $this->$propname = $value;
        } else {
            $error = 'There is no property ' . $propname . ' that you can set on this element';
            $line = "__set(".$propname.") => " . $error;
            $this->writeErrorLog($line);
            throw new \Exception($error);
        }
    }

}
