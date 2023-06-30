<?php

namespace Meals\Application\Feature\Poll\UseCase\EmployeeGetsActivePolls;

use Meals\Application\Component\Provider\PollProviderInterface;
use Meals\Application\Component\Provider\EmployeeProviderInterface;
use Meals\Application\Component\Validator\UserHasAccessToViewPollsValidator;
use Meals\Domain\Poll\PollList;

class Interactor
{
    /** @var EmployeeProviderInterface */
    private $employeeProvider;

    /** @var PollProviderInterface */
    private $pollProvider;

    /** @var UserHasAccessToViewPollsValidator */
    private $userHasAccessToPollsValidator;

    /**
     * Interactor constructor.
     * @param EmployeeProviderInterface $employeeProvider
     * @param PollProviderInterface $pollProvider
     * @param UserHasAccessToViewPollsValidator $userHasAccessToPollsValidator
     */
    public function __construct(
        EmployeeProviderInterface $employeeProvider,
        PollProviderInterface $pollProvider,
        UserHasAccessToViewPollsValidator $userHasAccessToPollsValidator
    ) {
        $this->employeeProvider = $employeeProvider;
        $this->pollProvider = $pollProvider;
        $this->userHasAccessToPollsValidator = $userHasAccessToPollsValidator;
    }

    /**
     * @param int $employeeId
     * @return PollList
     */
    public function getActivePolls(int $employeeId): PollList
    {
        $employee = $this->employeeProvider->getEmployee($employeeId);

        $this->userHasAccessToPollsValidator->validate($employee->getUser());

        return $this->pollProvider->getActivePolls();
    }
}
