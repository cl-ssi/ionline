<?php

namespace App\Http\Middleware\Warehouse;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureStore
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $store = $request->route('store');
        $stores = Auth::user()->stores;

        $roles = Auth::user()->getRoleNames();
        $role = 'Store: Super admin';

        if($stores->contains($store->id) || $roles->contains($role))
        {
            return $next($request);
        }

        session()->flash('danger', 'No posee permiso sobre la bodega.');
        return redirect()->route('warehouse.store.welcome');
    }
}
