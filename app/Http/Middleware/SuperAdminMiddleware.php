<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    /**
     * Yalnız super admin girişinə icazə verir.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || $user->role !== 'super_admin') {
            abort(403, 'Bu səhifəyə giriş icazəniz yoxdur.');
        }

        return $next($request);
    }
}
