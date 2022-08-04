<?php

namespace App\Http\Middleware\Warehouse;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureCategory
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
        $category = $request->route('category');

        if($category->store_id == $store->id)
        {
            return $next($request);
        }

        session()->flash('danger', 'No posee permiso sobre la categoría.');
        return redirect()->route('warehouse.store.welcome');
    }
}
