<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param $roleName
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next, $roleName): Response|RedirectResponse
    {
        if (Auth::user()->role->name === $roleName) {
            return response([
                "message" => "Not for you",
                "error" => "wrong role"
            ], 403);
        }
        return $next($request);
    }
}
