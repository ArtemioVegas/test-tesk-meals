<?php

namespace Meals\Application\Feature\Poll\UseCase\EmployeeGetsActivePoll;

use Meals\Application\Component\Provider\EmployeeProviderInterface;
use Meals\Application\Component\Provider\PollProviderInterface;
use Meals\Application\Component\Validator\PollIsActiveValidator;
use Meals\Application\Component\Validator\UserHasAccessToViewPollsValidator;
use Meals\Domain\Poll\Poll;

class Interactor
{
    /** @var EmployeeProviderInterface */
    private $employeeProvider;

    /** @var PollProviderInterface */
    private $pollProvider;

    /** @var UserHasAccessToViewPollsValidator */
    private $userHasAccessToPollsValidator;

    /** @var PollIsActiveValidator */
    private $pollIsActiveValidator;

    /**
     * Interactor constructor.
     * @param EmployeeProviderInterface $employeeProvider
     * @param PollProviderInterface $pollProvider
     * @param UserHasAccessToViewPollsValidator $userHasAccessToPollsValidator
     * @param PollIsActiveValidator $pollIsActiveValidator
     */
    public function __construct(
        EmployeeProviderInterface $employeeProvider,
        PollProviderInterface $pollProvider,
        UserHasAccessToViewPollsValidator $userHasAccessToPollsValidator,
        PollIsActiveValidator $pollIsActiveValidator
    ) {
        $this->employeeProvider = $employeeProvider;
        $this->pollProvider = $pollProvider;
        $this->userHasAccessToPollsValidator = $userHasAccessToPollsValidator;
        $this->pollIsActiveValidator = $pollIsActiveValidator;
    }

    public function getActivePoll(int $employeeId, int $pollId): Poll
    {
        $employee = $this->employeeProvider->getEmployee($employeeId);
        $poll = $this->pollProvider->getPoll($pollId);

        $this->userHasAccessToPollsValidator->validate($employee->getUser());

        $this->pollIsActiveValidator->validate($poll);

        return $poll;
    }
}
