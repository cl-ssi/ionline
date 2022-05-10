<?php

namespace App\Http\Middleware\Warehouse;

use Closure;
use Illuminate\Http\Request;

class EnsureDestination
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
        $destination = $request->route('destination');

        if($destination->store_id == $store->id)
        {
            return $next($request);
        }

        session()->flash('danger', 'No posee permiso sobre el destino.');
        return redirect()->route('warehouse.store.welcome');
    }
}
