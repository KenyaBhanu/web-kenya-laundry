<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LevelMiddleware
{
    public function handle(Request $request, Closure $next, ...$levels)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userLevel = Auth::user()->level?->level_name;

        if (!$userLevel || !in_array($userLevel, $levels)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}