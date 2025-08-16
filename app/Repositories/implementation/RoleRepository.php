<?php
namespace App\Repositories\implementation;

use App\Models\User;
use App\Repositories\IRoleRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleRepository implements IRoleRepository
{
    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Role::all();
    }

    /**
     * @param string $id
     * @return Role|null
     */
    public function findById(string $id): ?Role
    {
        return Role::find($id);
    }

    /**
     * @param string $id
     * @return Builder|array|\Illuminate\Database\Eloquent\Collection|Model
     */
    public function findRoleWithUsersAndPermissions(string $id): Builder|array|\Illuminate\Database\Eloquent\Collection|Model
    {
        return Role::with(['users', 'permissions'])->findOrFail($id);
    }

    /**
     * @param string $id
     * @return Builder|array|\Illuminate\Database\Eloquent\Collection|Model
     */
    public function findRoleWithPermissions(string $id): Builder|array|\Illuminate\Database\Eloquent\Collection|Model
    {
        return Role::with('permissions')->findOrFail($id);
    }

    /**
     * @return Collection
     */
    public function getRolesWithPermissionsAndUsersCount(): Collection
    {
        return Role::with('permissions')->withCount('users')->get();
    }

    /**
     * @param array $data
     * @return Role|null
     */
    public function store(array $data): ?Role
    {
        try {
            DB::beginTransaction();

            $role = Role::create(['name' => $data['name']]);
            if (!empty($data['permissions'])) {
                $permissionNames = Permission::whereIn('id', $data['permissions'])->pluck('name');
                $role->syncPermissions($permissionNames);
            }

            DB::commit();
            return $role;
        } catch (\Exception $e) {
            DB::rollBack();
            return null;
        }
    }

    /**
     * @param string $id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRoleUsers(string $id): \Illuminate\Database\Eloquent\Collection
    {
        $role = Role::findOrFail($id);
        return $role->users()->select(['id', 'name', 'created_at'])->get();
    }

    /**
     * @param string $roleId
     * @param string $userId
     * @return bool
     */
    public function detachUserFromRole(string $roleId, string $userId): bool
    {
        $user = User::find($userId);
        $role = Role::find($roleId);

        if (!$user || !$role) {
            return false;
        }

        return (bool) $user->roles()->detach($role->id);
    }

    /**
     * @param string $id
     * @param array $data
     * @return Role|null
     */
    public function updateRole(string $id, array $data): ?Role
    {
        try {
            DB::beginTransaction();
            $role = Role::findOrFail($id);
            $role->name = $data['name'];
            $role->save();

            if (!empty($data['permissions'])) {
                $permissionNames = Permission::whereIn('id', $data['permissions'])->pluck('name');
                $role->syncPermissions($permissionNames);
            } else {
                $role->syncPermissions([]);
            }

            DB::commit();
            return $role;
        } catch (\Exception $e) {
            DB::rollBack();
            return null;
        }
    }

    /**
     * @param Role $role
     * @param bool $forceDelete
     * @return bool
     */
    public function delete(Role $role, bool $forceDelete): bool
    {

        try {
            DB::beginTransaction();

            if ($forceDelete) {
                foreach ($role->users as $user) {
                    $user->removeRole($role);
                }
            }
            $role->permissions()->detach();

            DB::commit();
            return $role->delete();
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}
