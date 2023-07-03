<?php

declare(strict_types=1);

namespace Meals\Application\Component\Validator;

use Assert\Assertion;
use Meals\Application\Component\Validator\Exception\EmployeeAlreadyChoseDishException;
use Meals\Domain\Employee\Employee;
use Meals\Domain\Poll\PollResult;

class EmployeeCanChooseDishValidator
{
    /**
     * @param Employee $employee
     * @param PollResult[] $pollResults
     */
    public function validate(Employee $employee, array $pollResults): void
    {
        Assertion::allIsInstanceOf($pollResults, PollResult::class);
        foreach ($pollResults as $pollResult) {
            if ($employee->getId() === $pollResult->getEmployee()->getId()) {
                throw new EmployeeAlreadyChoseDishException();
            }
        }
    }
}
