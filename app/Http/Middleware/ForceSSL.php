<?php

namespace CreativeHotHouse\Http\Middleware;

use Closure;

class ForceSSL
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->secure() && in_array(config('app.env'), ['stage', 'production'])) {
            return redirect()->secure($request->getRequestUri());
        }

        return $next($request);
    }
}
