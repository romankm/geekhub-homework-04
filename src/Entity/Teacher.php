<?php

namespace Entity;

/**
 * Class Teacher
 */
class Teacher
{
    private $id;
    private $firstName;
    private $lastName;
    private $email;
    private $telephone;
    private $departmentId;

    public function __construct(
        int $id,
        string $firstName,
        string $lastName,
        string $email,
        string $telephone,
        int $departmentId
    ) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->telephone = $telephone;
        $this->departmentId = $departmentId;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * @param string $telephone
     */
    public function setTelephone(string $telephone)
    {
        $this->telephone = $telephone;
    }

    /**
     * @param int $departmentId
     */
    public function setDepartmentId(int $departmentId)
    {
        $this->departmentId = $departmentId;
    }
}
