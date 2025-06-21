<?php

namespace App\Dto;

class UpdateUserDto
{
    private string $name;

    private string $email;

    private string $phone_number;

    private string $role;

    private int $is_active;

    /**
     * @param string $name
     * @param string $email
     * @param string $phone_number
     * @param string $role
     * @param integer $is_active
     */
    public function __construct(string $name, string $email, string $phone_number, string $role , int $is_active)
    {
        $this->name = $name;
        $this->email = $email;
        $this->phone_number = $phone_number;
        $this->role = $role;
        $this->is_active = $is_active;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhoneNumber(): string
    {
        return $this->phone_number;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getIsActive(): int
    {
        return $this->is_active;
    }
    /**
     * @return array
     */
    public function toArray():array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'role' => $this->role,
            'is_active' => $this->is_active
        ];
    }

}
