<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $msg = '';
        $token = $request->header('Authorization');
        // $authenticate = false;
        if ($token) {
            $msg .= " ada token $token ";
            // $authenticate = true;
            $user = User::where('remember_token', $token)->first();
            if ($user) {
                Auth::login($user);
                return $next($request);
            }
            $msg .= " takada user";
        }
        return response()->json([
            "errors" => [
                "message" => [
                    "unauthorized"
                ]
            ]
        ])->setStatusCode(401);
    }
}
