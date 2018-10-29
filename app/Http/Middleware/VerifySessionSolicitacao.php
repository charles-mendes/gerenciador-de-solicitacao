<?php

namespace App\Http\Middleware;

use Closure;

class VerifySessionSolicitacao
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // dd('teste');
        session(['novaSolicitacao' => new \stdClass() ]);
        return $next($request);
    }
}
