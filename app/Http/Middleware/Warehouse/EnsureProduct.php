<?php

namespace App\Http\Middleware\Warehouse;

use Closure;
use Illuminate\Http\Request;

class EnsureProduct
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
        $product = $request->route('product');

        if($product->store_id != $store->id)
        {
            session()->flash('danger', 'No posee permiso sobre el producto.');
            return redirect()->route('warehouse.store.welcome');
        }

        return $next($request);
    }
}
