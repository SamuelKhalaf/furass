<?php
namespace App\Services\implementation;

use App\Dto\StorePermissionDto;
use App\Enums\PermissionEnum;
use App\Repositories\IPermissionRepository;
use App\Services\IPermissionService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class PermissionService implements IPermissionService
{
    private IPermissionRepository $permissionRepository;

    /**
     * @param IPermissionRepository $permissionRepository
     */
    public function __construct(IPermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * @return JsonResponse
     * @throws \Exception
     */
    public function getPermissionsDatatable(): JsonResponse
    {
        $permissions = $this->permissionRepository->getAllPermissionsWithRoles();

        return DataTables::of($permissions)
            ->addColumn('assigned_roles', function ($permission) {
                $roleColors = [
                    'Admin' => 'primary',
                    'Consultant' => 'info',
                    'School' => 'success',
                    'Student' => 'danger',
                ];

                return $permission->roles->pluck('name')->map(function ($role) use ($roleColors) {
                    $color = $roleColors[$role] ?? 'warning';
                    return '<span class="badge badge-light-' . $color . ' fs-7 m-1">' . $role . '</span>';
                })->implode(' ');
            })
            ->addColumn('actions', function ($permission) {
                if (auth()->user()->hasPermissionTo(PermissionEnum::DELETE_PERMISSIONS->value)) {
                    return '<a href="#" class="btn btn-danger btn-sm me-lg-n7" data-id="' . $permission->id . '" data-kt-permissions-table-filter="delete_row">
                           <i class="fas fa-trash"></i>
                            Delete
                        </a>
                ';
                }
                return '';
            })
            ->editColumn('created_at', function ($permission) {
                return Carbon::parse($permission->created_at)->format('d M Y, h:i A');
            })
            ->rawColumns(['assigned_roles', 'actions'])
            ->make(true);
    }

    /**
     * @param StorePermissionDto $dto
     * @return Permission
     */
    public function storePermission(StorePermissionDto $dto): Permission
    {
        return $this->permissionRepository->store($dto->toArray());
    }

    /**
     * @param string $id
     * @return bool
     */
    public function deletePermission(string $id): bool
    {
        return $this->permissionRepository->delete($id);
    }

    public function getFormattedPermissions(): Collection
    {
        $permissions = $this->permissionRepository->getAllPermissions();

        // Group by the last word in the permission name
        $groupedPermissions = $permissions->groupBy(function ($permission) {
            $words = explode(' ', $permission->name);
            return array_pop($words); // Get the last word (category)
        });

        // Trim redundant words
        return $groupedPermissions->map(function ($permissions, $category) {
            return $permissions->map(function ($permission) use ($category) {
                return [
                    'id' => $permission->id,
                    'name' => Str::replace(" $category", '', $permission->name), // Remove redundant word
                ];
            });
        });
    }
}
