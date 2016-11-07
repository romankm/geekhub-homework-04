<?php

namespace Entity;

/**
 * Class Subject
 */
class Subject
{
    private $id;
    private $name;
    private $departmentId;

    public function __construct(int $id, string $name, int $departmentId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->departmentId = $departmentId;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function setDepartmentId(int $departmentId)
    {
        $this->departmentId = $departmentId;
    }
}
