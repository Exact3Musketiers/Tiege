<?php

namespace App\Http\Middleware;

use App\Services\Wiki;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HasValidHash
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->has('pg')) {
            if (! $request->has('hash')) {
                $request->session()->flash('urlTampering', 'De hash mag niet worden verwijderd');
                abort('403');
            }
            if ($request->hash !== Wiki::hashPage($request->pg)) {
                $request->session()->flash('urlTampering', 'Skippen via het url mag volstrekt niet!');
                abort('403');
            }
        }

        return $next($request);
    }
}
