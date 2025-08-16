<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }

        // Set RTL direction for Arabic
        if (App::getLocale() === 'ar') {
            view()->share('isRTL', true);
            view()->share('direction', 'rtl');
        } else {
            view()->share('isRTL', false);
            view()->share('direction', 'ltr');
        }

        return $next($request);
    }
} 