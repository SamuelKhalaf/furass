<?php

namespace App\Enums;

enum PermissionEnum : string
{
    case MANAGE_EXAMS = 'Manage Exams';

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

    // School Permissions
    case LIST_SCHOOLS = 'List Schools';
    case CREATE_SCHOOLS = 'Create Schools';
    case UPDATE_SCHOOLS = 'Update Schools';
    case DELETE_SCHOOLS = 'Delete Schools';

    // Students
    case LIST_STUDENTS  = 'List Students';
    case CREATE_STUDENTS = 'Create Students';
    case UPDATE_STUDENTS = 'Update Students';
    case DELETE_STUDENTS = 'Delete Students';


    // Consultant Permissions
    case LIST_CONSULTANTS = 'List Consultants';
    case CREATE_CONSULTANTS = 'Create Consultants';
    case UPDATE_CONSULTANTS = 'Update Consultants';
    case DELETE_CONSULTANTS = 'Delete Consultants';

    // Consultation Permissions
    case LIST_CONSULTATIONS = 'List Consultations';
    case CREATE_CONSULTATIONS = 'Create Consultations';
    case UPDATE_CONSULTATIONS = 'Update Consultations';
    case DELETE_CONSULTATIONS = 'Delete Consultations';

    // Trip Permissions
    case LIST_TRIPS = 'List Trips';
    case CREATE_TRIPS = 'Create Trips';
    case UPDATE_TRIPS = 'Update Trips';
    case DELETE_TRIPS = 'Delete Trips';

    // Workshop Permissions
    case LIST_WORKSHOPS = 'List Workshops';
    case CREATE_WORKSHOPS = 'Create Workshops';
    case UPDATE_WORKSHOPS = 'Update Workshops';
    case DELETE_WORKSHOPS = 'Delete Workshops';

    // Program Permissions
    case LIST_PROGRAMS = 'List Programs';
    case CREATE_PROGRAMS = 'Create Programs';
    case UPDATE_PROGRAMS = 'Update Programs';

    // Event Permissions
    case LIST_EVENTS = 'List Events';
    case CREATE_EVENTS = 'Create Events';
    case UPDATE_EVENTS = 'Update Events';
    case DELETE_EVENTS = 'Delete Events';

    // News Permissions
    case LIST_NEWS = 'List News';
    case CREATE_NEWS = 'Create News';
    case UPDATE_NEWS = 'Update News';
    case DELETE_NEWS = 'Delete News';

    // Pages Permissions
    case LIST_PAGES = 'List Pages';
    case CREATE_PAGES = 'Create Pages';
    case UPDATE_PAGES = 'Update Pages';
    case DELETE_PAGES = 'Delete Pages';

    // exams Permissions
    case LIST_EXAMS   = 'List Exams';
    case CREATE_EXAMS = 'Create Exams';
    case UPDATE_EXAMS = 'Update Exams';
    case DELETE_EXAMS = 'Delete Exams';

    // Notification Permissions

    case SEND_NOTIFICATIONS = 'Send Notifications';
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

    public static function schoolPermissions(): array
    {
        return [
            self::LIST_SCHOOLS->value,
            self::CREATE_SCHOOLS->value,
            self::UPDATE_SCHOOLS->value,
            self::DELETE_SCHOOLS->value,
        ];
    }

    public static function studentPermissions(): array
    {
        return [
            self::LIST_STUDENTS->value,
            self::CREATE_STUDENTS->value,
            self::UPDATE_STUDENTS->value,
            self::DELETE_STUDENTS->value,
        ];
    }
    public static function consultantPermissions(): array
    {
        return [
            self::LIST_CONSULTANTS->value,
            self::CREATE_CONSULTANTS->value,
            self::UPDATE_CONSULTANTS->value,
            self::DELETE_CONSULTANTS->value,
        ];
    }

    public static function consultationPermissions(): array
    {
        return [
            self::LIST_CONSULTATIONS->value,
            self::CREATE_CONSULTATIONS->value,
            self::UPDATE_CONSULTATIONS->value,
            self::DELETE_CONSULTATIONS->value,
        ];
    }

    public static function tripPermissions(): array
    {
        return [
            self::LIST_TRIPS->value,
            self::CREATE_TRIPS->value,
            self::UPDATE_TRIPS->value,
            self::DELETE_TRIPS->value,
        ];
    }

    public static function workshopPermissions(): array
    {
        return [
            self::LIST_WORKSHOPS->value,
            self::CREATE_WORKSHOPS->value,
            self::UPDATE_WORKSHOPS->value,
            self::DELETE_WORKSHOPS->value,
        ];
    }

    public static function programPermissions(): array
    {
        return [
            self::LIST_PROGRAMS->value,
            self::CREATE_PROGRAMS->value,
            self::UPDATE_PROGRAMS->value,
        ];
    }

    public static function eventPermissions(): array
    {
        return [
            self::LIST_EVENTS->value,
            self::CREATE_EVENTS->value,
            self::UPDATE_EVENTS->value,
            self::DELETE_EVENTS->value,
        ];
    }

    public static function newsPermissions(): array
    {
        return [
            self::LIST_NEWS->value,
            self::CREATE_NEWS->value,
            self::UPDATE_NEWS->value,
            self::DELETE_NEWS->value,
        ];
    }

    public static function ExamsPermissions(): array
    {
        return [
            self::LIST_EXAMS->value,
            self::CREATE_EXAMS->value,
            self::UPDATE_EXAMS->value,
            self::DELETE_EXAMS->value,
        ];
    }



}
