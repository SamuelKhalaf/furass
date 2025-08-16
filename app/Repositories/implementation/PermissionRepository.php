<?php
namespace App\Repositories\implementation;

use App\Repositories\IPermissionRepository;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;

class PermissionRepository implements IPermissionRepository
{
    /**
     * @return Collection
     */
    public function getAllPermissions(): Collection
    {
        return Permission::all();
    }

    /**
     * @return Collection
     */
    public function getAllPermissionsWithRoles(): Collection
    {
        return Permission::select(['id', 'name', 'created_at'])->with('roles')->get();
    }

    /**
     * @param array $data
     * @return Permission
     */
    public function store(array $data): Permission
    {
        return Permission::create($data);
    }

    /**
     * @param string $id
     * @return bool
     */
    public function delete(string $id): bool
    {
        $permission = Permission::findOrFail($id);

        // Prevent delete if assigned to roles
        if ($permission->roles()->count() > 0) {
            return false;
        }

        return $permission->delete();
    }
}
