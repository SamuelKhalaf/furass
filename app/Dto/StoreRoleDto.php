<?php

namespace App\Dto;

class StoreRoleDto
{
    private string $role_name;

    private array $permissions;

    /**
     * @param string $role_name
     * @param array $permissions
     */
    public function __construct(string $role_name, array $permissions)
    {
        $this->role_name = $role_name;
        $this->permissions = $permissions;
    }

    public function getRoleName(): string
    {
        return $this->role_name;
    }

    public function getPermissions(): array
    {
        return $this->permissions;
    }

    /**
     * @return string[]
     */
    public function toArray(): array
    {
        return [
            'name' => $this->role_name,
            'permissions' => $this->permissions,
        ];
    }
}
