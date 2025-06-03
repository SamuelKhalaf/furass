<?php
namespace App\Services\implementation;

use App\Dto\StoreRoleDto;
use App\Enums\PermissionEnum;
use App\Repositories\IPermissionRepository;
use App\Repositories\IRoleRepository;
use App\Services\IRoleService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\DataTables;

class RoleService implements IRoleService
{
    /**
     * @var IRoleRepository
     */
    private IRoleRepository $roleRepository;

    private IPermissionRepository $permissionRepository;

    /**
     * @param IRoleRepository $roleRepository
     */
    public function __construct(IRoleRepository $roleRepository, IPermissionRepository $permissionRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * @return Collection
     */
    public function getAllRoles():Collection
    {
        return $this->roleRepository->getAll();
    }

    /**
     * @param string $id
     * @return Builder|array|\Illuminate\Database\Eloquent\Collection|Model
     */
    public function getRoleById(string $id): Builder|array|\Illuminate\Database\Eloquent\Collection|Model
    {
        return $this->roleRepository->findRoleWithUsersAndPermissions($id);
    }

    public function getRolesWithPermissionsAndUsersCount(): Collection
    {
        return $this->roleRepository->getRolesWithPermissionsAndUsersCount();
    }

    /**
     * @param StoreRoleDto $dto
     * @return Role|null
     */
    public function storeRole(StoreRoleDto $dto): ?Role
    {
        return $this->roleRepository->store($dto->toArray());
    }

    public function getRoleUsersDataTable(string $id): JsonResponse
    {
        $users = $this->roleRepository->getRoleUsers($id);

        return DataTables::of($users)
            ->addColumn('actions', function ($user) use ($id) {
                if (auth()->user()->hasPermissionTo(PermissionEnum::DELETE_ROLES->value)) {
                    return '<a href="#" data-kt-roles-table-filter="delete_row" data-role-id="' . $id . '" data-user-id="' . $user->id . '" class="btn btn-sm btn-light-danger deleteUser">
                            <i class="bi bi-trash"></i> Delete
                        </a>';
                }
                return '';
            })
            ->editColumn('created_at', function ($user) {
                return $user->created_at->format('D d, M Y');
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    /**
     * @param string $roleId
     * @param string $userId
     * @return bool
     */
    public function removeUserFromRole(string $roleId, string $userId): bool
    {
       return $this->roleRepository->detachUserFromRole($roleId, $userId);
    }

    /**
     * @param string $id
     * @return array|null
     */
    public function getRoleEditData(string $id): ?array
    {
        try {
            $role = $this->roleRepository->findRoleWithPermissions($id);
            $permissions = $this->permissionRepository->getAllPermissions();
            $assignedPermissions = $role->permissions->pluck('id')->toArray();

            // Group permissions by the last word in the name
            $groupedPermissions = $permissions->groupBy(function ($permission) {
                $words = explode(' ', $permission->name);
                return array_pop($words); // Get the last word (category)
            });

            // Trim redundant words
            $formattedPermissions = $groupedPermissions->map(function ($permissions, $category) {
                return $permissions->map(function ($permission) use ($category) {
                    return [
                        'id' => $permission->id,
                        'name' => Str::replace(" $category", '', $permission->name), // Remove redundant word
                    ];
                });
            });

            return [
                'role' => $role,
                'permissions' => $permissions,
                'assigned_permissions' => $assignedPermissions,
                'formatted_permissions' => $formattedPermissions,
            ];
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * @param string $id
     * @param StoreRoleDto $dto
     * @return Role|null
     */
    public function updateRole(string $id, StoreRoleDto $dto): ?Role
    {
        $data = $dto->toArray();
        return $this->roleRepository->updateRole($id, $data);
    }


    public function deleteRole(string $id, bool $forceDelete): JsonResponse
    {
        $role = $this->roleRepository->findById($id);

        if (!$role) {
            return response()->json([
                'success' => false,
                'message' => 'Role not found.'
            ], Response::HTTP_NOT_FOUND);
        }

        // Check if role is assigned to any users
        if ($role->users()->count() > 0 && !$forceDelete) {
            return response()->json([
                'success' => false,
                'message' => 'This role is assigned to users. Force delete is required!'
            ], Response::HTTP_BAD_REQUEST);
        }

        // Perform deletion
        $deleted = $this->roleRepository->delete($role, $forceDelete);

        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete the role.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'success' => true,
            'message' => 'Role deleted successfully!'
        ], Response::HTTP_OK);
    }
}
