<?php
namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;

/**
 * Class ApiVersion
 * @package App\Http\Middleware
 */
class ApiVersion
{
    /**
     * Handle an incoming request.
     *
     * @param  Request $request
     * @param  Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard)
    {
        config(['app.api.version' => $guard]);
        return $next($request);
    }
}