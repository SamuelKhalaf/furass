<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRoleRequest;
use App\Http\Requests\Admin\UpdateRoleRequest;
use App\Models\User;
use App\Services\IPermissionService;
use App\Services\IRoleService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\DataTables;

class RolesController extends Controller
{

    private IRoleService $roleService;

    private IPermissionService $permissionService;

    /**
     * @param IRoleService $roleService
     * @param IPermissionService $permissionService
     */
    public function __construct(IRoleService $roleService, IPermissionService $permissionService)
    {
        $this->roleService = $roleService;
        $this->permissionService = $permissionService;
    }

    /**
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $formattedPermissions = $this->permissionService->getFormattedPermissions();
        $roles = $this->roleService->getRolesWithPermissionsAndUsersCount();

        return view('admin.roles.index',compact('roles','formattedPermissions'));
    }

    /**
     * @param StoreRoleRequest $request
     * @return JsonResponse
     */
    public function store(StoreRoleRequest $request): JsonResponse
    {
        $dto = $request->getDto();
        $stored =  $this->roleService->storeRole($dto);

        if (!$stored) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while Store the role data.',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'success' => true,
            'message' => 'Role added successfully!',
        ]);
    }

    /**
     * @param string $id
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function show(string $id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $role = $this->roleService->getRoleById($id);

        return view('admin.roles.show', compact('role'));
    }

    /**
     * @param string $id
     * @return JsonResponse
     */
    public function getSpecificRoleUsersData(string $id): JsonResponse
    {
        return $this->roleService->getRoleUsersDataTable($id);
    }

    /**
     * @param $roleId
     * @param $userId
     * @return JsonResponse
     */
    public function deleteUsersAssignedToRole($roleId, $userId): JsonResponse
    {
        $removed = $this->roleService->removeUserFromRole($roleId, $userId);

        if(!$removed) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json(['success' => true, 'message' => 'Role detached successfully.']);
    }

    /**
     * @param string $id
     * @return JsonResponse
     */
    public function edit(string $id): JsonResponse
    {
        $data = $this->roleService->getRoleEditData($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Role not found or error retrieving data.',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'role' => $data['role'],
            'permissions' => $data['permissions'],
            'assigned_permissions' => $data['assigned_permissions'],
            'formatted_permissions' => $data['formatted_permissions']
        ]);
    }

    /**
     * @param UpdateRoleRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(UpdateRoleRequest $request, string $id): JsonResponse
    {
        $dto = $request->getDto();
        $updated = $this->roleService->updateRole($id, $dto);

        if (!$updated) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update role.',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'success' => true,
            'message' => 'Role updated successfully!',
        ], Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(Request $request, string $id): JsonResponse
    {
        $forceDelete = (bool) $request->input('force', false);
        return $this->roleService->deleteRole($id, $forceDelete);
    }
}
