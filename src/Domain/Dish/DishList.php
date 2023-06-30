<?php

namespace Meals\Domain\Dish;

use Assert\Assertion;

class DishList
{
    /** @var Dish[] */
    private $dishes;

    /**
     * DishList constructor.
     * @param Dish[] $dishes
     */
    public function __construct(array $dishes)
    {
        Assertion::allIsInstanceOf($dishes, Dish::class);
        $this->dishes = $dishes;
    }

    /**
     * @return Dish[]
     */
    public function getDishes(): array
    {
        return $this->dishes;
    }

    public function hasDish(Dish $needle): bool
    {
        foreach ($this->dishes as $dish) {
            if ($dish->getId() == $needle->getId()) {
                return true;
            }
        }

        return false;
    }
}
