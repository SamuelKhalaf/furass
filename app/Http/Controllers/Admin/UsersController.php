<?php

namespace App\Http\Controllers\Admin;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\School;
use App\Models\User;
use App\Services\IRoleService;
use App\Services\IUserService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;

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
        $roles = [RoleEnum::CONSULTANT->value, RoleEnum::SCHOOL->value, RoleEnum::STUDENT->value];
        $roles = Role::whereNotIN('name', $roles)->get();
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

        // Handle schools if a sub-admin role is selected
        if ($request->input('role') === RoleEnum::SUB_ADMIN->value && $request->has('schools')) {
            $created->schools()->sync($request->input('schools', []));
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
            'country_code'  => $user->country_code,
            'role'          => $user->roles->first()?->name,
            'is_active'     => $user->is_active,
            'schools' => $user->schools()
                ->join('users', 'schools.user_id', '=', 'users.id')
                ->select('schools.id', 'users.name')
                ->get(),
            'all_schools' => School::with('user:id,name')->get(),
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

        // Handle schools if a sub-admin role is selected
        $user = $this->userService->findUser($id);
        if ($request->input('role') === RoleEnum::SUB_ADMIN->value) {
            $user->schools()->sync($request->input('schools', []));
        } elseif ($request->input('role') !== RoleEnum::SUB_ADMIN->value) {
            // Remove all schools if a role is not sub-admin
            $user->schools()->detach();
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

    public function searchUsers(Request $request)
    {
        $users = User::where('name', 'LIKE', "%{$request->q}%")
            ->orWhere('email', 'LIKE', "%{$request->q}%")
            ->select('id', 'name', 'email')
            ->limit(30)
            ->get();

        return response()->json([
            'items' => $users->map(function($user) {
                return [
                    'id' => $user->id,
                    'text' => $user->name,
                    'name' => $user->name,
                    'email' => $user->email
                ];
            }),
            'total_count' => $users->count()
        ]);
    }

}
