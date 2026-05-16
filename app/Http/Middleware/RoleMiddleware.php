<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Spatie\Permission\Exceptions\UnauthorizedException;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!$request->user()) {
            throw UnauthorizedException::notLoggedIn();
        }

        $roles = is_array($role) ? $role : explode('|', $role);
        
        foreach ($roles as $roleName) {
            if ($request->user()->hasRole($roleName)) {
                return $next($request);
            }
        }

        throw UnauthorizedException::forRoles($roles);
    }
}
