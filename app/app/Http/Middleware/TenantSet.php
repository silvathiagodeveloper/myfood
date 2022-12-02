<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use App\Repositories\Admin\TenantRepository;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TenantSet
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
        if(!empty($request->tenant))
        {
            $tenantRep = new TenantRepository();
            $tenant = $tenantRep->getByUuid($request->tenant);
            $user = $request->user();
            $user->tenant_id = $tenant->id;
            $oldUser = session()->get('user');
            session()->put('user',$user);
            session()->put('oldUser',$oldUser);
        }

        return $next($request);
    }
}