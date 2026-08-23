<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LogAllRequests
{
    /**
     * Routes you want to skip logging.
     *
     * @var list<string>
     */
    protected array $exceptRoutes = [
        'login',
        'register',
        'password/reset',
        'password/email',
        'password/confirm',
        'sanctum/csrf-cookie',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        foreach ($this->exceptRoutes as $route) {
            if ($request->is($route)) {
                return $next($request);
            }
        }

        $response = $next($request);

        activity('Frontend Request')
            ->causedBy(Auth::user())
            ->withProperties([
                'method' => $request->method(),
                'path' => $request->path(),
                'status' => $response->getStatusCode(),
                'user_id' => Auth::id(),
                'ip_address' => $request->ip(),
            ])
            ->log('Request made');

        return $response;
    }
}
