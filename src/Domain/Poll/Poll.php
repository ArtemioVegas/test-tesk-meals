<?php

namespace Meals\Domain\Poll;

use Meals\Domain\Menu\Menu;

class Poll
{
    /** @var int */
    private $id;

    /** @var bool */
    private $isActive;

    /** @var Menu */
    private $menu;

    /**
     * Poll constructor.
     * @param int $id
     * @param bool $isActive
     * @param Menu $menu
     */
    public function __construct(int $id, bool $isActive, Menu $menu)
    {
        $this->id = $id;
        $this->isActive = $isActive;
        $this->menu = $menu;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * @return Menu
     */
    public function getMenu(): Menu
    {
        return $this->menu;
    }
}
