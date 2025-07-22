<?php
namespace App\Repositories\implementation;

use App\Enums\RoleEnum;
use App\Models\User;
use App\Repositories\IUserRepository;
use Exception;
use Illuminate\Database\Eloquent\Builder;

class UserRepository implements IUserRepository
{
    /**
     * @return Builder
     */
    public function getAll(): Builder
    {
        return User::select('id', 'name', 'email','phone_number','role','created_at')
            ->whereNotIn('role',[RoleEnum::CONSULTANT->value,RoleEnum::SCHOOL->value,RoleEnum::STUDENT->value])
            ->orderBy('id','desc');
    }

    public function findUserById(int $id): ?User
    {
        return User::find($id);
    }

    /**
     * @param array $userData
     * @return User
     */
    public function create(array $userData): User
    {
        return User::create($userData);
    }

    /**
     * @param int $id
     * @param array $data
     * @return User|null
     */
    public function update(int $id, array $data): ?User
    {
        try {
            $user = $this->findUserById($id);

            $user->update($data);

            return $user;
        } catch (Exception $e) {

            return null;
        }
    }

    public function delete(int $id):bool
    {

        try {
            $user = $this->findUserById($id);
            $user->syncRoles([]);// Remove assigned roles before deleting

            return $user->delete();
        } catch (Exception $e) {
            return false;
        }
    }
}
