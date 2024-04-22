<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Dpd;
use Symfony\Component\HttpFoundation\Response;

class Deptdpd
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $depts = Dpd::distinct()->pluck('dept');
        view()->share('depts', $depts);

        return $next($request);
    }
}
