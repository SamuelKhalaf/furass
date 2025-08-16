<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

interface IUserRepository
{
    /**
     * @return Builder
     */
    public function getAll(): Builder;

    /**
     * @param int $id
     * @return User|null
     */
    public function findUserById(int $id): ?User;

    /**
     * @param array $userData
     * @return User
     */
    public function create(array $userData): User;

    /**
     * @param int $id
     * @param array $data
     * @return User|null
     */
    public function update(int $id , array $data): ?User;

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}
