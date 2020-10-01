<?php


namespace Faza13\Cart\Middlewares;


use Closure;

class ClientId
{
    public function handle($request, Closure $next)
    {
        $request->merge([
            'client_id' => $request->bearerToken(),
        ]);

        return $next($request);
    }
}
