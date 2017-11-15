<?php

namespace Ninja\Database;

use PDO;
use PDOException;

class Manager
{
    public $dbh;
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
                var_dump($column);
                array_push($columnsFields, $column['Field']);
                array_push($columnsFields, $column['Type']);
                array_push($columnsFields, $column['Extra']);
                array_push($TablesColumns, $columnsFields);
            }
            $this->createModel(reset($table), $TablesColumns);
        }
    }

    protected function createModel($tableName, $columns) {

        $class =    "<?php \n" .
                    "use Ninja\Database\Model; \n \n" .
                    "class " . ucfirst(strtolower($tableName)) . " extends Model {\n";

        $class .= "    protected \$fillable = [";
        $first = true;
        foreach ($columns as $col) {
            if ($col[2] !== 'auto_increment') {
                if ($first) {
                    $class .= "'$col[0]'";
                    $first = false;
                } else {
                    $class .= ", '$col[0]'";
                }
            }
        }
        $class .= "];\n";

        $class .= "    protected \$tableName = '" . $tableName . "';\n";

        $class .= "}\n";

        $handle = file_put_contents ('src/' . ucfirst(strtolower($tableName)) . '.php', $class);
    }
}
