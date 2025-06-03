<?php

namespace App\Enums;

enum RoleEnum: string
{
    case ADMIN = 'Admin';
    case MANAGER = 'Manager';
    case DEFAULT_USER = 'Default User';

    /**
     * @return array
     */
    public static function all(): array
    {
        return array_column(RoleEnum::cases(), 'value');
    }
}
