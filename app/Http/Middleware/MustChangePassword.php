<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MustChangePassword
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
        /** Si no es un login desde switch */
        if(!session()->has('god')) {
            /** Si tiene un password seteado y no está seteado el campo password_changed_at y el login es de tipo local */
            if (isset($request->user()->password) AND !isset($request->user()->password_changed_at) AND session('loginType') == 'local')
            {
                return redirect()->route('rrhh.users.password.edit');
            }
        }

        return $next($request);
    }
}
