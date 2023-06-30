<?php

namespace Meals\Domain\Poll;

use Meals\Domain\Dish\Dish;
use Meals\Domain\Employee\Employee;

class PollResult
{
    /** @var int */
    private $id;

    /** @var Poll */
    private $poll;

    /** @var Employee */
    private $employee;

    /** @var Dish */
    private $dish;

    /** @var int */
    private $employeeFloor;

    /**
     * PollResult constructor.
     * @param int $id
     * @param Poll $poll
     * @param Employee $employee
     * @param Dish $dish
     * @param int $employeeFloor
     */
    public function __construct(int $id, Poll $poll, Employee $employee, Dish $dish, int $employeeFloor)
    {
        $this->id = $id;
        $this->poll = $poll;
        $this->employee = $employee;
        $this->dish = $dish;
        $this->employeeFloor = $employeeFloor;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Poll
     */
    public function getPoll(): Poll
    {
        return $this->poll;
    }

    /**
     * @return Employee
     */
    public function getEmployee(): Employee
    {
        return $this->employee;
    }

    /**
     * @return Dish
     */
    public function getDish(): Dish
    {
        return $this->dish;
    }

    /**
     * @return int
     */
    public function getEmployeeFloor(): int
    {
        return $this->employeeFloor;
    }
}
