<?php
use Illuminate\Support\Facades\Route;

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
