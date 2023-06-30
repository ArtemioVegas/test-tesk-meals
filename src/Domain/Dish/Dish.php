<?php

namespace Meals\Domain\Dish;

class Dish
{
    /** @var int */
    private $id;

    /** @var string */
    private $title;

    /** @var string */
    private $description;

    /**
     * Dish constructor.
     * @param int $id
     * @param string $title
     * @param string $description
     */
    public function __construct(int $id, string $title, string $description)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
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
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
}
