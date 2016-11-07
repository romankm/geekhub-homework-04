<?php

namespace Repository;

use Database\Connector;
use Exception;

/**
 * Class AbstractRepository
 */
abstract class AbstractRepository implements RepositoryInterface
{
    protected $connector;
    protected $tableName;
    protected $entityClassName;
    protected $entityFieldsToFilter;
    protected $entityFields;
    protected $propertyToColumnMap;

    public function __construct(Connector $connector)
    {
        $this->connector = $connector;
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function findAll($limit = 1000, $offset = 0): array
    {
        $items = $this->connector->execSelect($this->tableName, $limit, $offset);
        $entities = [];

        foreach ($items as $item) {
            $entities[] = $this->fillEntityWithData($item);
        }

        return $entities;
    }

    /**
     * Insert new entity data to the DB
     * @param array $entityData
     * @return mixed
     */
    public function insert(array $entityData)
    {
        $fieldsValues = $this->prepareDataForDb($entityData);

        return $this->connector->execInsert($this->tableName, $fieldsValues);
    }

    /**
     * Update exist entity data in the DB
     * @param array $entityData
     * @return mixed
     * @throws Exception
     */
    public function update(array $entityData)
    {
        if (!array_key_exists('id', $entityData)) {
            throw new Exception('Id is not specified');
        }

        $fieldsValues = $this->prepareDataForDb($entityData);

        return $this->connector->execUpdate($this->tableName, $entityData['id'], $fieldsValues);
    }

    /**
     * Delete entity data from the DB
     * @param int $id
     * @return int
     */
    public function remove(int $id)
    {
        return $this->connector->execDelete($this->tableName, $id);
    }

    /**
     * Search entity data in the DB by Id
     * @param int $id
     * @return mixed
     * @throws Exception
     */
    public function find(int $id)
    {
        $entityData = $this->connector->execSelectById($this->tableName, $id);

        if (!$entityData) {
            return null;
        }

        return $this->fillEntityWithData($entityData);
    }

    /**
     * Search all entity data in the DB like $criteria rules
     * @param array $criteria
     * @return mixed
     */
    public function findBy($criteria = [])
    {
        // TODO: Implement findBy() method.
    }

    /**
     * Trim and remove empty fields values. Change property names to column names.
     *
     * @param array $entityData
     * @return array
     */
    protected function prepareDataForDb(array $entityData): array
    {
        $cleanEntityData = [];

        foreach ($this->entityFieldsToFilter as $field) {
            if (array_key_exists($field, $entityData)) {
                $trimmed = trim($entityData[$field]);

                if ($trimmed) {
                    $cleanEntityData[$field] = $trimmed;
                }
            }
        }

        foreach ($cleanEntityData as $key => $value) {
            if (in_array($key, array_keys($this->propertyToColumnMap))) {
                unset($cleanEntityData[$key]);

                $cleanEntityData[$this->propertyToColumnMap[$key]] = $value;
            }
        }

        return $cleanEntityData;
    }

    protected function fillEntityWithData(array $entityData)
    {
        $entity = new $this->entityClassName();

        foreach ($this->entityFields as $field) {
            if (in_array($field, array_keys($this->propertyToColumnMap))) {
                $value = $entityData[$this->propertyToColumnMap[$field]];
            } else {
                $value = $entityData[$field];
            }

            $setter = 'set' . ucfirst($field);

            if (method_exists($entity, $setter)) {
                $entity->$setter($value);
            }
        }

        return $entity;
    }
}