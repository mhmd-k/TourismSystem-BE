<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class CheckAuthorizationHeader
{
    public function handle(Request $request, Closure $next)
    {
        $authorizationHeader = $request->header('Authorization');

        if (!$authorizationHeader || !Str::startsWith($authorizationHeader, 'Basic ')) {
            return response()->json(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        // Extract the token from the header
        $token = substr($authorizationHeader, 6);

        $string = base64_decode($token);
        list($name, $password) = explode(':', $string);

        $user = User::where([
            ['name', '=', $name],
            ['password', '=', $password],
        ])->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid Token'], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}