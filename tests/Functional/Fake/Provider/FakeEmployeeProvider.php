<?php

namespace tests\Meals\Functional\Fake\Provider;

use Meals\Application\Component\Provider\EmployeeProviderInterface;
use Meals\Domain\Employee\Employee;

class FakeEmployeeProvider implements EmployeeProviderInterface
{
    /** @var Employee */
    private $employee;

    public function getEmployee(int $employeeId): Employee
    {
        return $this->employee;
    }

    public function setEmployee(Employee $employee)
    {
        $this->employee = $employee;
    }
}
