<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;

class LoginThrottle
{
    public function handle(Request $request, Closure $next)
    {
        $maxAttempts = 5;
        $decaySeconds = 60;

        $key = 'login-attempts:' . $request->ip() . ':' . $request->email;

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);

            return response()->json([
                'status' => false,
                'message' => __('Too many login attempts. Please try again in :seconds seconds.', ['seconds' => $seconds]),
            ], 429);
        }

        // Hit the rate limiter
        RateLimiter::hit($key, $decaySeconds);

        return $next($request);
    }
}
