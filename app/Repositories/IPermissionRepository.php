<?php

namespace App\Repositories;

use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;

interface IPermissionRepository
{
    /**
     * @return Collection
     */
    public function getAllPermissions(): Collection;

    /**
     * @return Collection
     */
    public function getAllPermissionsWithRoles(): Collection;

    /**
     * @param array $data
     * @return Permission
     */
    public function store(array $data): Permission;

    /**
     * @param string $id
     * @return bool
     */
    public function delete(string $id): bool;

}
