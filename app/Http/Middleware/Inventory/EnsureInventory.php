<?php

namespace App\Http\Middleware\Inventory;

use App\Models\Profile\Subrogation;
use Closure;
use Illuminate\Http\Request;

class EnsureInventory
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $inventory = $request->route('inventory');
        $userId = auth()->id();
        $isAuthority = auth()->user()->getAmIAuthorityFromOuAttribute()->isNotEmpty();

        $responsibleIds = [$userId];

        if ($isAuthority) {
            $authorities = auth()->user()->getAmIAuthorityFromOuAttribute();
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

        if (in_array($inventory->user_responsible_id, $responsibleIds) || $inventory->user_using_id == auth()->id()) {
            return $next($request);
        }

        session()->flash('danger', 'Ud. no posee los permisos para ver los detalles del inventario.');

        return redirect()->route('inventories.assigned-products');
    }
}
