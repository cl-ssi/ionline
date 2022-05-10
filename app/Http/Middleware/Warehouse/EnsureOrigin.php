<?php

namespace App\Http\Middleware\Warehouse;

use Closure;
use Illuminate\Http\Request;

class EnsureOrigin
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
        $origin = $request->route('origin');

        if($origin->store_id == $store->id)
        {
            return $next($request);
        }

        session()->flash('danger', 'No posee permiso sobre el origen.');
        return redirect()->route('warehouse.store.welcome');
    }
}
