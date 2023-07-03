<?php

declare(strict_types=1);

namespace tests\Meals\Unit\Application\Component\Validator;

use Meals\Application\Component\Validator\DishChooseAllowedDatetimeValidator;
use Meals\Application\Component\Validator\Exception\OutOfTimeChooseDishException;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class DishChooseAllowedDatetimeValidatorTest extends TestCase
{
    use ProphecyTrait;

    public function testSuccessful(): void
    {
        $dateTime = new \DateTimeImmutable('monday 6:00');

        $validator = new DishChooseAllowedDatetimeValidator();
        verify($validator->validate($dateTime))->null();
    }

    public function testFailCorrectDayBadTime(): void
    {
        $this->expectException(OutOfTimeChooseDishException::class);

        $dateTime = new \DateTimeImmutable('monday 22:00');
        $validator = new DishChooseAllowedDatetimeValidator();
        $validator->validate($dateTime);
    }

    public function testFailBadDayCorrectTime(): void
    {
        $this->expectException(OutOfTimeChooseDishException::class);

        $dateTime = new \DateTimeImmutable('sunday 15:00');
        $validator = new DishChooseAllowedDatetimeValidator();
        $validator->validate($dateTime);
    }

    public function testFailBadDayBadTime(): void
    {
        $this->expectException(OutOfTimeChooseDishException::class);

        $dateTime = new \DateTimeImmutable('tuesday 03:00');
        $validator = new DishChooseAllowedDatetimeValidator();
        $validator->validate($dateTime);
    }
}
