<?php

namespace Repository;

use Database\Connector;
use Entity\Department;

/**
 * Class DepartmentRepository
 */
class DepartmentRepository extends AbstractRepository
{
    /**
     * @var Connector
     */
    protected $connector;
    protected $tableName = 'departments';
    protected $entityClassName = Department::class;
    protected $entityFieldsToFilter = ['name', 'universityId'];
    protected $entityFields = ['id', 'name', 'universityId'];
    protected $propertyToColumnMap = ['universityId' => 'university_id'];

    public function findAll($limit = 1000, $offset = 0): array
    {
        $statement = <<<statement
SELECT d.id, d.name, d.university_id, u.name AS university_name
FROM {$this->tableName} d
LEFT JOIN `universities` u ON d.university_id = u.id
statement;

        $statement = $this->connector->getPdo()->prepare($statement);
        $statement->execute();

        $items = $statement->fetchAll();

        $entities = [];

        foreach ($items as $item) {
            $entities[] = $this->fillEntityWithData($item);
        }

        return $entities;
    }

    protected function fillEntityWithData(array $entityData)
    {
        $entity = parent::fillEntityWithData($entityData);

        $additionalData = [
            'university_name' => 'university',
        ];

        foreach ($additionalData as $key => $value) {
            $value = $entityData[$key];
            $setter = 'set' . ucfirst($additionalData[$key]);

            if (method_exists($entity, $setter)) {
                $entity->$setter($value);
            }
        }

        return $entity;
    }
}
