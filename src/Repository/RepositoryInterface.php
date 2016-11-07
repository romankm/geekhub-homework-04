<?php

namespace Repository;

interface RepositoryInterface
{
    /**
     * Insert new entity data to the DB
     * @param array $entityData
     * @return mixed
     */
    public function insert(array $entityData);
    /**
     * Update exist entity data in the DB
     * @param array $entityData
     * @return mixed
     */
    public function update(array $entityData);
    /**
     * Delete entity data from the DB
     * @param array $entityData
     * @return mixed
     */
    public function remove(int $id);
    /**
     * Search entity data in the DB by Id
     * @param $id
     * @return mixed
     */
    public function find(int $id);
    /**
     * Search all entity data in the DB
     * @param string $limit
     * @param string $offset
     * @return array
     */
    public function findAll($limit, $offset);
    /**
     * Search all entity data in the DB like $criteria rules
     * @param array $criteria
     * @return mixed
     */
    public function findBy($criteria = []);
}
