<?php

namespace Controller;

use Database\Connector;
use Twig_Environment;

/**
 * Class DatabaseController
 */
class DatabaseController
{
    private $connector;
    private $pdo;

    public function __construct(Twig_Environment $twig, Connector $connector)
    {
        $this->twig = $twig;
        $this->connector = $connector;
        $this->pdo = $this->connector->getPdo();
    }

    public function createDatabaseSchemaAction()
    {
        $this->dropAllTables();

        $databaseSchema = require __DIR__ . '/../../config/databaseSchema.php';
        $result = $this->pdo->exec($databaseSchema);

        if ($result === false) {
            throw new \Exception("Failed to create tables");
        }

        FrontController::redirect();
    }

    public function fillDatabaseAction()
    {
        $data = require __DIR__ . '/../../config/databaseData.php';
        $result = $this->pdo->exec($data);

        if ($result === false) {
            throw new \Exception("Failed to run query");
        }

        FrontController::redirect();
    }

    private function dropAllTables()
    {
        $tableNames = require __DIR__ . '/../../config/databaseTables.php';

        foreach ($tableNames as $tableName) {
            $result = $this->pdo->exec("DROP TABLE IF EXISTS {$tableName}");

            if ($result === false) {
                throw new \Exception("Failed to drop table '{$tableName}'");
            }
        }

        return true;
    }
}
