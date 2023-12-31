<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticateStudent
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $type =  $user->user_type_id;

        if ($type == 4) {
            return $next($request);
        }

        return redirect()->route("unauthorized");
    }
}
