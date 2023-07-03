<?php

declare(strict_types=1);

namespace tests\Meals\Unit\Application\Component\Validator;

use Meals\Application\Component\Validator\EmployeeCanChooseDishValidator;
use Meals\Application\Component\Validator\Exception\EmployeeAlreadyChoseDishException;
use Meals\Domain\Employee\Employee;
use Meals\Domain\Poll\PollResult;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class EmployeeCanChooseDishValidatorTest extends TestCase
{
    use ProphecyTrait;

    public function testSuccessful(): void
    {
        $employee1 = $this->prophesize(Employee::class);
        $employee1->getId()->willReturn(1);
        $employee2 = $this->prophesize(Employee::class);
        $employee2->getId()->willReturn(2);

        $pollResult = $this->prophesize(PollResult::class);
        $pollResult->getEmployee()->willReturn($employee2->reveal());

        $pollResults = [
            $pollResult->reveal(),
        ];

        $validator = new EmployeeCanChooseDishValidator();
        verify($validator->validate($employee1->reveal(), $pollResults))->null();
    }

    public function testFail(): void
    {
        $this->expectException(EmployeeAlreadyChoseDishException::class);

        $employee = $this->prophesize(Employee::class);
        $employee->getId()->willReturn(1);

        $pollResult = $this->prophesize(PollResult::class);
        $pollResult->getEmployee()->willReturn($employee->reveal());

        $pollResults = [
            $pollResult->reveal(),
        ];

        $validator = new EmployeeCanChooseDishValidator();
        verify($validator->validate($employee->reveal(), $pollResults))->null();
    }
}
