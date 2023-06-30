<?php

namespace Meals\Domain\Employee;

use Meals\Domain\User\User;

class Employee
{
    /** @var int */
    private $id;

    /** @var User */
    private $user;

    /** @var int */
    private $floor;

    /** @var string */
    private $surname;

    /**
     * Employee constructor.
     * @param int $id
     * @param User $user
     * @param int $floor
     * @param string $surname
     */
    public function __construct(int $id, User $user, int $floor, string $surname)
    {
        $this->id = $id;
        $this->user = $user;
        $this->floor = $floor;
        $this->surname = $surname;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return int
     */
    public function getFloor(): int
    {
        return $this->floor;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }
}
