<?php

namespace Meals\Application\Component\Provider;

use Meals\Domain\Employee\Employee;

interface EmployeeProviderInterface
{
    public function getEmployee(int $employeeId): Employee;
}
