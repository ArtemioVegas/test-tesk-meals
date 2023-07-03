<?php

declare(strict_types=1);

namespace tests\Meals\Functional\Interactor;

use Meals\Application\Component\Validator\Exception\AccessDeniedException;
use Meals\Application\Component\Validator\Exception\DishMissingInDishListException;
use Meals\Application\Component\Validator\Exception\EmployeeAlreadyChoseDishException;
use Meals\Application\Component\Validator\Exception\OutOfTimeChooseDishException;
use Meals\Application\Component\Validator\Exception\PollIsNotActiveException;
use Meals\Application\Feature\Poll\UseCase\EmployeeChoosesDish\Interactor;
use Meals\Domain\Dish\Dish;
use Meals\Domain\Dish\DishList;
use Meals\Domain\Employee\Employee;
use Meals\Domain\Menu\Menu;
use Meals\Domain\Poll\Poll;
use Meals\Domain\Poll\PollResult;
use Meals\Domain\User\Permission\Permission;
use Meals\Domain\User\Permission\PermissionList;
use Meals\Domain\User\User;
use tests\Meals\Functional\Fake\Provider\FakeDishProvider;
use tests\Meals\Functional\Fake\Provider\FakeEmployeeProvider;
use tests\Meals\Functional\Fake\Provider\FakePollProvider;
use tests\Meals\Functional\Fake\Provider\FakePollResultProvider;
use tests\Meals\Functional\FunctionalTestCase;

class EmployeeChoosesDishTest extends FunctionalTestCase
{
    public function testSuccessful(): void
    {
        $otherEmployee = $this->getOtherEmployeeWithPermissions();
        $poll = $this->getPoll(true);
        $dish = $this->getDish();
        $dateTime = $this->getRightDateTime();
        $pollResults = $this->getPollResults();

        $pollResult = $this->performTestMethod($otherEmployee, $poll, $dish, $dateTime, $pollResults);
        verify($pollResult)->equals($pollResult);
    }

    public function testSuccessfulEmptyPollResults(): void
    {
        $employee = $this->getEmployeeWithPermissions();
        $poll = $this->getPoll(true);
        $dish = $this->getDish();
        $dateTime = $this->getRightDateTime();
        $pollResults = $this->getEmptyPollResults();

        $pollResult = $this->performTestMethod($employee, $poll, $dish, $dateTime, $pollResults);
        verify($pollResult)->equals($pollResult);
    }

    public function testEmployeeAlreadyChoseDish(): void
    {
        $this->expectException(EmployeeAlreadyChoseDishException::class);

        $employee = $this->getEmployeeWithPermissions();
        $poll = $this->getPoll(true);
        $dish = $this->getDish();
        $dateTime = $this->getRightDateTime();
        $pollResults = $this->getPollResults();

        $pollResult = $this->performTestMethod($employee, $poll, $dish, $dateTime, $pollResults);
        verify($pollResult)->equals($pollResult);
    }

    public function testUserHasNotPermissions(): void
    {
        $this->expectException(AccessDeniedException::class);

        $employee = $this->getEmployeeWithNoPermissions();
        $poll = $this->getPoll(true);
        $dish = $this->getDish();
        $dateTime = $this->getRightDateTime();
        $pollResults = $this->getEmptyPollResults();

        $pollResult = $this->performTestMethod($employee, $poll, $dish, $dateTime, $pollResults);
        verify($pollResult)->equals($pollResult);
    }

    public function testPollIsNotActive(): void
    {
        $this->expectException(PollIsNotActiveException::class);

        $employee = $this->getEmployeeWithPermissions();
        $poll = $this->getPoll(false);
        $dish = $this->getDish();
        $dateTime = $this->getRightDateTime();
        $pollResults = $this->getEmptyPollResults();

        $pollResult = $this->performTestMethod($employee, $poll, $dish, $dateTime, $pollResults);
        verify($pollResult)->equals($pollResult);
    }

    public function testUserWithNoPermissionParticipateInPolls(): void
    {
        $this->expectException(AccessDeniedException::class);

        $employee = $this->getEmployeeWithMissingPermissionParticipationInPolls();
        $poll = $this->getPoll(true);
        $dish = $this->getDish();
        $dateTime = $this->getRightDateTime();
        $pollResults = $this->getEmptyPollResults();

        $pollResult = $this->performTestMethod($employee, $poll, $dish, $dateTime, $pollResults);
        verify($pollResult)->equals($pollResult);
    }

    public function testDishMissingInDishList(): void
    {
        $this->expectException(DishMissingInDishListException::class);

        $employee = $this->getEmployeeWithPermissions();
        $poll = $this->getPoll(true);
        $dish = $this->getOutOfMenuDish();
        $dateTime = $this->getRightDateTime();
        $pollResults = $this->getEmptyPollResults();

        $pollResult = $this->performTestMethod($employee, $poll, $dish, $dateTime, $pollResults);
        verify($pollResult)->equals($pollResult);
    }

    public function testOutOfTimeChooseDish(): void
    {
        $this->expectException(OutOfTimeChooseDishException::class);

        $employee = $this->getEmployeeWithPermissions();
        $poll = $this->getPoll(true);
        $dish = $this->getDish();
        $dateTime = $this->getBadDateTime();
        $pollResults = $this->getEmptyPollResults();

        $pollResult = $this->performTestMethod($employee, $poll, $dish, $dateTime, $pollResults);
        verify($pollResult)->equals($pollResult);
    }

    private function performTestMethod(Employee $employee, Poll $poll, Dish $dish, \DateTimeInterface $dateTime, array $pollResults): PollResult
    {
        $this->getContainer()->get(FakeEmployeeProvider::class)->setEmployee($employee);
        $this->getContainer()->get(FakePollProvider::class)->setPoll($poll);
        $this->getContainer()->get(FakeDishProvider::class)->setDish($dish);
        $this->getContainer()->get(FakePollResultProvider::class)->setPollResults($pollResults);

        return $this->getContainer()->get(Interactor::class)->chooseDish($employee->getId(), $poll->getId(), $dish->getId(), $dateTime, $pollResults);
    }

    private function getEmployeeWithPermissions(): Employee
    {
        return new Employee(
            1,
            $this->getUserWithPermissions(),
            4,
            'Surname'
        );
    }

    private function getOtherEmployeeWithPermissions(): Employee
    {
        return new Employee(
            2,
            $this->getUserWithPermissions(),
            3,
            'Johnson'
        );
    }

    private function getUserWithPermissions(): User
    {
        return new User(
            1,
            new PermissionList(
                [
                    new Permission(Permission::VIEW_ACTIVE_POLLS),
                    new Permission(Permission::PARTICIPATION_IN_POLLS),
                ]
            ),
        );
    }

    private function getEmployeeWithMissingPermissionParticipationInPolls(): Employee
    {
        return new Employee(
            1,
            $this->getUserWithMissingPermissionParticipationInPolls(),
            2,
            'Surname'
        );
    }

    private function getUserWithMissingPermissionParticipationInPolls(): User
    {
        return new User(
            1,
            new PermissionList(
                [
                    new Permission(Permission::VIEW_ACTIVE_POLLS),
                ]
            ),
        );
    }

    private function getEmployeeWithNoPermissions(): Employee
    {
        return new Employee(
            1,
            $this->getUserWithNoPermissions(),
            3,
            'Surname'
        );
    }

    private function getUserWithNoPermissions(): User
    {
        return new User(
            1,
            new PermissionList([]),
        );
    }

    private function getPoll(bool $active): Poll
    {
        return new Poll(
            1,
            $active,
            new Menu(
                1,
                'title',
                new DishList([
                                 $this->getDish(),
                             ]),
            )
        );
    }

    private function getDish(): Dish
    {
        return new Dish(
            1,
            'some random title',
            'some random description',
        );
    }

    private function getOutOfMenuDish(): Dish
    {
        return new Dish(
            2,
            'some random title2',
            'some random description2',
        );
    }

    public function getPollResult(): PollResult
    {
        $employee = $this->getEmployeeWithPermissions();

        return new PollResult(
            1,
            $this->getPoll(true),
            $employee,
            $this->getDish(),
            $employee->getFloor(),
        );
    }

    private function getPollResults(): array
    {
        return [
            $this->getPollResult(),
        ];
    }

    private function getEmptyPollResults(): array
    {
        return [];
    }

    public function getRightDateTime(): \DateTimeImmutable
    {
        return new \DateTimeImmutable('monday 6:00');
    }

    public function getBadDateTime(): \DateTimeImmutable
    {
        return new \DateTimeImmutable('friday 23:00');
    }
}
