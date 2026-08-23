<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class CheckInactivity
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $token = $request->bearerToken();
            if ($token) {
                $accessToken = PersonalAccessToken::findToken($token);
                if ($accessToken) {
                    $lastActivity = $accessToken->last_activity_at;
                    $inactivityTimeout = config('sanctum.inactivity_timeout', 30);

                    if ($lastActivity && Carbon::parse($lastActivity)->diffInMinutes(now()) > $inactivityTimeout) {
                        $accessToken->delete();

                        return response()->json(['message' => 'Session expired due to inactivity'], 401);
                    }

                    $accessToken->forceFill(['last_activity_at' => now()])->save();
                }
            }
        }

        return $next($request);
    }
}
