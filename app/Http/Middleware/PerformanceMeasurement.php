<?php

namespace App\Http\Middleware;

use App\Foundation\Performance\Measurement;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class PerformanceMeasurement
{

    /**
     * When you set roles, performance measurement will only be available to users with specific role
     * set empty array to make it available for all
     *
     * @var array
     */
    public array $roles = ['sudo'];

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if performance measurement is enabled:
        if (!env('APP_DEBUG', false)) return $next($request);

        // Check for roles based measurement
        if (
            count($this->roles) > 0
            && (!auth()->check())
            || count($this->roles) > 0
            && auth()->check()
            && !in_array(auth()->user()->role->title ?? '-', $this->roles)
        ) {
            return $next($request);
        }

        try {
            /** @var \Illuminate\Http\Response $response */
            $response = $next($request);
        } catch (Throwable $e) {
            throw $e;
        }

        (new Measurement)->modifyResponse($request, $response);

        return $response;
    }
}
