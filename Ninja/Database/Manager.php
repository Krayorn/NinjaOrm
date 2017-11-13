<?php

namespace Ninja\Database;

use PDO;
use PDOException;

class Manager
{
    protected $dbh;
    private static $instance = null;

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Manager();
        }
        return self::$instance;
    }

    public function __construct() {
        $this->dbh = null;
    }

    public function addConnection($config) {
        $dsn = $config['driver'].':dbname='.$config['database'].';host='.$config['host'];
        $user = $config['username'];
        $password = $config['password'];

        try {
            $this->dbh = new PDO($dsn, $user, $password);
        } catch (PDOException $e) {
            echo 'Connexion échouée : ' . $e->getMessage();
        }
        return $this->dbh;
    }
}
