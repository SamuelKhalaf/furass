<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Services\IRoleService;
use App\Services\IUserService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UsersController extends Controller
{
    private IUserService $userService;
    private IRoleService $roleService;

    /**
     * @param IUserService $userService
     * @param IRoleService $roleService
     */
    public function __construct(IUserService $userService, IRoleService $roleService)
    {
        $this->userService = $userService;
        $this->roleService = $roleService;
    }

    /**
     * @return Factory|Application|View|\Illuminate\Contracts\Foundation\Application
     */
    public function index(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $roles = $this->roleService->getAllRoles();
        return view('admin.users.index' , compact('roles'));
    }

    /**
     * @return JsonResponse
     */
    public function getUsersDatatable(): JsonResponse
    {
        return $this->userService->getUsersDatatable();
    }

    /**
     * @param CreateUserRequest $request
     * @return JsonResponse
     */
    public function store(CreateUserRequest $request): JsonResponse
    {
        $dto = $request->getDto();

        // create user and assign role
        $created = $this->userService->createUser($dto);

        if (!$created) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong! Please try again later.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'User has been successfully added!',
        ], Response::HTTP_CREATED);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function edit(int $id): JsonResponse
    {
        $user = $this->userService->findUser($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'id'            => $user->id,
            'name'          => $user->name,
            'email'         => $user->email,
            'phone_number'  => $user->phone_number,
            'role'          => $user->roles->first()?->name
        ]);
    }

    /**
     * @param UpdateUserRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request, int $id): JsonResponse
    {
        $dto = $request->getDto();
        //update user and his role
        $updated = $this->userService->updateUser($id,$dto);

        if (!$updated) {
            return response()->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['message' => 'User updated successfully']);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->userService->deleteUser($id);

        if (!$deleted) {
            return response()->json(['success' => false, 'message' => 'Failed to delete the user. Try again Later!'], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['success' => true, 'message' => 'User deleted successfully!']);
    }


}
