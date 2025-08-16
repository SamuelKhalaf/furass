<?php

namespace App\Services;


use App\Dto\StorePermissionDto;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;

interface IPermissionService
{
    /**
     * @return JsonResponse
     */
    public function getPermissionsDatatable(): JsonResponse;

    /**
     * @param StorePermissionDto $dto
     * @return Permission
     */
    public function storePermission(StorePermissionDto $dto): Permission;

    /**
     * @param string $id
     * @return bool
     */
    public function deletePermission(string $id): bool;

    /**
     * @return Collection
     */
    public function getFormattedPermissions(): Collection;
}
