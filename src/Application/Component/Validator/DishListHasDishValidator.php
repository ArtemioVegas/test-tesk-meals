<?php

declare(strict_types=1);

namespace Meals\Application\Component\Validator;

use Meals\Application\Component\Validator\Exception\DishMissingInDishListException;
use Meals\Domain\Dish\Dish;
use Meals\Domain\Dish\DishList;

class DishListHasDishValidator
{
    public function validate(DishList $dishList, Dish $dish): void
    {
        if (!$dishList->hasDish($dish)) {
            throw new DishMissingInDishListException();
        }
    }
}
