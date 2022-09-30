<?php

namespace App\Http\Middleware\Inventory;

use App\Models\Inv\Inventory;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureInventory
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
        $inventory = Inventory::find($request->route('inventory'));

        if($inventory->responsible->id == Auth::id() || $inventory->using->id == Auth::id())
            return $next($request);

        session()->flash('danger', 'Ud. no posee los permisos para ver los detalles del inventario.');
        return redirect()->route('inventories.assigned-products');
    }
}
