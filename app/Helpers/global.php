<?php
use Illuminate\Support\Facades\Route;

if (!function_exists('setActiveClass')) {
    function setActiveClass($routes, $class = 'active')
    {
        return in_array(Route::currentRouteName(), (array) $routes) ? $class : '';
    }
}

if (!function_exists('setMenuOpenClass')) {
    function setMenuOpenClass($routes, $class = 'show here')
    {
        return in_array(Route::currentRouteName(), (array) $routes) ? $class : '';
    }
}
