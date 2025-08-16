<?php

namespace App\Enums;

enum RoleEnum: string
{
    case ADMIN = 'Admin';

    case SUB_ADMIN = 'Sub Admin';
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
