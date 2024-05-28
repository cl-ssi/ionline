<?php

namespace App\Http\Middleware\Inventory;

use App\Models\Inv\Inventory;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile\Subrogation;

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
        $userId = Auth::id();
        $isAuthority = Auth::user()->getAmIAuthorityFromOuAttribute()->isNotEmpty();
        
        $responsibleIds = [$userId];

        if ($isAuthority) {
            $authorities = Auth::user()->getAmIAuthorityFromOuAttribute();
            foreach ($authorities as $authority) {
                $subrogations = Subrogation::where('level', 1)
                    ->where('organizational_unit_id', $authority->organizational_unit_id)
                    ->where('type', 'manager')
                    ->get();
                
                $subrogatedIds = $subrogations->pluck('user_id')->toArray();
                $responsibleIds = array_merge($responsibleIds, $subrogatedIds);
            }
            $responsibleIds = array_unique($responsibleIds);
        }

        if (in_array($inventory->user_responsible_id, $responsibleIds) || $inventory->user_using_id == Auth::id()) {
            return $next($request);
        }

        session()->flash('danger', 'Ud. no posee los permisos para ver los detalles del inventario.');
        return redirect()->route('inventories.assigned-products');
    }
}