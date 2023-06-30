<?php

namespace Meals\Domain\Poll;

use Assert\Assertion;

class PollList
{
    /** @var Poll[] */
    private $polls;

    /**
     * PollList constructor.
     * @param Poll[] $polls
     */
    public function __construct(array $polls)
    {
        Assertion::allIsInstanceOf($polls, Poll::class);
        $this->polls = $polls;
    }

    /**
     * @return Poll[]
     */
    public function getPolls(): array
    {
        return $this->polls;
    }

}
