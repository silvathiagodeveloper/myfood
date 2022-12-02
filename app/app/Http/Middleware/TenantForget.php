<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use App\Repositories\Admin\TenantRepository;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TenantForget
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $response = $next($request);
        $olduser = session()->put('oldUser');
        if(!empty($olduser)) {
            session()->put('user',$olduser);
        } else {
            session()->forget('user');
        }
        session()->forget('oldUser');

        return $response;
    }
}