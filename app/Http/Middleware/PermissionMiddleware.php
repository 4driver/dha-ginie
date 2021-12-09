<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $permission = null)
    {
        if ($permission !== null && !Auth::guard('api')->user()->hasPermission($permission)) {
            return $this->unauthorizedResponse();
        }

        return $next($request);
    }

    public function unauthorizedResponse($error = 'Your don\'t have right to access this feature.', $code = 403)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        return response()->json($response, $code);
    }
}
