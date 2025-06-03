<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;

interface IRoleRepository
{
    /**
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * @param string $id
     * @return Role|null
     */
    public function findById(string $id): ?Role;

    /**
     * @param string $id
     * @return Builder|array|Collection|Model
     */
    public function findRoleWithUsersAndPermissions(string $id): Builder|array|\Illuminate\Database\Eloquent\Collection|Model;

    /**
     * @param string $id
     * @return Builder|array|\Illuminate\Database\Eloquent\Collection|Model
     */
    public function findRoleWithPermissions(string $id): Builder|array|\Illuminate\Database\Eloquent\Collection|Model;

    /**
     * @return Collection
     */
    public function getRolesWithPermissionsAndUsersCount(): Collection;

    /**
     * @param array $data
     * @return Role|null
     */
    public function store(array $data): ?Role;

    /**
     * @param string $id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRoleUsers(string $id): \Illuminate\Database\Eloquent\Collection;

    /**
     * @param string $roleId
     * @param string $userId
     * @return bool
     */
    public function detachUserFromRole(string $roleId, string $userId): bool;

    /**
     * @param string $id
     * @param array $data
     * @return Role|null
     */
    public function updateRole(string $id, array $data): ?Role;

    /**
     * @param Role $role
     * @param bool $forceDelete
     * @return bool
     */
    public function delete(Role $role, bool $forceDelete): bool;
}
