<?php

declare(strict_types=1);

namespace tests\Meals\Functional\Fake\Provider;

use Meals\Application\Component\Provider\DishProviderInterface;
use Meals\Domain\Dish\Dish;

class FakeDishProvider implements DishProviderInterface
{
    /** @var Dish */
    private $dish;

    public function getDish(int $dishId): Dish
    {
        return $this->dish;
    }

    public function setDish(Dish $dish): void
    {
        $this->dish = $dish;
    }
}
