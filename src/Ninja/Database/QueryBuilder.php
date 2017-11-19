<?php

namespace Ninja\Database;

use PDO;
use PDOException;

class QueryBuilder extends Logs {
    protected $type;
    protected $params;
    protected $object;

    function __construct() {
        $this->params = ['where' => '', 'order' => '', 'set' => ''];
    }

    public function make() {
        switch ($this->type) {
            case 'Select':
                $query = 'SELECT * FROM ' . $this->object->tableName . $this->params['where'] . $this->params['order'];
                break;
            case 'Update':
                $query = 'UPDATE ' . $this->object->tableName . $this->params['set'] . $this->params['where'];
                break;
            case 'Delete':
                $query = 'DELETE FROM ' . $this->object->tableName . $this->params['where'];
        }

        $msc = microtime(true);

        $dbh = $this->object->getDbh();
        $sth = $dbh->prepare($query);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        $msc = microtime(true) - $msc;
        $line = "make() => " . $query;
        $this->writeRequestLog($line, $msc);

        $list = [];
        foreach ($result as $item) {
            $obj = new $this->object;

            foreach ($item as $key => $value) {
                $obj->$key = $value;
            }
            array_push($list, $obj);
        }

        return $list;
    }

    public function set($data){
        $query = ' SET ';
        $first = true;
        foreach ($data as $key => $value) {
            if(!$first)
                $query .= ', ';
            else
                $first = false;
            $query .= $key . " = '" . $value . "'";
        }

        $this->params['set'] = $query;
    }

    public function whereOr($data, $sign = '=', $externOperator = 'AND') {
        // TODO: Check the value given by the user
        return $this->where($data, $sign, 'OR', $externOperator);
    }

    public function whereAnd($data, $sign = '=', $externOperator = 'OR') {
        // TODO: Check the value given by the user
        return $this->where($data, $sign, 'AND', $externOperator);
    }

    public function where($data, $sign = '=', $insideOperator = 'AND', $externOperator = 'OR') {
        $where = '';
        if ($this->params['where'] !== '') {
            $where .= $this->params['where'] . ' ' . $externOperator . ' ';
        } else {
            $where .= ' WHERE ';
        }
            // TODO: Improve function by allow a user to give an array of value in the whereOr functon
            // like whereOr['title' => ['title1', 'title2']]
        $where .= '(';
        $first = true;
        foreach ($data AS $key => $value) {
            if (!$first)
                $where .= ' ' . $insideOperator. ' ';
            else
                $first = false;
            $where .= $key . ' ' . $sign . " '" . $value . "'";
        }
        $where .= ')';

        $this->params['where'] = $where;

        return $this;
    }

    public function orderDesc($columnsName) {
        return $this->orderBy($columnsName, 'DESC');
    }

    public function orderAsc($columnsName) {
        return $this->orderBy($columnsName, 'ASC');
    }

    protected function orderBy($columnsName, $sort) {
        $order = '';
        if ($this->params['order'] !== '') {
            $order .= $this->params['order'] . ', ';
        } else {
            $order .= ' ORDER BY ';
        }

        $first = true;
        foreach ($columnsName AS $value) {
            if (!$first)
                $order .= ', ';
            else
                $first = false;
            $order .= '`' . $value . '` ' . $sort;
        }

        $this->params['order'] = $order;

        return $this;
    }

    public function __get($propname) {
        return $this->$propname;
    }

    public function __set($propname, $value) {
        $this->$propname = $value;
    }
}
