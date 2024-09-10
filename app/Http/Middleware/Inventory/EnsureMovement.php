<?php

namespace App\Http\Middleware\Inventory;

use Closure;
use Illuminate\Http\Request;

class EnsureMovement
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
        $movement = $request->route('movement');

        if($movement->responsibleUser->id == auth()->id())
            return $next($request);

        session()->flash('danger', 'Ud. no posee los permisos para ver los detalles del movimiento.');
        return redirect()->route('inventories.pending-movements');
    }
}
