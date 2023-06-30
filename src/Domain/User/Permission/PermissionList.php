<?php

namespace Meals\Domain\User\Permission;

use Assert\Assertion;

class PermissionList
{
    /** @var Permission[] */
    private $permissions;

    /**
     * PermissionList constructor.
     * @param Permission[] $permissions
     */
    public function __construct(array $permissions)
    {
        Assertion::allIsInstanceOf($permissions, Permission::class);
        $this->permissions = $permissions;
    }

    /**
     * @return Permission[]
     */
    public function getPermissions(): array
    {
        return $this->permissions;
    }

    public function hasPermission(Permission $needle): bool
    {
        return in_array($needle, $this->getPermissions());
    }
}
