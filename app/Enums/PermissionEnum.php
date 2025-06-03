<?php

namespace App\Enums;

enum PermissionEnum : string
{
    // Dashboard
    case VIEW_DASHBOARD = 'View Dashboard';

    // Users
    case LIST_USERS = 'List Users';
    case CREATE_USERS = 'Create Users';
    case UPDATE_USERS = 'Update Users';
    case DELETE_USERS = 'Delete Users';

    // Roles
    case LIST_ROLES = 'List Roles';
    case VIEW_ROLES = 'View Roles';
    case CREATE_ROLES = 'Create Roles';
    case UPDATE_ROLES = 'Update Roles';
    case DELETE_ROLES = 'Delete Roles';

    // Permissions
    case LIST_PERMISSIONS = 'List Permissions';
    case CREATE_PERMISSIONS = 'Create Permissions';
    case DELETE_PERMISSIONS = 'Delete Permissions';

    /**
     * @return array
     */
    public static function all(): array
    {
        return array_column(PermissionEnum::cases(), 'value');
    }

    /**
     * Get all permissions related to users.
     */
    public static function userPermissions(): array
    {
        return [
            self::LIST_USERS->value,
            self::CREATE_USERS->value,
            self::UPDATE_USERS->value,
            self::DELETE_USERS->value,
        ];
    }

    /**
     * Get all permissions related to roles.
     * @return array
     */
    public static function rolePermissions(): array
    {
        return [
            self::LIST_ROLES->value,
            self::CREATE_ROLES->value,
            self::UPDATE_ROLES->value,
            self::DELETE_ROLES->value,
        ];
    }


    /**
     * Get all the permissions related to permissions.
     * @return array
     */
    public static function permissionPermissions(): array
    {
        return [
            self::LIST_PERMISSIONS->value,
            self::CREATE_PERMISSIONS->value,
            self::DELETE_PERMISSIONS->value,
        ];
    }

}
