<?php

namespace App\Enums;

enum RoleEnum: string
{
    case SUPER_ADMIN = 'Super Admin';

    case ADMIN = 'Admin';

    case SCHOOL = 'School';

    case STUDENT = 'Student';

    case CONSULTANT = 'Consultant';

    /**
     * @return array
     */
    public static function all(): array
    {
        return array_column(RoleEnum::cases(), 'value');
    }
}
