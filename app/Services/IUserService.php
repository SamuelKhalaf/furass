<?php

namespace App\Services;

use App\Dto\CreateUserDto;
use App\Dto\UpdateUserDto;
use App\Models\User;
use Illuminate\Http\JsonResponse;

interface IUserService
{
    /**
     * @return JsonResponse
     */
    public function getUsersDatatable():JsonResponse;

    /**
     * @param int $id
     * @return User|null
     */
    public function findUser(int $id): ?User;

    /**
     * @param CreateUserDto $dto
     * @return User|null
     */
    public function createUser(CreateUserDto $dto): ?User;

    /**
     * @param int $id
     * @param UpdateUserDto $dto
     * @return bool
     */
    public function updateUser(int $id, UpdateUserDto $dto): bool;

    /**
     * @param int $id
     * @return bool
     */
    public function deleteUser(int $id): bool;
}
