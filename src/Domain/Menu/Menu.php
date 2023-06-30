<?php

namespace Meals\Domain\Menu;

use Meals\Domain\Dish\DishList;

class Menu
{
    /** @var int */
    private $id;

    /** @var string */
    private $title;

    /** @var DishList */
    private $dishes;

    /**
     * Menu constructor.
     * @param int $id
     * @param string $title
     * @param DishList $dishes
     */
    public function __construct(int $id, string $title, DishList $dishes)
    {
        $this->id = $id;
        $this->title = $title;
        $this->dishes = $dishes;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return DishList
     */
    public function getDishes(): DishList
    {
        return $this->dishes;
    }
}
