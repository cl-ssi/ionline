<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;

class Drugs
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $now = Carbon::now();

        $start = Carbon::createFromTimeString('07:30');
        $end = Carbon::createFromTimeString('17:00');

        if ($now->between($start, $end)) {
            return $next($request);
        }

		return abort(401);
    }
}
