<?php

namespace Database;

use Exception;
use PDO;
use PDOStatement;

/**
 * Class Connector
 */
class Connector
{
    private $pdo;

    public function __construct($databaseName, $user, $pass, $host = 'localhost')
    {
        $this->pdo = new \PDO("mysql:host={$host};dbname={$databaseName};charset=UTF8", $user, $pass);

        if (!$this->pdo) {
            throw new \Exception('Error connecting to the database');
        }
    }

    public function getPdo()
    {
        return $this->pdo;
    }

    public function execInsert(string $tableName, array $fieldValues): int
    {
        $fieldValues = $this->escapeFieldValues($fieldValues);

        $fields = implode(', ', array_keys($fieldValues));
        $values = implode(', ', array_values($fieldValues));

        return $this->exec("INSERT INTO `{$tableName}` ({$fields}) VALUES ($values)");
    }

    public function execUpdate(string $tableName, int $id, array $fieldValues): int
    {
        $fieldValues = $this->escapeFieldValues($fieldValues);

        foreach ($fieldValues as $field => $value) {
            $fieldValuesArray[] = "{$field}={$value}";
        }

        $fieldValuesString = implode(', ', $fieldValuesArray);

        return $this->exec("UPDATE `{$tableName}` SET {$fieldValuesString} WHERE `id` = {$id}");
    }

    public function execDelete(string $tableName, int $recordId): int
    {
        return $this->exec("DELETE FROM `{$tableName}` WHERE `id` = '{$recordId}'");
    }

    /**
     * @param string $tableName
     * @param int $recordId
     * @return array|null
     */
    public function execSelectById(string $tableName, int $recordId)
    {
        $statement = $this->executeWithBindValues(
            "SELECT * FROM `{$tableName}` WHERE `id` = :recordId",
            [
                ['key' => 'recordId', 'value' => $recordId, 'type' => PDO::PARAM_INT],
            ]
        );

        $result = $statement->fetchAll();

        return $result ? $result[0] : null;
    }

    /**
     * @param string $tableName
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function execSelect(string $tableName, int $limit, int $offset): array
    {
        $statement = $this->executeWithBindValues(
            "SELECT * FROM `{$tableName}` LIMIT :limit OFFSET :offset",
            [
                ['key' => 'limit', 'value' => $limit, 'type' => PDO::PARAM_INT],
                ['key' => 'offset', 'value' => $offset, 'type' => PDO::PARAM_INT],
            ]
        );

        return $statement->fetchAll();
    }

    public function executeWithBindValues(string $statement, array $bindValues): PDOStatement
    {
        $statement = $this->pdo->prepare($statement);

        foreach ($bindValues as $valueData) {
            $statement->bindValue(":{$valueData['key']}", $valueData['value'], $valueData['type']);
        }

        $statement->execute();

        return $statement;
    }

    public function exec(string $statement): int
    {
        $result = $this->pdo->exec($statement);

        if ($result === false) {
            $errorInfo = $this->pdo->errorInfo();

            throw new Exception("Failed to execute statement: {$statement}. With error: {$errorInfo}");
        }

        return $result;
    }

    private function escapeFieldValues(array $fieldValues)
    {
        $updatedFieldValues = [];

        foreach ($fieldValues as $key => $value) {
            $updatedFieldValues["`{$key}`"] = $this->pdo->quote($value);
        }

        return $updatedFieldValues;
    }
}
