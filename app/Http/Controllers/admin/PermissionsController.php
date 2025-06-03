<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\StorePermissionRequest;
use App\Services\IPermissionService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PermissionsController extends Controller
{
    protected IPermissionService $permissionService;

    /**
     * @param IPermissionService $permissionService
     */
    public function __construct(IPermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    /**
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.permissions.index');
    }

    /**
     * @return JsonResponse
     */
    public function getPermissionsDatatable(): JsonResponse
    {
        return $this->permissionService->getPermissionsDatatable();
    }

    /**
     * @param StorePermissionRequest $request
     * @return JsonResponse
     */
    public function store(StorePermissionRequest $request): JsonResponse
    {
        $dto = $request->getDto();
        $this->permissionService->storePermission($dto);

        return response()->json([
            'status' => 'success',
            'message' => 'Permission added successfully!',
        ], 201);
    }

    /**
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $deleted = $this->permissionService->deletePermission($id);

        if (!$deleted) {
            return response()->json([
                'message' => 'Cannot delete this permission. It is assigned to one or more roles. Remove the assignment first.'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json([
            'message' => 'Permission deleted successfully',
        ], Response::HTTP_OK);
    }
}
