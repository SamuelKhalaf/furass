<?php

namespace App\Dto;

class StorePermissionDto
{
    private string $permission_name;

    /**
     * @param string $permission_name
     */
    public function __construct(string $permission_name)
    {
        $this->permission_name = $permission_name;
    }

    /**
     * @return string
     */
    public function getPermissionName(): string
    {
        return $this->permission_name;
    }

    /**
     * @return string[]
     */
    public function toArray(): array
    {
        return [
            'name' => $this->permission_name,
        ];
    }
}
