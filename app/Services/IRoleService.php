<?php

namespace App\Services;


use App\Dto\StoreRoleDto;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;

interface IRoleService
{
    /**
     * @return Collection
     */
    public function getAllRoles(): Collection;

    /**
     * @param string $id
     * @return Builder|array|\Illuminate\Database\Eloquent\Collection|Model
     */
    public function getRoleById(string $id): Builder|array|\Illuminate\Database\Eloquent\Collection|Model;

    /**
     * @return Collection
     */
    public function getRolesWithPermissionsAndUsersCount(): Collection;

    /**
     * @param StoreRoleDto $dto
     * @return Role|null
     */
    public function storeRole(StoreRoleDto $dto): ?Role;

    /**
     * @param string $id
     * @return JsonResponse
     */
    public function getRoleUsersDataTable(string $id): JsonResponse;

    /**
     * @param string $roleId
     * @param string $userId
     * @return bool
     */
    public function removeUserFromRole(string $roleId, string $userId): bool;

    /**
     * @param string $id
     * @return array|null
     */
    public function getRoleEditData(string $id): ?array;

    /**
     * @param string $id
     * @param StoreRoleDto $dto
     * @return Role|null
     */
    public function updateRole(string $id, StoreRoleDto $dto): ?Role;

    /**
     * @param string $id
     * @param bool $forceDelete
     * @return JsonResponse
     */
    public function deleteRole(string $id, bool $forceDelete): JsonResponse;
}
