<?php

declare(strict_types=1);

namespace tests\Meals\Unit\Application\Component\Validator;

use Meals\Application\Component\Validator\DishListHasDishValidator;
use Meals\Application\Component\Validator\Exception\DishMissingInDishListException;
use Meals\Domain\Dish\Dish;
use Meals\Domain\Dish\DishList;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class DishListHasDishValidatorTest extends TestCase
{
    use ProphecyTrait;

    public function testSuccessful(): void
    {
        $dishList = $this->prophesize(DishList::class);
        $dish = $this->prophesize(Dish::class);
        $dishList->hasDish($dish->reveal())->willReturn(true);

        $validator = new DishListHasDishValidator();
        verify($validator->validate($dishList->reveal(), $dish->reveal()))->null();
    }

    public function testFail(): void
    {
        $this->expectException(DishMissingInDishListException::class);

        $dishList = $this->prophesize(DishList::class);
        $dish = $this->prophesize(Dish::class);
        $dishList->hasDish($dish->reveal())->willReturn(false);

        $validator = new DishListHasDishValidator();
        verify($validator->validate($dishList->reveal(), $dish->reveal()))->null();
    }
}
