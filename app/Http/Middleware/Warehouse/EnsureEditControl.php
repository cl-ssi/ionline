<?php

namespace App\Http\Middleware\Warehouse;

use App\Models\Warehouse\Control;
use Closure;
use Illuminate\Http\Request;

class EnsureEditControl
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
        $control = $request->route('control');

        if($control->isOpen())
        {
            return $next($request);
        }

        session()->flash('danger', "El $control->type_format #$control->id no se puede editar.");
        return redirect()->route('warehouse.controls.index', [
            'store' => $control->store,
            'type' => $control->isReceiving() ? 'receiving' : 'dispatch',
        ]);
    }
}
