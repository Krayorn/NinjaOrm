<?php

namespace Ninja\Database;

use PDO;
use PDOException;

class Manager extends Logs {
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
        $dsn = $config['driver'].':dbname='.$config['database'].';host='.$config['host'].';port='.$config['port'];
        $user = $config['username'];
        $password = $config['password'];

        $msc = microtime(true);

        try {
            $this->dbh = new PDO($dsn, $user, $password);

            $msc = microtime(true) - $msc;
            $line = "addConnection() => new PDO(" . $dsn . ', ***, ***);';
            $this->writeRequestLog($line, $msc);
        } catch (PDOException $e) {
            $error = 'Connexion échouée : ' . $e->getMessage();
            $line = "addConnection() => " . $error;
            $this->writeErrorLog($line);

            echo $error;
        }

        return $this->dbh;
    }

    public function generateModels() {
        $msc = microtime(true);

        $sth = $this->dbh->prepare('SHOW TABLES');
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        $msc = microtime(true) - $msc;
        $line = "generateModels() => SHOW TABLES";
        $this->writeRequestLog($line, $msc);

        foreach ($result as $table) {
            $TablesColumns = [];

            $msc = microtime(true);

            $req = $this->dbh->prepare('SHOW COLUMNS FROM ' . reset($table));
            $req->execute();
            $res = $req->fetchAll(PDO::FETCH_ASSOC);

            $msc = microtime(true) - $msc;
            $line = "generateModels() => SHOW COLUMNS FROM " . reset($table);
            $this->writeRequestLog($line, $msc);

            foreach ($res as $column) {
                $columnsFields = [];
                array_push($TablesColumns, $column);
            }
            $this->createModel(reset($table), $TablesColumns);
        }

    }

    protected function createModel($tableName, $columns) {

        $class =    "<?php \n" .
                    "use Ninja\Database\Model; \n \n" .
                    "class " . ucfirst(strtolower($tableName)) . " extends Model {\n";

        $fillable = "    protected \$fillable = [";
        $nullable = "    protected \$nullable = [";
        $firstFillable = $firstNullable = true;
        foreach ($columns as $col) {
            if ($col['Extra'] !== 'auto_increment') {
                if ($firstFillable) {
                    $fillable .= "'" . $col['Field'] .  "'";
                    $firstFillable = false;
                } else {
                    $fillable .= ", '" . $col['Field'] .  "'";
                }
                if ($firstNullable) {
                    if ($col['Null'] === 'YES') {
                        $nullable .= "'" . $col['Field'] .  "'";
                        $firstNullable = false;
                    }
                } else {
                    if ($col['Null'] === 'YES') $nullable .= ", '" . $col['Field'] .  "'";
                }
            }
        }
        $fillable .= "];\n";
        $nullable .= "];\n";

        $class .= "    protected \$tableName = '" . $tableName . "';\n";
        $class .= "    protected \$id;\n";

        $class .= $fillable . $nullable;

        $class .= "}\n";

        $handle = file_put_contents('src/' . ucfirst(strtolower($tableName)) . '.php', $class);
    }
}
