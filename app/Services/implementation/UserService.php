<?php
namespace App\Services\implementation;

use App\Dto\CreateUserDto;
use App\Dto\UpdateUserDto;
use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
use App\Models\User;
use App\Repositories\IUserRepository;
use App\Services\IUserService;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\DataTables;

class UserService implements IUserService
{
    /**
     * @var IUserRepository
     */
    private IUserRepository $userRepository;

    /**
     * @param IUserRepository $userRepository
     */
    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return JsonResponse
     * @throws \Exception
     */
    public function getUsersDatatable():JsonResponse
    {
        // get users order by id desc
        $users = $this->userRepository->getAll();

        return DataTables::of($users)
            ->addColumn('role', function ($user) {
                return $user->roles->first()?->name;
            })
            ->addColumn('actions', function ($user) {
                $actions = '';

                if (auth()->user()->hasAnyPermission([
                    PermissionEnum::UPDATE_USERS->value,
                    PermissionEnum::DELETE_USERS->value
                ])) {
                    $actions = '<a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    '.__("users.actions").'
                                    <span class="svg-icon svg-icon-5 m-0">
                                       <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                           <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
                                       </svg>
                                   </span>
                                </a>';

                    $actions .= '<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">';

                    if (auth()->user()->hasPermissionTo(PermissionEnum::UPDATE_USERS->value)) {
                        $actions .= '<div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-user-id="' . $user->id . '" data-bs-toggle="modal" data-bs-target="#kt_modal_update_details">
                                '.__("users.edit").'
                            </a>
                        </div>';
                    }

                    if (auth()->user()->hasPermissionTo(PermissionEnum::DELETE_USERS->value)) {
                        $actions .= '<div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row"
                               data-user-id="' . $user->id . '">'.__("users.delete").'</a>
                        </div>';
                    }

                    $actions .= '</div>';
                }
                return $actions;
            })
            ->addColumn('created_at' , function ($row) {
                return $row->created_at->format('Y-m-d');
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    /**
     * @param int $id
     * @return User|null
     */
    public function findUser(int $id): ?User
    {
        return $this->userRepository->findUserById($id);
    }

    /**
     * @param CreateUserDto $dto
     * @return User|null
     */
    public function createUser(CreateUserDto $dto): ?User
    {
        try {
            $data = [
                'name' => $dto->getName(),
                'email' => $dto->getEmail(),
                'phone_number' => $dto->getPhoneNumber(),
                'password' => $dto->getPassword(),
                'is_active' => $dto->getIsActive(),
                'role' => $dto->getRole(),
            ];

            $user = $this->userRepository->create($data);
            $user->assignRole($dto->getRole());

            return $user;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * @param int $id
     * @param UpdateUserDto $dto
     * @return bool
     */
    public function updateUser(int $id, UpdateUserDto $dto): bool
    {
        try {
            $data = [
                'name' => $dto->getName(),
                'email' => $dto->getEmail(),
                'phone_number' => $dto->getPhoneNumber(),
                'is_active' => $dto->getIsActive(),
            ];

            $user = $this->userRepository->update($id, $data);
            $user->syncRoles($dto->getRole());

            return true;
        } catch (\Exception $e) {

            return false;
        }
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteUser(int $id): bool
    {
        return $this->userRepository->delete($id);
    }
}
