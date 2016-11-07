<?php

namespace Entity;

/**
 * Class HomeTask
 */
class HomeTask
{
    private $id;
    private $name;
    private $done;
    private $studentId;
    private $departmentId;

    public function __construct(int $id, string $name, bool $done, int $studentId, int $departmentId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->done = $done;
        $this->studentId = $studentId;
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

    public function setDone(bool $done)
    {
        $this->done = $done;
    }

    public function setStudentId(int $studentId)
    {
        $this->studentId = $studentId;
    }

    public function setDepartmentId(int $departmentId)
    {
        $this->departmentId = $departmentId;
    }
}
