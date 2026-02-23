<?php

namespace App\Http\Middleware;

use Application\Contracts\Providers\RateLimiterInterface;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedisRateLimiterMiddleware
{
    public function __construct(
        private readonly RateLimiterInterface $rateLimiter
    ) {}

    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, mixed $limit = 10, mixed $windowSeconds = 60): Response
    {
        $key = $this->resolveKey($request);

        if (! $this->rateLimiter->allow(
            $key,
            windowSeconds: (int) $windowSeconds,
            limit: (int) $limit,
        )) {
            return response()->json(
                ['message' => 'Too many requests'],
                429
            );
        }

        return $next($request);
    }

    private function resolveKey(Request $request): string
    {
        return 'rate:'.(
            $request->user()?->id
            ?? $request->ip()
        );
    }
}
