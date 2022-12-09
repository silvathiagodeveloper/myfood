<?php

namespace App\Http\Middleware;

use App\Exceptions\TenantTokenException;
use App\Repositories\Admin\TenantRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Closure;

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
        if(empty($request->token_company))
        {
            throw new TenantTokenException('token_company não informado', 404);
        } else {
            $tenantRep = new TenantRepository();
            try {
                $tenant = $tenantRep->getByUuid($request->token_company);
            } catch(ModelNotFoundException $e) {
                throw new TenantTokenException('token_company inválido', 404);
            }
            $user = $request->user();
            $user->tenant_id = $tenant->id;
            $oldUser = session()->get('user');
            session()->put('user',$user);
            session()->put('oldUser',$oldUser);
        }

        return $next($request);
    }
}