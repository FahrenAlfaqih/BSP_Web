<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Sertifikasi;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NamaProgramMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $namaPrograms = Sertifikasi::distinct()->pluck('namaProgram');
        view()->share('namaPrograms', $namaPrograms);

        return $next($request);
    }
}
