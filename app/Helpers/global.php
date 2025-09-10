<?php
use Illuminate\Support\Facades\Route;
use App\Enums\RoleEnum;

if (!function_exists('setActiveClass')) {
    function setActiveClass($routes, $class = 'active')
    {
        $currentRouteName = Route::currentRouteName();
        $currentParams = request()->route()->parameters();

        foreach ((array)$routes as $route) {
            if (is_array($route)) {
                $routeName = key($route);
                $routeParams = $route[$routeName];

                if ($routeName === $currentRouteName) {
                    $allMatch = true;
                    foreach ($routeParams as $key => $value) {
                        if (!isset($currentParams[$key]) || (string)$currentParams[$key] !== (string)$value) {
                            $allMatch = false;
                            break;
                        }
                    }
                    if ($allMatch) return $class;
                }
            } elseif ($route === $currentRouteName) {
                return $class;
            }
        }

        return '';
    }
}

if (!function_exists('setMenuOpenClass')) {
    function setMenuOpenClass($routes, $class = 'show here')
    {
        return in_array(Route::currentRouteName(), (array) $routes) ? $class : '';
    }
}
function getStatusColor($status) {
    switch ($status) {
        case 'active': return 'primary';
        case 'attended': return 'success';
        case 'evaluated': return 'info';
        case 'skipped': return 'warning';
        default: return 'secondary';
    }
}

if (!function_exists('getUserAvatar')) {
    function getUserAvatar($user = null) {
        if (!$user) {
            $user = auth()->user();
        }
        
        if (!$user) {
            return asset('assets/media/avatars/300-1.jpg'); // Default avatar
        }
        
        // Check if user has avatar/logo based on role
        if ($user->hasRole(RoleEnum::SCHOOL->value)) {
            $school = \App\Models\School::where('user_id', $user->id)->first();
            if ($school && $school->logo) {
                return \Storage::url($school->logo);
            }
        } elseif ($user->hasRole(RoleEnum::STUDENT->value)) {
            $student = \App\Models\Student::where('user_id', $user->id)->first();
            if ($student && $student->avatar) {
                return \Storage::url($student->avatar);
            }
        }
        
        // Return default avatar if no custom avatar/logo exists
        return asset('assets/media/avatars/300-1.jpg');
    }
}
