<?php

declare(strict_types=1);

namespace Meals\Application\Feature\Poll\UseCase\EmployeeChoosesDish;

use Meals\Application\Component\Provider\DishProviderInterface;
use Meals\Application\Component\Provider\EmployeeProviderInterface;
use Meals\Application\Component\Provider\PollProviderInterface;
use Meals\Application\Component\Provider\PollResultProviderInterface;
use Meals\Application\Component\Validator\DishChooseAllowedDatetimeValidator;
use Meals\Application\Component\Validator\DishListHasDishValidator;
use Meals\Application\Component\Validator\EmployeeCanChooseDishValidator;
use Meals\Application\Component\Validator\PollIsActiveValidator;
use Meals\Application\Component\Validator\UserCanParticipateInPollsValidator;
use Meals\Application\Component\Validator\UserHasAccessToViewPollsValidator;
use Meals\Domain\Poll\PollResult;

class Interactor
{
    /** @var EmployeeProviderInterface */
    private $employeeProvider;

    /** @var PollProviderInterface */
    private $pollProvider;

    /** @var DishProviderInterface */
    private $dishProvider;

    /** @var PollResultProviderInterface */
    private $pollResultProvider;

    /** @var EmployeeCanChooseDishValidator */
    private $employeeCanChooseDishValidator;

    /** @var UserHasAccessToViewPollsValidator */
    private $userHasAccessToViewPollsValidator;

    /** @var UserCanParticipateInPollsValidator */
    private $userCanParticipateInPollsValidator;

    /** @var PollIsActiveValidator */
    private $pollIsActiveValidator;

    /** @var DishListHasDishValidator */
    private $dishListHasDishValidator;

    /** @var DishChooseAllowedDatetimeValidator */
    private $dishChooseAllowedDatetimeValidator;

    public function __construct(
        EmployeeProviderInterface          $employeeProvider,
        PollProviderInterface              $pollProvider,
        DishProviderInterface              $dishProvider,
        PollResultProviderInterface        $pollResultProvider,
        EmployeeCanChooseDishValidator     $employeeCanChooseDishValidator,
        UserHasAccessToViewPollsValidator  $userHasAccessToViewPollsValidator,
        UserCanParticipateInPollsValidator $userCanParticipateInPollsValidator,
        PollIsActiveValidator              $pollIsActiveValidator,
        DishListHasDishValidator           $dishListHasDishValidator,
        DishChooseAllowedDatetimeValidator $dishChooseAllowedDatetimeValidator
    ) {
        $this->employeeProvider = $employeeProvider;
        $this->pollProvider = $pollProvider;
        $this->dishProvider = $dishProvider;
        $this->pollResultProvider = $pollResultProvider;
        $this->employeeCanChooseDishValidator = $employeeCanChooseDishValidator;
        $this->userHasAccessToViewPollsValidator = $userHasAccessToViewPollsValidator;
        $this->userCanParticipateInPollsValidator = $userCanParticipateInPollsValidator;
        $this->pollIsActiveValidator = $pollIsActiveValidator;
        $this->dishListHasDishValidator = $dishListHasDishValidator;
        $this->dishChooseAllowedDatetimeValidator = $dishChooseAllowedDatetimeValidator;
    }

    public function chooseDish(int $employeeId, int $pollId, int $dishId, \DateTimeInterface $dateTime): PollResult
    {
        $pollResults = $this->pollResultProvider->getPollResults();
        $employee = $this->employeeProvider->getEmployee($employeeId);
        $poll = $this->pollProvider->getPoll($pollId);
        $dishList = $poll->getMenu()->getDishes();
        $dish = $this->dishProvider->getDish($dishId);

        $this->employeeCanChooseDishValidator->validate($employee, $pollResults);
        $this->userHasAccessToViewPollsValidator->validate($employee->getUser());
        $this->pollIsActiveValidator->validate($poll);
        $this->userCanParticipateInPollsValidator->validate($employee->getUser());
        $this->dishListHasDishValidator->validate($dishList, $dish);
        $this->dishChooseAllowedDatetimeValidator->validate($dateTime);

        return $this->pollResultProvider->createPollResult($poll, $employee, $dish);
    }
}
