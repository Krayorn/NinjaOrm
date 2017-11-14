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
        $this->config=$config;
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

    public function generateModels() {
        $sth = $this->dbh->prepare('SHOW TABLES');
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $table) {
            $TablesColumns = [];
            $req = $this->dbh->prepare('SHOW COLUMNS FROM ' . reset($table));
            $req->execute();
            $res = $req->fetchAll(PDO::FETCH_ASSOC);
            foreach ($res as $column) {
                $columnsFields = [];
                array_push($columnsFields, $column['Field']);
                array_push($columnsFields, $column['Type']);
                array_push($TablesColumns, $columnsFields);
            }
            $this->createModel(reset($table), $TablesColumns);
        }
    }

    protected function createModel($tableName, $columns) {

        $class =    "<?php \n" .
                    "use Ninja\Database\Model; \n \n" .
                    "class " . ucfirst(strtolower($tableName)) . " extends Model {\n" .
                    "}\n";

        $handle = file_put_contents ('src/' . ucfirst(strtolower($tableName)) . '.php', $class);
    }

}
