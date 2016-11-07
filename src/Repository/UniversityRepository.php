<?php

namespace Repository;

use Entity\University;

/**
 * Class UniversityRepository
 */
class UniversityRepository extends AbstractRepository
{
    protected $connector;
    protected $tableName = 'universities';
    protected $entityClassName = University::class;
    protected $entityFieldsToFilter = ['name', 'city', 'site'];
    protected $entityFields = ['id', 'name', 'city', 'site'];
}
